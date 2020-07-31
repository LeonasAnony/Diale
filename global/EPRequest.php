<?php
require 'global/EPadClient.php';
$apikey = file_get_contents('/home/etherpad/etherpad-lite/APIKEY.txt');
$instance = new EtherpadLite\Client($apikey, 'https://diale.ddns.net/pad/api');

function request($tocall, $answer, $type, $debug = false, $param1 = null, $param2 = null, $param3 = null) {
  global $instance;
  if ($type == 0) {
    $data = $instance->$tocall();
    if(!$debug) {
      $data = $data['data'][$answer];
    }
    return $data;
  }
  if ($type == 1) {
    $data = $instance->$tocall($param1);
    if(!$debug) {
      $data = $data['data'][$answer];
    }
    return $data;
  }
  if ($type == 2) {
    $data = $instance->$tocall($param1, $param2);
    if(!$debug) {
      $data = $data['data'][$answer];
    }
    return $data;
  }
  if ($type == 3) {
    $data = $instance->$tocall($param1, $param2, $param3);
    if(!$debug) {
      $data = $data['data'][$answer];
    }
    return $data;
  }
}
?>
