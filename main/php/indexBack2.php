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
    <link href="https://fonts.googleapis.com/css?family=Ubuntu:300,300italic,regular,italic,500,500italic,700,700italic" rel="stylesheet" type="text/css">
  </head>
  <body class="htmlNoPages">
    <svg data-gwd-shape="rectangle" class="gwd-rect-ot9m"></svg>
    <svg data-gwd-shape="rectangle" class="gwd-rect-1af1"></svg>
    <p class="gwd-p-8faz">Contacts</p>
    <svg data-gwd-shape="rectangle" class="gwd-rect-1l55"></svg>
    <svg data-gwd-shape="line" preserveAspectRatio="none" viewBox="0 0 50 567" class="gwd-line-zyni">
      <line x1="0" x2="0" y1="0" y2="567"></line>
    </svg>
  </body>
</html>
