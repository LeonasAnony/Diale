<?php
session_start();
$pdo = new PDO('mysql:host=localhost:3306;dbname=Diale', 'Diale', '0YGFOd2p4XNXm9FQZziX32av');
require 'global/EPRequest.php';

if (isset($_SESSION['userid']) AND !isset($_GET['logout'])) {
  header('Location: index.php');
} elseif (isset($_SESSION['userid']) AND isset($_GET['logout'])) {
  $userid = $_SESSION['userid'];

  $statement = $pdo->prepare("SELECT * FROM users WHERE id = :userid");
  $result = $statement->execute(array('userid' => $userid));
  $user = $statement->fetch();
  $sessions = request('listSessionsOfAuthor', null, 1, true, $user['ep_authorID']);

  if (!empty($sessions['data'])) {
    foreach (array_keys($sessions['data']) as $sessionid) {
      request('deleteSession', null, 1, false, $sessionid);
    }
  }
  if(isset($_COOKIE['sessionID'])) {
    setcookie("sessionID", "", time() - 600);
  }

  session_unset();
  session_destroy();
  echo "<style>.box p2 {display: inline;}</style>";
} elseif (!isset($_SESSION['userid']) AND isset($_GET['logout'])) {
    echo "<style>.box p3 {display: inline;}</style>";
}


if(isset($_GET['login'])) {
  $login = $_POST['login'];
  $passwort = $_POST['password'];

  if (!filter_var($login, FILTER_VALIDATE_EMAIL)) {
    $statement = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $result = $statement->execute(array('username' => $login));
    $user = $statement->fetch();
  }
  else {
    $statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $result = $statement->execute(array('email' => $login));
    $user = $statement->fetch();
  }

  //Überprüfung des Passworts
  if ($user !== false && password_verify($passwort, $user['passwort'])) {
      $_SESSION['userid'] = $user['id'];
      $sessions = request('listSessionsOfAuthor', null, 1, true, $user['ep_authorID']);
      if (!empty($sessions['data'])) {
        foreach (array_keys($sessions['data']) as $sessionid) {
          request('deleteSession', null, 1, false, $sessionid);
        }
      }
      if(isset($_COOKIE['sessionID'])) {
        setcookie("sessionID", "", time() - 600);
      }
      $stack = array();
      $statement = $pdo->prepare("SELECT team_id FROM in_team WHERE user_id = :userid");
      $statement->execute(array('userid' => $user['id']));
      while($loopdata = $statement->fetch()) {
        $stack = array_merge($stack, $loopdata);
      }

      array_shift($stack);
      $newIDs = "";
      foreach ($stack as $loopdata) {
        $statement = $pdo->prepare("SELECT ep_groupID FROM teams WHERE id = :teamid");
        $result = $statement->execute(array('teamid' => $loopdata));
        $teamgroupid = $statement->fetch();

        $newID = request('createSession', 'sessionID', 3, false, $teamgroupid['ep_groupID'], $user['ep_authorID'], time() + 259200);
        $newIDs = $newIDs . "," . $newID;
      }
      $newIDs = substr($newIDs, 1);

      setcookie("sessionID", $newIDs, time() + 259200, "/");

      header('Location: index.php');
      exit;
    } else {
      //$errorMessage = "E-Mail oder Passwort war ungültig<br>";
      echo "<style>.box p {display: inline;}</style>";
    }
}

if(isset($_GET['registered'])) {
  echo "<style>.box p1 {display: inline;}</style>";
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8" name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0'/>
    <title>Diale Login</title>
    <link rel="icon" href="global/Favicons/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="spectre/dist/spectre.min.css">
    <link rel="stylesheet" href="CSS/login-regis.css">
  </head>
  <body>
    <div class="columns">
      <div class="box column col-xs-11 col-sm-7 col-md-6 col-lg-5 col-xl-4 col-3">
        <form id="BX" action="?login=true" method="post">
          <h1>Login</h1>
          <p1>Account wurde erfolgreich erstellt</p1>
          <p2>Erfolgreich ausgeloggt</p2>
          <p3>Erst einloggen dann ausloggen^^</p3>
          <input type="text" id="EM" size="40" maxlength="250" name="login" placeholder="E-mail/Username">
          <input type="password" id="PW" size="40"  maxlength="250" name="password" placeholder="Password">
          <p>E-Mail/Username oder Passwort ist ungültig</p>
          <input type="submit" id="LN" value="Login">
          <a href="regis.php">Registrieren</a>
        </form>
      </div>
    </div>
  </body>
</html>
