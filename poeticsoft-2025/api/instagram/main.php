<?php

require_once(WP_PLUGIN_DIR . '/poeticsoft-2025/tools/twilio/vendor/autoload.php');

use Twilio\Rest\Client;

function poeticsoft_instagram_app_webhook_callback(WP_REST_Request $req) {

  $res = new WP_REST_Response();

  try {    
    
    $params = $req->get_params();

    plugin_log('Instagram webhook callback');
    plugin_log($params, false);

    $res->set_data($params);

  } catch (Exception $e) {
    
    $res->set_status($e->getCode());
    $res->set_data($e->getMessage());
  }

  return $res;
}


function poeticsoft_instagram_app_webhook_verifytoken(WP_REST_Request $req) {

  $res = new WP_REST_Response();

  try {    
    
    $params = $req->get_params();

    plugin_log('Instagram webhook verify token');
    plugin_log($params, false);

    $res->set_data($params);

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
      'poeticsoft/instagram',
      'app/webhook/callback',
      array(
        array(
          'methods'  => 'POST',
          'callback' => 'poeticsoft_instagram_app_webhook_callback',
          'permission_callback' => '__return_true'
        )
      )
    );

    register_rest_route(
      'poeticsoft/instagram',
      'app/webhook/verifytoken',
      array(
        array(
          'methods'  => 'POST',
          'callback' => 'poeticsoft_instagram_app_webhook_verifytoken',
          'permission_callback' => '__return_true'
        )
      )
    );
  }
);