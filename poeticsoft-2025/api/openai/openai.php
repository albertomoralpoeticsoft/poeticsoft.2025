<?php

function poeticsoft_openai_images(WP_REST_Request $req) {
  
  require_once(ABSPATH . "wp-admin" . '/includes/image.php');
  require_once(ABSPATH . "wp-admin" . '/includes/file.php');
  require_once(ABSPATH . "wp-admin" . '/includes/media.php'); 
  require_once(__DIR__ . '/keys.php'); 

  $res = new WP_REST_Response();

  try { 

    $uploaddir = wp_get_upload_dir();
    $basedir = $uploaddir['basedir'] . '/openai/';
    $authtoken = poeticsoft_openai_get_key('openai');

    $prompt = 'Baroque-style oil painting portrait of a mature man with a full, curly gray beard and wavy dark brown hair, slightly slicked back. He has deep-set, intense eyes, a strong nose, and a solemn, contemplative expression. He is wearing a simple dark V-neck shirt resembling 17th-century attire. The composition uses dramatic chiaroscuro lighting with strong contrast — a single directional light source illuminating his face and beard while the background fades into deep shadow. The color palette is rich and warm with deep browns, golds, and earthy tones, capturing the texture of the skin, hair, and fabric with painterly brushstrokes. Inspired by Caravaggio’s dramatic realism and intense emotional depth."';
    $data = array(
      'prompt' => $prompt,
      'n'      => 1,
      'size'   => '512x512'
    );
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
    $url = 'https://api.openai.com/v1/images/generations';

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

    if (!isset($data['data'][0]['url'])) {
        
      throw new Exception(
        'No se pudo obtener la imagen.', 
        500
      );
    }

    $image_url = $data['data'][0]['url'];

    $timespend = time() - $now;
  
    $tmp = download_url($image_url); 

    if (is_wp_error($tmp)) {

      throw new Exception(
        'Error al descargar la imagen.', 
        500
      );
    }

    if(file_exists($tmp)) {

      $moved = rename(
        $tmp, 
        $basedir . 'openai.png'
      );

      if(!$moved) {

        throw new Exception(
          'Error al mover la imagen.', 
          500
        );
      }

    } else {

      throw new Exception(
        'El archivo descargado no existe.', 
        500
      );
    }

    $res->set_data($timespend);  
    
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
      'images',
      array(
        array(
          'methods'  => 'GET',
          'callback' => 'poeticsoft_openai_images',
          'permission_callback' => '__return_true'
        )
      )
    );
  }
);
