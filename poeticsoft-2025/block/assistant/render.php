<?php

if (!function_exists('poeticsoft_block_assistant_render_callback')) {

  function poeticsoft_block_assistant_render_callback(
    $attributes,
    $content
  ) { 
    
    return "<div class='wp-block-poeticsoft-assistant'>
      ASSISTANT
    </div>";
  }
}

echo poeticsoft_block_assistant_render_callback($attributes, $content);