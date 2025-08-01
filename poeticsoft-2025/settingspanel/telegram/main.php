<?php

add_action( 
	'admin_enqueue_scripts', 
	function () {

    $dir = plugin_dir_path(__FILE__);
    $url = plugin_dir_url(__FILE__);

    wp_enqueue_script(
      'poeticsoft-settingspanel-telegram', 
      $url . '/main.js',
      [
        'wp-i18n',
        'wp-core-data',
        'wp-edit-post',
        'wp-element',
        'wp-data',
        'wp-blocks',
        'wp-block-editor',
        'wp-components',
        'wp-plugins'
      ], 
      filemtime($dir . '/main.js'),
      true
    );

    wp_enqueue_style( 
      'poeticsoft-settingspanel-telegram',
      $url . '/main.css', 
      [], 
      filemtime($dir . '/main.css'),
      'all' 
    );

    wp_enqueue_script(
      'poeticsoft-settingspanel-telegram-admin', 
      $url . '/admin.js',
      [
        'jquery'
      ], 
      filemtime($dir . '/admin.js'),
      true
    );

    wp_enqueue_style( 
      'poeticsoft-settingspanel-telegram-admin',
      $url . '/admin.css', 
      [], 
      filemtime($dir . '/admin.css'),
      'all' 
    );
	}, 
	15 
);

require_once(dirname(__FILE__) . '/setup/meta.php');
require_once(dirname(__FILE__) . '/setup/hooks.php');
require_once(dirname(__FILE__) . '/setup/media.php');

