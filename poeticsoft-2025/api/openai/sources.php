<?php

require_once(WP_PLUGIN_DIR . '/poeticsoft-2025/tools/dom.php');

function poeticsoft_openai_source(WP_REST_Request $req) {

  $res = new WP_REST_Response(); 

  try { 
    
    $source = $req->get_param('source');
    $sourcehtml = file_get_contents(dirname(__FILE__) . '/sources/source-' . $source . '.html');  
    $destfilename = dirname(__FILE__) . '/sources/dest-' . $source . '.html';
    $result = poeticsoft_dom_html($sourcehtml);
    $save = file_put_contents(
      $destfilename,
      $result
    );
    
    $res->set_data($save ? 'Guardado' : ' Error');  
    
  } catch (Exception $e) {
    
    $res->set_status($e->getCode());
    $res->set_data($e->getMessage());
  }

  return $res;
}

function poeticsoft_openai_manage(WP_REST_Request $req) {

  $res = new WP_REST_Response();

    try { 
    
    $data = poeticsoft_api_data();
    $url = $data['openai_url'];
    $authtoken = $data['openai_token']; 
    
    $source = $req->get_param('source');
    $sourcehtml = file_get_contents(dirname(__FILE__) . '/sources/dest-' . $source . '.html');
    $destmanagefile = dirname(__FILE__) . '/sources/manage-' . $source . '.md';
    $prompt = '
      Analiza y organiza en forma de documento estructurado en markdown 
      que contenga todo el contenido del siguiente texto 
      extraído de un documento HTML:
      \n\n
    ' . $sourcehtml;
    $data = [
      'model' => 'gpt-3.5-turbo', // o 'gpt-4' si tienes acceso
      'messages' => [
        [
          'role' => 'user', 
          'content' => $prompt 
        ]
      ],
      'temperature' => 0
    ];
    $json_data = wp_json_encode($data);

    $args = [
      'headers' => [
        'Content-Type' => 'application/json',
        'Authorization' => 'Bearer ' . $authtoken
      ],
      'body'    => $json_data,
      'method'  => 'POST',
      'data_format' => 'body',      
      'timeout' => 1000
    ];
    
    $now = time();

    $response = wp_remote_post($url, $args);

    if (is_wp_error($response)) {
    
      throw new Exception(
        $response->get_error_message(), 
        500
      );
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);
    $response = $data['choices'][0]['message']['content'];

    $save = file_put_contents(
      $destmanagefile,
      $response
    );

    $timespend = time() - $now;

    $res->set_data([
      'time' => $timespend,
      'response' => $response
    ]);  
    
  } catch (Exception $e) {
    
    $res->set_status($e->getCode());
    $res->set_data($e->getMessage());
  }

  return $res;
}

function poeticsoft_openai_remote(WP_REST_Request $req) {

  $res = new WP_REST_Response();

  try { 

    $remotepage = file_get_contents('https://www.dentaid.es/es/compromiso/sociedad');      
    $destfilename = dirname(__FILE__) . '/sources/remote.html';
    $result = poeticsoft_dom_html($remotepage);
    $save = file_put_contents(
      $destfilename,
      $result
    );
    
    $res->set_data($save ? 'Guardado' : ' Error');
    
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
      'poeticsoft/openai',
      'source',
      array(
        array(
          'methods'  => 'GET',
          'callback' => 'poeticsoft_openai_source',
          'permission_callback' => '__return_true'
        )
      )
    );

    register_rest_route(
      'poeticsoft/openai',
      'manage',
      array(
        array(
          'methods'  => 'GET',
          'callback' => 'poeticsoft_openai_manage',
          'permission_callback' => '__return_true'
        )
      )
    );

    register_rest_route(
      'poeticsoft/openai',
      'remote',
      array(
        array(
          'methods'  => 'GET',
          'callback' => 'poeticsoft_openai_remote',
          'permission_callback' => '__return_true'
        )
      )
    );
  }
);
