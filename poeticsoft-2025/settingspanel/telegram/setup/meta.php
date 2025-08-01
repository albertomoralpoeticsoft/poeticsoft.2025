<?php

add_action(
  'init', 
  function() {

    register_post_meta(
      'post', 
      'poeticsoft_post_publish_telegram_lastpublishdate', 
      [
        'show_in_rest' => true,
        'single'       => true,
        'type'         => 'string',
        'auth_callback' => '__return_true'
      ] 
    );

    register_post_meta(
      'post', 
      'poeticsoft_post_publish_telegram_active', 
      [
        'show_in_rest' => true,
        'single'       => true,
        'type'         => 'boolean',
        'auth_callback' => '__return_true'
      ] 
    );

    register_post_meta(
      'post', 
      'poeticsoft_post_publish_telegram_destination', 
      [
        'show_in_rest' => true,
        'single'       => true,
        'type'         => 'string',
        'auth_callback' => '__return_true'
      ] 
    );

    register_post_meta(
      'post', 
      'poeticsoft_post_publish_telegram_publishonchange', 
      [
        'show_in_rest' => true,
        'single'       => true,
        'type'         => 'boolean',
        'auth_callback' => '__return_true'
      ] 
    );
  }
);