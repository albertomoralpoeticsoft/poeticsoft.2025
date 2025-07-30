<?php

function poeticsoft_telegram_webhook(WP_REST_Request $req) {

  $res = new WP_REST_Response();

  try {      

    $params = $req->get_params();   
    
    plugin_log('Telegram ---------------------------');
    plugin_log($params, false);

    $res->set_data($params);
    
  } catch (Exception $e) {
    
    $res->set_status($e->getCode());
    $res->set_data($e->getMessage());
  }

  return $res;
}

function poeticsoft_telegram_sendmessage(WP_REST_Request $req) {

  $res = new WP_REST_Response();

  try { 

    $data = poeticsoft_api_data();
    $telegramtoken = $data['telegram_token'];
    $apiurl = 'https://api.telegram.org/bot' . $telegramtoken . '/';
    $params = [
      'chat_id' => 'noshibari.art',
      'text' => '[Asistente NSA] Prueba envío de mensajes',
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

    $res->set_data($response);
    
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
      'sendmessage',
      array(
        array(
          'methods'  => 'post',
          'callback' => 'poeticsoft_telegram_sendmessage',
          'permission_callback' => '__return_true'
        )
      )
    );
  }
);