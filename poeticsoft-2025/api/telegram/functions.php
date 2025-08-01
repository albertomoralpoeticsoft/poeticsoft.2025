<?php

require_once(WP_PLUGIN_DIR . '/poeticsoft-2025/tools/htmltomarkdown/vendor/autoload.php');
require_once(WP_PLUGIN_DIR . '/poeticsoft-2025/api/telegram/functions.php');

use League\HTMLToMarkdown\HtmlConverter;

function poeticsoft_telegram_sendmessage(
  $channel = 'telegram_ps_channelid',
  $message = 'Message'
) {

  $data = poeticsoft_api_data();
  $telegramtoken = $data['telegram_ps_token'];
  $apiurl = 'https://api.telegram.org/bot' . $telegramtoken . '/';
  $channelid = $data[$channel];
  $params = [
    'chat_id' => $channelid,
    'text' => $message,
    'parse_mode' => 'HTML'
  ];
  $url = $apiurl . 'sendMessage?' . http_build_query($params);

  $response = wp_remote_get($url);

  if (
    !is_array($response) 
    || 
    is_wp_error($response) 
  ) {      
    
    throw new Exception(
      $response->get_error_message(), 
      500
    );
  }

  return json_decode($response['body']);
}

function poeticsoft_telegram_sendphoto(
  $channel,
  $mediaurl,
  $message
) {

  $data = poeticsoft_api_data();
  $telegramtoken = $data['telegram_ps_token'];
  $apiurl = 'https://api.telegram.org/bot' . $telegramtoken . '/';
  $channelid = $data[$channel];
  $params = [
    'chat_id' => $channelid,
    'photo' => $mediaurl,
    'caption' => $message,
    'parse_mode' => 'Markdown'
  ];
  $url = $apiurl . 'sendPhoto?' . http_build_query($params);

  $response = wp_remote_get($url);

  if (
    !is_array($response) 
    || 
    is_wp_error($response) 
  ) {      
    
    throw new Exception(
      $response->get_error_message(), 
      500
    );
  }

  return json_decode($response['body']);
}

function poeticsoft_telegram_sendvideo(
  $channel,
  $mediaurl,
  $message
) {

  $data = poeticsoft_api_data();
  $telegramtoken = $data['telegram_ps_token'];
  $apiurl = 'https://api.telegram.org/bot' . $telegramtoken . '/';
  $channelid = $data[$channel];
  $params = [
    'chat_id' => $channelid,
    'video' => $mediaurl,
    'caption' => $message,
    'parse_mode' => 'Markdown'
  ];
  $url = $apiurl . 'sendVideo?' . http_build_query($params);

  $response = wp_remote_get($url);

  if (
    !is_array($response) 
    || 
    is_wp_error($response) 
  ) {      
    
    throw new Exception(
      $response->get_error_message(), 
      500
    );
  }

  return json_decode($response['body']);
}

function poeticsoft_telegram_messagedata($update) { 

  $data = [
    'destination' => '',
    'name' => '',
    'text' => ''
  ];

  if(isset($update['message'])) {

    if($update['message']['chat']['type'] == 'supergroup') {        

      $data['destination'] = 'telegram_ps_groupid';

    } else {

      $data['destination'] = 'telegram_ps_botid';
    }

    $data['name'] = $update['message']['from']['first_name'] . 
                    ' ' . 
                    $update['message']['from']['last_name'];
    $data['text'] = $update['message']['text'];
  }
  
  if(isset($update['channel_post'])) {

    $data['destination'] = 'telegram_ps_channelid';
    $data['name'] = $update['channel_post']['sender_chat']['title'];
    $data['text'] = $update['channel_post']['text'];
  }

  return $data;
}

function poeticsoft_telegram_publishpost($postid) {

  $post = get_post($postid);
  $postmeta = get_post_meta($postid);
  $destination = $postmeta['poeticsoft_post_publish_telegram_destination'][0];
  $thumbnail_id = get_post_thumbnail_id( $postid );
  $image = wp_get_attachment_image_src( $thumbnail_id, 'large')[0];
  $url = get_permalink($postid);
  $content = '<div>👉 <a href="' . $url . '">' . strtoupper($post->post_title) . '</a></div>
  <div>' . $post->post_excerpt . '</div>
  <div><a href="' . $url . '">Ver en la web</a></div>';
  $converter = new HtmlConverter([
    'strip_tags' => true
  ]);
  $converter->getConfig()->setOption('hard_break', true);
  $message = $converter->convert($content);

  $sent = poeticsoft_telegram_sendphoto(
    $destination,
    $image,
    $message
  );

  if($sent->ok) {

    $lastpublishdate = date('Y-m-d H:i:s');
    update_post_meta(
      $postid,
      'poeticsoft_post_publish_telegram_lastpublishdate',
      $lastpublishdate
    );
    $sent->publishdate = $lastpublishdate;
  }

  return $sent;
}

function poeticsoft_telegram_publishmedia($destination, $postid) {

  $post = get_post($postid);
  $legend = $post->post_excerpt;
  $description = $post->post_content;
  $content = '';
  
  if(trim($legend) != '') {

    $content .= '<div>' . trim($legend) . '</div>';
  }

  if(trim($description) != '') {

    $content .= '<div>' . trim($description) . '</div>';
  }

  $type = $post->post_mime_type;
  switch ($type) {

    case 'image/png':
    case 'image/jpeg':

      $image = wp_get_attachment_image_src($postid, 'large');
      $url = $image[0];
                 
      // TO DO NO REPEAT

      $message = '<div>👉 <a href="' . $url . '">' . strtoupper($post->post_title) . '</a></div>' .
                 $content;
      $converter = new HtmlConverter([
        'strip_tags' => true
      ]);
      $converter->getConfig()->setOption('hard_break', true);
      $message = $converter->convert($message);

      $sent = poeticsoft_telegram_sendphoto(
        $destination,
        $url,
        $message
      );

      break;

    case 'video/mp4':

      $url = $post->guid;
                 
      // TO DO NO REPEAT (PARSER FUNCTION FOR TEXTS)

      $message = '<div>👉 <a href="' . $url . '">' . strtoupper($post->post_title) . '</a></div>' .
                 $content;
      $converter = new HtmlConverter([
        'strip_tags' => true
      ]);
      $converter->getConfig()->setOption('hard_break', true);
      $message = $converter->convert($message);
    
      $sent = poeticsoft_telegram_sendvideo(
        $destination,
        $url,
        $message
      ); 
      
      break;
  }

  return $sent;
}