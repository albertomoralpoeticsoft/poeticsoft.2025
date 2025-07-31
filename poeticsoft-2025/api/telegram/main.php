<?php

function poeticsoft_telegram_sendmessage(
  $channel = 'telegram_ps_channelid',
  $message = 'Message'
) {

  $data = poeticsoft_api_data();
  $telegramtoken = $data['telegram_ps_token'];
  $apiurl = 'https://api.telegram.org/bot' . $telegramtoken . '/';
  $channelid = $data[$channel];
  $params = [
    'chat_id' => $channelid,
    'text' => $message,
    'parse_mode' => 'HTML'
  ];
  $url = $apiurl . 'sendMessage?' . http_build_query($params);

  $response = wp_remote_get($url);

  if (
    !is_array($response) 
    || 
    is_wp_error($response) 
  ) {      
    
    throw new Exception(
      $response->get_error_message(), 
      500
    );
  }

  return json_decode($response['body']);
}

function poeticsoft_telegram_sendmedia(
  $channel = 'telegram_ps_channelid',
  $mediaurl = 'https://noshibari.art/wp-content/uploads/sites/5/2025/03/IMG_0006-scaled.jpg',
  $message = 'Message'
) {

  $data = poeticsoft_api_data();
  $telegramtoken = $data['telegram_ps_token'];
  $apiurl = 'https://api.telegram.org/bot' . $telegramtoken . '/';
  $channelid = $data[$channel];
  $params = [
    'chat_id' => $channelid,
    'photo' => $mediaurl,
    'caption' => $message,
    'parse_mode' => 'HTML'
  ];
  $url = $apiurl . 'sendPhoto?' . http_build_query($params);

  $response = wp_remote_get($url);

  if (
    !is_array($response) 
    || 
    is_wp_error($response) 
  ) {      
    
    throw new Exception(
      $response->get_error_message(), 
      500
    );
  }

  return json_decode($response['body']);
}

function poeticsoft_telegram_messagedata($update) { 

  $data = [
    'destination' => '',
    'name' => '',
    'text' => ''
  ];

  if(isset($update['message'])) {

    if($update['message']['chat']['type'] == 'supergroup') {        

      $data['destination'] = 'telegram_ps_groupid';

    } else {

      $data['destination'] = 'telegram_ps_botid';
    }

    $data['name'] = $update['message']['from']['first_name'] . 
                    ' ' . 
                    $update['message']['from']['last_name'];
    $data['text'] = $update['message']['text'];
  }
  
  if(isset($update['channel_post'])) {

    $data['destination'] = 'telegram_ps_channelid';
    $data['name'] = $update['channel_post']['sender_chat']['title'];
    $data['text'] = $update['channel_post']['text'];
  }

  return $data;
}

function poeticsoft_telegram_webhook(WP_REST_Request $req) {

  $res = new WP_REST_Response();

  try {
    
    $input = file_get_contents("php://input");
    $update = json_decode($input, true);

    $data = poeticsoft_telegram_messagedata($update);

    $result = poeticsoft_telegram_sendmessage(
      $data['destination'],
      $data['text']
    ); 

    $res->set_data('OK');
    
  } catch (Exception $e) {
    
    $res->set_status($e->getCode());
    $res->set_data($e->getMessage());
  }

  return $res;
}

function poeticsoft_telegram_message(WP_REST_Request $req) {

  $res = new WP_REST_Response();

  try { 

    $params = $req->get_params();

    $result = poeticsoft_telegram_sendmessage(
      $params['destination'],
      $params['text']
    );    

    $res->set_data($result);
    
  } catch (Exception $e) {
    
    $res->set_status($e->getCode());
    $res->set_data($e->getMessage());
  }

  return $res;
}

function poeticsoft_telegram_media(WP_REST_Request $req) {

  $res = new WP_REST_Response();

  try { 

    $params = $req->get_params();

    $result = poeticsoft_telegram_sendmedia(
      $params['destination'],
      $params['mediaurl'],
      $params['text']
    );    

    $res->set_data($result);
    
  } catch (Exception $e) {
    
    $res->set_status($e->getCode());
    $res->set_data($e->getMessage());
  }

  return $res;
}

add_action(
  'rest_api_init',
  function () {

    register_rest_route(
      'poeticsoft/telegram',
      'webhook',
      array(
        array(
          'methods'  => 'POST',
          'callback' => 'poeticsoft_telegram_webhook',
          'permission_callback' => '__return_true'
        )
      )
    );

    register_rest_route(
      'poeticsoft/telegram',
      'message',
      array(
        array(
          'methods'  => 'POST',
          'callback' => 'poeticsoft_telegram_message',
          'permission_callback' => '__return_true'
        )
      )
    );

    register_rest_route(
      'poeticsoft/telegram',
      'media',
      array(
        array(
          'methods'  => 'POST',
          'callback' => 'poeticsoft_telegram_media',
          'permission_callback' => '__return_true'
        )
      )
    );
  }
);