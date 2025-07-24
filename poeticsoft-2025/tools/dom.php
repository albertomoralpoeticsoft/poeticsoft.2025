<?php

require_once(dirname(__FILE__) . '/pretty/vendor/autoload.php');

use Wa72\HtmlPrettymin\PrettyMin;

function poeticsoft_dom_html($html) {  

  $contentdom = new DOMDocument('1.0');
  $contentdom->substituteEntities = false;
  libxml_use_internal_errors(true);
  $contentdom->loadHTML($html);
  libxml_use_internal_errors(false);
  $contentdomx = new DOMXPath($contentdom);

  $headnodes = $contentdomx->query('/html/head/*');
  foreach ($headnodes as $node) {
    $node->parentNode->removeChild($node);
  }

  $comments = $contentdomx->query('//comment()');
  foreach ($comments as $comment) {
    $comment->parentNode->removeChild($comment);
  }

  $allnodes = $contentdomx->query('//*');
  foreach ($allnodes as $node) {      
    while ($node->attributes->length > 0) {
      $node->removeAttributeNode($node->attributes->item(0));
    }
  }

  $buttons = $contentdomx->query('//button');
  foreach ($buttons as $button) {
      $button->parentNode->removeChild($button);
  }

  $scripts = $contentdomx->query('//script');
  foreach ($scripts as $script) {
      $script->parentNode->removeChild($script);
  }

  $navs = $contentdomx->query('//nav');
  foreach ($navs as $nav) {
      $nav->parentNode->removeChild($nav);
  }

  $footers = $contentdomx->query('//footer');
  foreach ($footers as $footer) {
      $footer->parentNode->removeChild($footer);
  }

  $emptynodesselector = '//*[not(normalize-space()) and not(child::*) and not(self::html) and not(self::head) and not(self::body)]';
  $emptyNodes = $contentdomx->query($emptynodesselector);
  do {
    foreach ($emptyNodes as $emptyNode) {
      $emptyNode->parentNode->removeChild($emptyNode);
    }
    $emptyNodes = $contentdomx->query($emptynodesselector);      
  } while ($emptyNodes->length > 0);

  $divs = $contentdomx->query('//div');
  foreach ($divs as $div) {
    while ($div->hasChildNodes()) {
        $div->parentNode->insertBefore($div->firstChild, $div);
    }
    $div->parentNode->removeChild($div);
  }

  $as = $contentdomx->query('//a');
  foreach ($as as $a) {
    while ($a->hasChildNodes()) {
      $a->parentNode->insertBefore($a->firstChild, $a);
    }
    $a->parentNode->removeChild($a);
  }

  $strongs = $contentdomx->query('//strong');
  foreach ($strongs as $strong) {
    while ($strong->hasChildNodes()) {
      $textnode = $contentdom->createTextNode(' jarl ');
      // $strong->parentNode->insertBefore($textnode, $strong);
      $strong->parentNode->insertBefore($strong->firstChild, $strong);
    }
    $strong->parentNode->removeChild($strong);
  }

  $pm = new PrettyMin();
  $pm->load($contentdom)->indent();
  unset($pm);

  $result = $contentdom->saveHTML();
  $result = html_entity_decode(
    $result, 
    ENT_QUOTES | ENT_HTML5, 
    'UTF-8'
  );

  return $result;

}