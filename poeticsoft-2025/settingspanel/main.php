<?php

add_action(
  'init', 
  function() {

    $settingspaneldir = __DIR__;
    $settingspanelnames = array_diff(
      scandir($settingspaneldir),
      ['main.php', '..', '.']
    );

    foreach($settingspanelnames as $key => $settingspanelname) {
      
      $settingspaneljsondir = $settingspaneldir . '/' . $settingspanelname;      
      
      require_once($settingspaneljsondir . '/main.php'); 
    }
  },
  5
);