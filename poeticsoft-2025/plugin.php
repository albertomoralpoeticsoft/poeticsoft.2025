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

function plugin_log($display) { 

  $text = is_string($display) ? 
  $display 
  : 
  json_encode($display, JSON_PRETTY_PRINT);

  file_put_contents(
    WP_CONTENT_DIR . '/ps_log.txt',
    date("d-m-y h:i:s") . PHP_EOL .
    $text . PHP_EOL,
    FILE_APPEND
  );
}
  
require_once(dirname(__FILE__) . '/setup/main.php'); 
require_once(dirname(__FILE__) . '/api/main.php');
require_once(dirname(__FILE__) . '/block/main.php'); 