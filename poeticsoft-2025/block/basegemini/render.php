<?php

if (!function_exists('poeticsoft_block_basegemini_render_callback')) {

  function poeticsoft_block_basegemini_render_callback(
    $attributes,
    $content
  ) { 
    
    $url = $attributes['url'];
    $context = $attributes['context'];
    $userInit = $attributes['userInit'];
    
    return "<div class='wp-block-poeticsoft-basegemini'>
      <div class='url'>{$url}</div>
      <div class='context'>{$context}</div>
      <div class='userInit'>{$userInit}</div>
    </div>";
  }
}

echo poeticsoft_block_basegemini_render_callback($attributes, $content);