<?php
$option = $_GET['option'];
if (isset($_GET['option']) and $option == 0) {
  /**
   * This code will benchmark your server to determine how high of a cost you can
   * afford. You want to set the highest cost that you can without slowing down
   * you server too much. 8-10 is a good baseline, and more is good if your servers
   * are fast enough. The code below aims for ≤ 50 milliseconds stretching time,
   * which is a good baseline for systems handling interactive logins.
   */
  $timeTarget = 5; // 50 Millisekunden

  $cost = 5;
  do {
      $cost++;
      $start = microtime(true);
      password_hash("test", PASSWORD_BCRYPT, ["cost" => $cost]);
      $end = microtime(true);
  } while (($end - $start) < $timeTarget);

  echo "Appropriate Cost Found: " . $cost . " with " . ($end - $start);
} elseif (isset($_GET['option']) and $option == 1) {

//  require 'global/EPadClient.php';
//  $apikey = file_get_contents('/home/etherpad/etherpad-lite/APIKEY.txt');
//  $instance = new EtherpadLite\Client($apikey, 'https://diale.ddns.net/pad/api');
//
//function EtherPadAPI($tocall, $answer, $type, $param1 = null, $param2 = null, $param3 = null, $speacial = false)
//{
//  global $instance;
//  if ($type == 0) {
//    $data = $instance->$tocall();
//    if(!$speacial) {
//      $data = $data->$answer;
//    }
//    return $data;
//  }
//  if ($type == 1) {
//    $data = $instance->$tocall($param1);
//    if(!$speacial) {
//      $data = $data->$answer;
//    }
//    return $data;
//  }
//  if ($type == 2) {
//    $data = $instance->$tocall($param1, $param2);
//    if(!$speacial) {
//      $data = $data->$answer;
//    }
//    return $data;
//  }
//  if ($type == 3) {
//    $data = $instance->$tocall($param1, $param2, $param3);
//    if(!$speacial) {
//      $data = $data->$answer;
//    }
//    return $data;
//  }
//}

  require 'global/EPRequest.php';

//  $test = request('getSessionInfo', null, 1, true, 's.1e310ba703dd58699e2b44d478bd91d9');

  $test = request('listSessionsOfAuthor', null, 1, true, 'a.pBjdD2OsSPwCztRC');

//  $test = request('createSession', 'sessionID', 3, false, 'g.85ulDNI6TE7eBDl7', 'a.pBjdD2OsSPwCztRC', time() + 259200);

/*  if (!empty($test['data'])) {
    foreach (array_keys($test['data']) as $sessionid) {
      echo $sessionid;
      request('deleteSession', null, 1, false, $sessionid);
    }
  }*/
//  $test = "asdasdasdads";
//  $test = $test . "aaaaaaa";
//  $test = substr($test, 1);


  function prettyPrint($array) {
    echo '<pre>'.print_r($array, true).'</pre>';
  }

  /*foreach ($test as $padid) {
    $teile = explode("$", $padid);
    echo $teile[1];
  }*/

  if (is_string($test)) {
    echo $test;
  } else {
    echo prettyPrint($test);
  }
} elseif (isset($_GET['option']) and $option == 2) {
  echo '<link rel="stylesheet" href="CSS/test.css">';
  echo '<div id="spinner"><div id="img1" class="img"></div><div id="img2" class="img"></div><div id="img3" class="img"></div><div id="img4" class="img"></div><div id="img5" class="img"></div></div>';
} else {
  echo "Please specify what to do";
}
?>
