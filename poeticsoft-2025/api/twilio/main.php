<?php

require_once(WP_PLUGIN_DIR . '/poeticsoft-2025/tools/twilio/vendor/autoload.php');

use Twilio\Rest\Client;

function poeticsoft_twilio_messaging_webhook(WP_REST_Request $req) {

  $res = new WP_REST_Response();

  try {    
    
    $params = $req->get_params();

    plugin_log('Twilio message', true);    
    plugin_log($params);

    header('Content-Type: text/xml; charset=utf-8');
    
    echo '<?xml version="1.0" encoding="UTF-8"?><Response><Message>Gracias, recibimos tu mensaje.</Message></Response>';
    
    exit;
    
  } catch (Exception $e) {
    
    $res->set_status($e->getCode());
    $res->set_data($e->getMessage());
  }

  return $res;
}

function poeticsoft_twilio_sandbox_message(WP_REST_Request $req) {

  $res = new WP_REST_Response();

  try {    
    
    $params = $req->get_params();

    plugin_log('Message', true);    
    plugin_log($params);

    header('Content-Type: text/xml; charset=utf-8');
    
    echo '<?xml version="1.0" encoding="UTF-8"?><Response><Message>Gracias, recibimos tu mensaje.</Message></Response>';
    
    exit;
    
  } catch (Exception $e) {
    
    $res->set_status($e->getCode());
    $res->set_data($e->getMessage());
  }

  return $res;
}

function poeticsoft_twilio_sandbox_callback(WP_REST_Request $req) {

  $res = new WP_REST_Response();

  try { 

    $params = $req->get_params();

    // plugin_log('Callback', true);    
    // plugin_log($params);
    
    header('Content-Type: text/xml; charset=utf-8', true);
    
    echo '<?xml version="1.0" encoding="UTF-8"?><Response/>';

    exit;
    
  } catch (Exception $e) {
    
    $res->set_status($e->getCode());
    $res->set_data($e->getMessage());
  }

  return $res;
}

function poeticsoft_twilio_api_messages(WP_REST_Request $req) {

  $res = new WP_REST_Response();

  try {     

    $sid = 'AC1c860a93157ed3b03311fe58fe616fc9';
    $token = 'b00ac436aedc927caad3379781dff1ee';
    $twilio = new Client($sid, $token);

    $messages = array_map(
      function($msg) {

        return [
          'sid' => $msg->sid,
          'from' => $msg->from,
          'to' => $msg->to,
          'body' => $msg->body,
          'status' => $msg->status,
          'direction' => $msg->direction,
          'dateSent' => $msg->dateSent ? 
            $msg->dateSent->format('Y-m-d H:i:s') 
            : 
            null
        ];        
      },
      $twilio->messages->read([], 100)
    );

    $res->set_data($messages);
    
  } catch (Exception $e) {
    
    $res->set_status($e->getCode());
    $res->set_data($e->getMessage());
  }

  return $res;
}

function poeticsoft_twilio_api_send(WP_REST_Request $req) {

  $res = new WP_REST_Response();

  try {     

    $sid = 'AC1c860a93157ed3b03311fe58fe616fc9';
    $token = 'b00ac436aedc927caad3379781dff1ee';
    $twilio = new Client($sid, $token);

    $result = $twilio->messages
    ->create(
      "whatsapp:+34629475867", 
      [
        "from" => "whatsapp:+14155238886",
        "body" => "Genial ya funciona la comunicacion por whatsapp del proyecto Plenitud Sexual Activa."
      ]
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
      'poeticsoft/twilio',
      'messaging/webhook',
      array(
        array(
          'methods'  => 'POST',
          'callback' => 'poeticsoft_twilio_messaging_webhook',
          'permission_callback' => '__return_true'
        )
      )
    );

    register_rest_route(
      'poeticsoft/twilio',
      'sandbox/message',
      array(
        array(
          'methods'  => 'POST',
          'callback' => 'poeticsoft_twilio_sandbox_message',
          'permission_callback' => '__return_true'
        )
      )
    );

    register_rest_route(
      'poeticsoft/twilio',
      'sandbox/callback',
      array(
        array(
          'methods'  => 'POST',
          'callback' => 'poeticsoft_twilio_sandbox_callback',
          'permission_callback' => '__return_true'
        )
      )
    );

    register_rest_route(
      'poeticsoft/twilio',
      'api/messages',
      array(
        array(
          'methods'  => 'GET',
          'callback' => 'poeticsoft_twilio_api_messages',
          'permission_callback' => '__return_true'
        )
      )
    );

    register_rest_route(
      'poeticsoft/twilio',
      'api/send',
      array(
        array(
          'methods'  => 'GET',
          'callback' => 'poeticsoft_twilio_api_send',
          'permission_callback' => '__return_true'
        )
      )
    );
  }
);