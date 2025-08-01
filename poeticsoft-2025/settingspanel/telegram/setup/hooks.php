<?php

require_once(WP_PLUGIN_DIR . '/poeticsoft-2025/api/telegram/functions.php');

add_action(
  'transition_post_status',
  function ($new_status, $old_status, $post) {

    if (
      'post' === $post->post_type
      &&
      'publish' === $new_status 
      && 
      'publish' !== $old_status
    ) {
      
      $post = get_post($post->ID);
      $postmeta = get_post_meta($post->ID);

      if (
        (
          !isset($postmeta['poeticsoft_post_publish_telegram_lastpublishdate'])
          ||
          !$postmeta['poeticsoft_post_publish_telegram_lastpublishdate'][0]
        )
        &&
        (
          isset($postmeta['poeticsoft_post_publish_telegram_active'])
          && 
          $postmeta['poeticsoft_post_publish_telegram_active'][0]
        )
      ) { 

        poeticsoft_telegram_publishpost($post->ID);
      }
    }
  },
  10,
  3
);

add_action(
  'post_updated',
  function ($post_id, $post_after, $post_before) {

    $post = get_post($post_id);
    $postmeta = get_post_meta($post_id);

    if (
      'post' === $post->post_type
      &&
      'publish' === $post->post_status
      &&
      isset($postmeta['poeticsoft_post_publish_telegram_active'])
      && 
      $postmeta['poeticsoft_post_publish_telegram_active'][0]
      &&
      isset($postmeta['poeticsoft_post_publish_telegram_publishonchange'])
      && 
      $postmeta['poeticsoft_post_publish_telegram_publishonchange'][0]
    ) {      
      
      poeticsoft_telegram_publishpost($post_id);
    }
  },
  10,
  3
);