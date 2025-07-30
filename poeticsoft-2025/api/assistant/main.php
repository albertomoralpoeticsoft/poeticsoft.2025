<?php

require_once(WP_PLUGIN_DIR . '/poeticsoft-2025/tools/twilio/vendor/autoload.php');
require_once(WP_PLUGIN_DIR . '/poeticsoft-2025/tools/htmltomarkdown/vendor/autoload.php');

use Twilio\Rest\Client;
use League\HTMLToMarkdown\HtmlConverter;

function poeticsoft_assistant_sandbox_inituser(WP_REST_Request $req) {

  global $wpdb;
  require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

  $res = new WP_REST_Response();

  header('Content-Type: text/xml; charset=utf-8');

  try {    
    
    $params = $req->get_params();
    $user = $params['user'];
    $contextid = $params['contextid'];

    if(!$user || !$contextid) {

      throw new Exception(
        'Faltan datos [user, contextid]', 
        404
      ); 
    }

    $contextdoc = get_post($contextid);

    if(!$contextdoc) {

      throw new Exception(
        'No se encuentra el context doc ' . $contextid, 
        404
      ); 
    }

    $title = $contextdoc->post_title;
    $excerpt = $contextdoc->post_excerpt;
    $content = $contextdoc->post_content;

    $converter = new HtmlConverter([
      'strip_tags' => true,
      'preserve_comments' => true
    ]);
    $converter->getConfig()->setOption('hard_break', true);

    $markdown = $converter->convert($content);

    $profile = json_encode([
      'init-date' => date('Y-m-d H:i:s')
    ]);

    $history = json_encode([
      'model' => "gpt-3.5-turbo",
      'messages' => [
        [ 
          'role' => 'system', 
          'content' => $excerpt . PHP_EOL . $markdown  
        ]
      ],
      'functions' => [
        [
          "name" => "guardarDatoPerfil",
          "description" => "Guarda un campo del perfil del usuario",
          "parameters" => [
            "type" => "object",
            "properties" => [
              "campo" => [
                "type" => "string",
                "description" => "Nombre del campo a guardar, por ejemplo 'nombre', 'edad', etc."
              ],
              "valor" => [
                "type" => "string",
                "description" => "Valor del campo proporcionado por el usuario"
              ]
            ],
            "required" => ["campo", "valor"]
          ]
        ],
        [
          "name" => "hacerPregunta",
          "description" => "Enviar mensaje de whatsapp al usuario para seguir la conversación",
          "parameters" => [
            "type" => "object",
            "properties" => [
              "question" => [
                "type" => "string",
                "description" => "Pregunta al usuario para continuar la conversación"
              ]
            ],
            "required" => ["campo", "valor"]
          ]
        ]
      ],
      'function_call' => 'auto',
      'temperature' => 0,
      'n' => 1
    ]);

    $tablename = $wpdb->prefix . 'assistant_history';
    $result = $wpdb->query("
      SELECT * FROM $tablename
      WHERE user = '$user';
    ");

    if($result == 0) {

      $result = $wpdb->query("
        INSERT INTO $tablename 
        (
          user, 
          profile,
          history
        ) 
        VALUES 
        (
          '$user',
          '$profile', 
          'nuevo'
        );
      ");

    } else {

      $result = $wpdb->query("
        UPDATE $tablename
        SET         
          profile = '$profile',
          history = 'existente'
        WHERE user = '$user';
      ");
    }

    $res->set_data($result);
    
  } catch (Exception $e) {
    
    $res->set_status($e->getCode());
    $res->set_data($e->getMessage());
  }

  return $res;
}

function poeticsoft_assistant_sandbox_message(WP_REST_Request $req) {

  $res = new WP_REST_Response();

  header('Content-Type: text/xml; charset=utf-8');

  try {    
    
    $params = $req->get_params();
    $params['ChannelMetadata'] = json_decode($params['ChannelMetadata']);

    $username = $params['ProfileName'];
    $user = $params['WaId'];
    $message = $params['Body'];

    $message = 'Gracias, tu mensaje ' . $message . ' ha sido recibido, [' . $user . '] ' . $username;
    
    echo '<?xml version="1.0" encoding="UTF-8"?>
    <Response>
      <Message>' .
        $message .
      '</Message>
    </Response>';
    
  } catch (Exception $e) {
    
    echo '<?xml version="1.0" encoding="UTF-8"?>
    <Response>
      <Message>' .
        $e->getMessage() .
      '</Message>
    </Response>';
  }
  
  exit;
}

function poeticsoft_assistant_api_send(WP_REST_Request $req) {

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

function poeticsoft_assistant_api_test(WP_REST_Request $req) {

  $res = new WP_REST_Response();

  try {    
    
    $params = json_decode(file_get_contents(__DIR__ . '/message.json'));
    
    $data = $params->ChannelMetadata->data->context->ProfileName;
    
    $res->set_data($data);

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
      'poeticsoft/assistant',
      'sandbox/inituser',
      array(
        array(
          'methods'  => 'POST',
          'callback' => 'poeticsoft_assistant_sandbox_inituser',
          'permission_callback' => '__return_true'
        )
      )
    );

    register_rest_route(
      'poeticsoft/assistant',
      'sandbox/message',
      array(
        array(
          'methods'  => 'POST',
          'callback' => 'poeticsoft_assistant_sandbox_message',
          'permission_callback' => '__return_true'
        )
      )
    );

    register_rest_route(
      'poeticsoft/assistant',
      'api/send',
      array(
        array(
          'methods'  => 'GET',
          'callback' => 'poeticsoft_assistant_api_send',
          'permission_callback' => '__return_true'
        )
      )
    );

    register_rest_route(
      'poeticsoft/assistant',
      'api/test',
      array(
        array(
          'methods'  => 'GET',
          'callback' => 'poeticsoft_assistant_api_test',
          'permission_callback' => '__return_true'
        )
      )
    );
  }
);