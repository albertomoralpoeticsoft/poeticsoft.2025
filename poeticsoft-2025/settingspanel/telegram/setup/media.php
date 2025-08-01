<?php

add_filter(
  'attachment_fields_to_edit', 
  function ($form_fields, $post) {

    $html = '
    <div class="poeticsoft-media-publish-telegram">
      <select class="selectchannel">
      </select>
      <button class="button publish">Publicar</button>
    </div>
    <script>
      if(window.poeticsoftMediaPublishTelegram) { window.poeticsoftMediaPublishTelegram(' . $post->ID . ') }
    </script>
    ';
    
    $form_fields['poeticsoft-media-publish-telegram'] = [
        'label' => 'Publicar en Telegram',
        'input' => 'html',
        'html'  => $html,
        'helps' => 'Selecciona un canal y publica este archivo. Se publicará con el texto del campo descripción como caption.',
    ];

    return $form_fields;
  }, 
  10, 
  2 
);