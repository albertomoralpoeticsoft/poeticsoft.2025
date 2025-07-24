<?php

function poeticsoft_style_last(WP_REST_Request $req) {  

  global $wpdb;

  $res = new WP_REST_Response();

  try {

    $sql = "SELECT ID, post_content, post_modified " . 
           "FROM {$wpdb->prefix}posts " . 
           "WHERE post_type = 'wp_global_styles' " .
           "ORDER BY post_modified DESC LIMIT 1";
    
    $laststyle = $wpdb->get_row($sql);

    if (is_wp_error($laststyle)) {

      throw new Exception(
        $laststyle->get_error_message(), 
        500
      );
    }

    $jsoncontent = $laststyle->post_content;
    $jsonO = json_decode($jsoncontent);
    $jsonP = json_encode($jsonO, JSON_PRETTY_PRINT);

    $saved = file_put_contents(
      __DIR__ . '/theme-last.json',
      $jsonP
    );

    $stylejson = [
      'saved' => $saved,
      'content' => $jsonO
    ];

    $res->set_data($stylejson);
    
  } catch (Exception $e) {
    
    $res->set_status($e->getCode());
    $res->set_data($e->getMessage());
  }

  return $res;
}

function poeticsoft_style_update(WP_REST_Request $req) {  

  global $wpdb;

  $res = new WP_REST_Response();

  try {   

    $themeupdate = file_get_contents(__DIR__ .'/theme-update.json');    

    $sql = "SELECT ID " . 
           "FROM {$wpdb->prefix}posts " . 
           "WHERE post_type = 'wp_global_styles' " .
           "ORDER BY post_modified DESC LIMIT 1";
    
    $laststyle = $wpdb->get_row($sql);

    if (is_wp_error($laststyle)) {

      throw new Exception(
        $laststyle->get_error_message(), 
        500
      );
    }

    $styleid = $laststyle->ID;

    $updated = $wpdb->update(
      "{$wpdb->prefix}posts",
      [
        'post_content' => $themeupdate,
        'post_modified' => current_time( 'mysql' ),
        'post_modified_gmt' => current_time( 'mysql', 1 ),
      ],
      ['ID' => $styleid],
      ['%s', '%s', '%s'],
      ['%d']              // Formato para el ID
    );

    if (is_wp_error($laststyle)) {

      throw new Exception(
        $laststyle->get_error_message(), 
        500
      );
    }

    $res->set_data([
      'updated' => $updated,
      'style' => $styleid
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
      'poeticsoft/style',
      'last',
      array(
        array(
          'methods'  => 'GET',
          'callback' => 'poeticsoft_style_last',
          'permission_callback' => '__return_true'
        )
      )
    );

    register_rest_route(
      'poeticsoft/style',
      'update',
      array(
        array(
          'methods'  => 'GET',
          'callback' => 'poeticsoft_style_update',
          'permission_callback' => '__return_true'
        )
      )
    );
  }
);