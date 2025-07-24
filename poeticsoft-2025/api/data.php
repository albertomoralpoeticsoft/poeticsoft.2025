<?php

function poeticsoft_api_data() {

  $data = [
    'gemini_url' => get_option('poeticsoft_settings_gemini_url', null),
    'gemini_model' => get_option('poeticsoft_settings_gemini_model', null),
    // https://aistudio.google.com/app/apikey
    'gemini_apikey' => get_option('poeticsoft_settings_gemini_apikey', null),
  
    'openai_apikey' => ''
  ];

  return $data;
}
    