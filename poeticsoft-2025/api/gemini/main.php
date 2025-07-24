<?php

function poeticsoft_gemini_models_byname(WP_REST_Request $req) {

  $res = new WP_REST_Response();

  try {    

    $name = $req->get_param('name');

    $data = poeticsoft_api_data();

    $url = $data['gemini_url'];
    $model = $data['gemini_model'];
    $apikey = $data['gemini_apikey'];
    
    $geminiurl = $url . '?key=' . $apikey;

    $response = wp_remote_get($geminiurl);

    if (is_wp_error($response)) {

      throw new Exception(
        $response->get_error_message(), 
        500
      ); 
    }

    $responsebody = json_decode($response['body']);
    $models = $responsebody->models;
    $model = null;
    foreach($models as $m) {

      if($m->name == 'models/' . $name) {

        $model = $m;
        break;
      }
    }

    if($model) {

      $model = [
        'id' => $model->name,
        'name' => $model->displayName,
        'description' => $model->description,
        'temperature' => $model->temperature,
        'topP' => $model->topP,
        'topK' => $model->topK
      ];
    }

    $res->set_data($model);
    
  } catch (Exception $e) {
    
    $res->set_status($e->getCode());
    $res->set_data($e->getMessage());
  }

  return $res;
}

function poeticsoft_gemini_models(WP_REST_Request $req) {

  $res = new WP_REST_Response();

  try {    

    $data = poeticsoft_api_data();

    $url = $data['gemini_url'];
    $model = $data['gemini_model'];
    $apikey = $data['gemini_apikey'];
    
    $geminiurl = $url . '?key=' . $apikey;

    $response = wp_remote_get($geminiurl);

    if (is_wp_error($response)) {

      throw new Exception(
        $response->get_error_message(), 
        500
      ); 
    }

    $responsebody = json_decode($response['body']);
    $models = $responsebody->models;

    $res->set_data($models);
    
  } catch (Exception $e) {
    
    $res->set_status($e->getCode());
    $res->set_data($e->getMessage());
  }

  return $res;
}

function poeticsoft_gemini_test(WP_REST_Request $req) {

  $res = new WP_REST_Response();

  try {        

    $data = poeticsoft_api_data();

    $url = $data['gemini_url'];
    $model = $data['gemini_model'];
    $apikey = $data['gemini_apikey'];
    
    $geminiurl = $url . '/' . $model . ':generateContent?key=' . $apikey;
    
    $contents = [
      [
        'role' => 'user',
        'parts' => [
          [
            'text' => 'Escribe un poema corto sobre el mar.'
          ]
        ]
      ]
    ];

    $requestBody = [
      'contents' => $contents,
      'generationConfig' => [
        'temperature' => 0.7,
        'topP' => 0.95,
        'topK' => 40,
      ]
    ]; 
    
    $args = array(
      'method'      => 'POST',
      'headers'     => [
        'Content-Type' => 'application/json',
      ],
      'body'        => json_encode($requestBody),
      'timeout'     => 45
    );

    $response = wp_remote_post($geminiurl, $args);

    if (is_wp_error($response)) {

      throw new Exception(
        $response->get_error_message(), 
        500
      ); 
    }

    $responsebody = json_decode($response['body']);

    $res->set_data($responsebody);
    
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
      'poeticsoft/gemini',
      'models/(?P<name>[^/]+)',
      array(
        array(
          'methods'  => 'GET',
          'callback' => 'poeticsoft_gemini_models_byname',
          'permission_callback' => '__return_true'
        )
      )
    );

    register_rest_route(
      'poeticsoft/gemini',
      'models',
      array(
        array(
          'methods'  => 'GET',
          'callback' => 'poeticsoft_gemini_models',
          'permission_callback' => '__return_true'
        )
      )
    );

    register_rest_route(
      'poeticsoft/gemini',
      'test',
      array(
        array(
          'methods'  => 'GET',
          'callback' => 'poeticsoft_gemini_test',
          'permission_callback' => '__return_true'
        )
      )
    );
  }
);