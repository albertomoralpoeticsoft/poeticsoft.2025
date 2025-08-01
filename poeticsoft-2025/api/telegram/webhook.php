<?php

function poeticsoft_telegram_webhook(WP_REST_Request $req) {

  $res = new WP_REST_Response();

  try {
    
    $input = file_get_contents("php://input");
    $update = json_decode($input, true);

    $data = poeticsoft_telegram_messagedata($update);

    $result = poeticsoft_telegram_sendmessage(
      $data['destination'],
      $data['text'] . ' ' . $data['name']
    ); 

    plugin_log($update);

    $res->set_data('OK');
    
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
  }
);