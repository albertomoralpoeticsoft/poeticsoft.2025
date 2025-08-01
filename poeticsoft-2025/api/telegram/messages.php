<?php

function poeticsoft_telegram_directmessage(WP_REST_Request $req) {

  $res = new WP_REST_Response();

  try { 

    $params = $req->get_params(); 

    $data = poeticsoft_api_data();
    $telegramtoken = $data['telegram_ps_token'];
    $apiurl = 'https://api.telegram.org/bot' . $telegramtoken . '/';
    $channelid = $params['destination'];
    $params = [
      'chat_id' => $channelid,
      'text' => $params['text'],
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

    $res->set_data(json_decode($response['body']));
    
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

    $result = poeticsoft_telegram_sendphoto(
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
      'directmessage',
      array(
        array(
          'methods'  => 'POST',
          'callback' => 'poeticsoft_telegram_directmessage',
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