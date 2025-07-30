<?php

/**
 *
 * Plugin Name: poeticsoft-2025
 * Plugin URI: http://poeticsoft.com/plugins/poeticsoft-2025
 * Description: Poeticsoft 2025 Plugin
 * Version: 0.00
 * Author: Poeticsoft Team
 * Author URI: http://poeticsoft.com/team
 */

function plugin_log($display, $withdate = false) { 

  $text = is_string($display) ? 
  $display 
  : 
  json_encode($display, JSON_PRETTY_PRINT);

  $message = $withdate ? 
  date("d-m-y h:i:s") . PHP_EOL
  :
  '';

  $message .= $text . PHP_EOL;

  file_put_contents(
    WP_CONTENT_DIR . '/plugin_log.txt',
    $message,
    FILE_APPEND
  );
}
  
require_once(dirname(__FILE__) . '/setup/main.php'); 
require_once(dirname(__FILE__) . '/api/main.php');
require_once(dirname(__FILE__) . '/block/main.php'); 

register_activation_hook(__FILE__, 'poeticsoft_assistant_init');