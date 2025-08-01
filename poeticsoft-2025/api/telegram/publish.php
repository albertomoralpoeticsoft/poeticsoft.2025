<?php

require_once(WP_PLUGIN_DIR . '/poeticsoft-2025/tools/htmltomarkdown/vendor/autoload.php');
require_once(WP_PLUGIN_DIR . '/poeticsoft-2025/api/telegram/functions.php');

use League\HTMLToMarkdown\HtmlConverter;

function poeticsoft_telegram_disableonchange(WP_REST_Request $req) {

  $res = new WP_REST_Response();

  try {     

    $postid = $req->get_param('postid');
    update_post_meta(
      $postid,
      'poeticsoft_post_publish_telegram_publishonchange',
      false
    );

    $res->set_data('disabled');
    
  } catch (Exception $e) {
    
    $res->set_status($e->getCode());
    $res->set_data($e->getMessage());
  }

  return $res;
}

function poeticsoft_telegram_destinationlist(WP_REST_Request $req) {

  $res = new WP_REST_Response();

  try { 

    $list = [
      [
        'label' => 'Grupo',
        'value' => 'telegram_ps_groupid'
      ],
      [
        'label' => 'Canal',
        'value' => 'telegram_ps_channelid',
        'default' => true
      ]
    ];

    $res->set_data($list);
    
  } catch (Exception $e) {
    
    $res->set_status($e->getCode());
    $res->set_data($e->getMessage());
  }

  return $res;
}

function poeticsoft_telegram_publishwp(WP_REST_Request $req) {

  $res = new WP_REST_Response();

  try { 

    $type = $req->get_param('type');
    $destination = $req->get_param('destination');
    $postid = $req->get_param('postid');

    switch ($type) {

      case 'media':

        $sent = poeticsoft_telegram_publishmedia($destination, $postid);

        break;

      default:
      
        $sent = poeticsoft_telegram_publishpost($postid); 
        
        break;
    }

    $res->set_data($sent);
    
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
      'disableonchange',
      array(
        array(
          'methods'  => 'GET',
          'callback' => 'poeticsoft_telegram_disableonchange',
          'permission_callback' => '__return_true'
        )
      )
    );

    register_rest_route(
      'poeticsoft/telegram',
      'destinationlist',
      array(
        array(
          'methods'  => 'GET',
          'callback' => 'poeticsoft_telegram_destinationlist',
          'permission_callback' => '__return_true'
        )
      )
    );

    register_rest_route(
      'poeticsoft/telegram',
      'publishwp',
      array(
        array(
          'methods'  => 'GET',
          'callback' => 'poeticsoft_telegram_publishwp',
          'permission_callback' => '__return_true'
        )
      )
    );
  }
);