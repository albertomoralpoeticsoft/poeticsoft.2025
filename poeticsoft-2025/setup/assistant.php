<?php

function poeticsoft_assistant_init() {

  global $wpdb;
  $charset_collate = $wpdb->get_charset_collate();
  require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

  $tablename = $wpdb->prefix . 'assistant_history';
  $wpdb->query(
    "CREATE TABLE IF NOT EXISTS $tablename (
      id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
      user VARCHAR(30) NOT NULL,
      profile LONGTEXT,
      history LONGTEXT,
      updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) $charset_collate;"
  );
  
  $result = dbDelta();
}