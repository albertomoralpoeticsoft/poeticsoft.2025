<?php

add_filter(
  'admin_init', 
  function () {

    $fields = [

      'gemini_url' => [
        'title' => 'Gemini URL',
        'value' => ''
      ],

      'gemini_model' => [
        'title' => 'Gemini Model',
        'value' => ''
      ],

      'gemini_apikey' => [
        'title' => 'Gemini Api Key',
        'value' => ''
      ],

      'openai_url' => [
        'title' => 'Openai Url',
        'value' => ''
      ],

      'openai_token' => [
        'title' => 'Openai Auth Token',
        'value' => ''
      ],
    ];

    foreach($fields as $key => $field) {

      register_setting(
        'general', 
        'poeticsoft_settings_' . $key
      );

      add_settings_field(
        'poeticsoft_settings_' . $key, 
        '<label for="poeticsoft_settings_' . $key . '">' . 
          __($field['title']) .
        '</label>',
        function () use ($key, $field){

          $value = get_option('poeticsoft_settings_' . $key, $field['value']);

          if(isset($field['type'])) {

            if('checkbox' == $field['type']) {

              echo '<input type="checkbox" 
                           id="poeticsoft_settings_' . $key . '" 
                           name="poeticsoft_settings_' . $key . '" 
                           class="regular-text"
                           ' . ($value ? 'checked="chedked"' : '') . ' />';

            }

            if('number' == $field['type']) {

              echo '<input type="number" 
                           id="poeticsoft_settings_' . $key . '" 
                           name="poeticsoft_settings_' . $key . '" 
                           class="regular-text"
                           value="' . $value . '" />';

            } 
            
          } else {

            echo '<input type="text" 
                         id="poeticsoft_settings_' . $key . '" 
                         name="poeticsoft_settings_' . $key . '" 
                         class="regular-text"
                         value="' . $value . '" />';
          }
        },
        'general'
      );  
    }  
  }
);

?>