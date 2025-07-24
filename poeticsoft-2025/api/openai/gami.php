<?php

function poeticsoft_openai_gami(WP_REST_Request $req) {

  $res = new WP_REST_Response();

  try { 
    
    $data = poeticsoft_api_data();
    $url = $data['openai_url'];
    $authtoken = $data['openai_token'];  

    /* REAL CALL   

    $body = [
      'model' => "gpt-3.5-turbo",
      'messages' => [
        [ 
          'role' => 'system', 
          'content' => 'Eres un asistente de compras para ayudar a buscar productos en tiendas online.' 
        ],
        [ 
          'role' => "user", 
          'content' => '¿Tienes zapatillas deportivas?' 
        ]
      ],
      'functions' => [
        [
          'name' => "buscar_productos",
          'description' => "Busca productos en una tienda online según palabra clave.",
          'parameters' => [
            'type' => "object",
            'properties' => [
              'palabra_clave' => [
                'type' => "string",
                'description' => "Palabra clave para buscar productos, ejemplo => zapatillas, smartphone, reloj"
              ]
            ],
            'required' => ["palabra_clave"]
          ]
        ]
      ],
      'function_call' => 'auto',
      'temperature' => 0,
      'n' => 1
    ];

    $args = [
      'method' =>'POST',
      'headers' => [
        'Content-Type' => 'application/json',
        'Authorization' => 'Bearer ' . $authtoken
      ],
      'body' => json_encode($body)
    ];

    $url = 'https://api.openai.com/v1/chat/completions';

    $now = time();

    $response = wp_remote_post($url, $args);

    if (is_wp_error($response)) {
    
      throw new Exception(
        $response->get_error_message(), 
        500
      );
    }

    $timespend = time() - $now;

    $responsebody = wp_remote_retrieve_body($response);
    $responsedata = json_decode($responsebody, true);
    $result = $responsedata['choices'][0];

    */

    /* SIMULATE CALL & SECOND CALL */

    $now = time();

    $responsebody = file_get_contents(dirname(__FILE__) . '/responses/gami_response_a.json');
    $responsedata = json_decode($responsebody, true);
    $responsemessage = $responsedata['choices'][0]['message'];
    $needcallfunction = $responsemessage['function_call'];

    if($needcallfunction) {

      $body = [
        'model' => "gpt-3.5-turbo",
        'messages' => [
          [ 
            'role' => 'system', 
            'content' => 'Eres un asistente de compras para ayudar a buscar productos en tiendas online.' 
          ],
          [ 
            'role' => "assistant", 
            'function_call' => [
              'name' => 'buscar_productos',
              'arguments' => "{\"palabra_clave\":\"zapatillas deportivas\"}"
            ]
          ],
          [
            'role' => 'function',
            'name' => 'buscar_productos',
            'content' => '
              modelos encontrados: 
              Zapatillas Nike Revolution 6 Nn Hombre Running
              Zapatillas Adidas Duramo Sl 2.0 Hombre
              Zapatillas Puma Flyer Runner Engineered Mesh
            '
          ]
        ]
      ];
  
      $args = [
        'method' =>'POST',
        'headers' => [
          'Content-Type' => 'application/json',
          'Authorization' => 'Bearer ' . $authtoken
        ],
        'body' => json_encode($body)
      ];
  
      $url = 'https://api.openai.com/v1/chat/completions';
  
      $now = time();
  
      $response = wp_remote_post($url, $args);
  
      if (is_wp_error($response)) {
      
        throw new Exception(
          $response->get_error_message(), 
          500
        );
      }
  
      $timespend = time() - $now;

      $responsebody = wp_remote_retrieve_body($response);
      $responsedata = json_decode($responsebody, true);
      $responsemessage = $responsedata['choices'][0]['message'];
    } 

    $res->set_data([
      'time' => $timespend,
      'response' => $responsedata
    ]);
    
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
      'gami',
      [
        [
          'methods'  => 'GET',
          'callback' => 'poeticsoft_openai_gami',
          'permission_callback' => '__return_true'
        ]
      ]
    );
  }
);
