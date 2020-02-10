<?php
session_start();
if(!isset($_SESSION['userid'])) {
    die('Bitte zuerst <a href="../../login/php/index.php">einloggen</a>');
}

//Abfrage der Nutzer ID vom Login
$userid = $_SESSION['userid'];
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>DaLe</title>
    <link rel="stylesheet" href="../css/style.css">
    <!--<script type="text/javascript" src="../js/script.js"></script>-->
  </head>
  <body>
    <div class="allcont" id="all" name="all-cont">
      <div class="box1" id="ST" name="settings">
      </div>
      <div class="box2" id="CT" name="contacts">
        <a>Contacts</a>
        <div class="contacts" id="C" name="all-contacts">
          <div class="con1" id="CO1" name="contact1">
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
