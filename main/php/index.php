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
  </head>
  <body class="All">
    <div class="dl_all_wrap">
      <div class="dl_head">
        <div class="head_dropdown_box">
          <div class="head_dropdown">
            <p id="dropdown_heading">DaLe</p>
            <div class="dropdown_menu">
              <li>New Group</li>
              <li>Contacts</li>
              <li>Settings</li>
              <li>Info</li>
            </div>
          </div>
        </div>
        <div class="head_main_box">

        </div>
      </div>
      <div class="dl_main">
        <div class="main_chat_box">
          <div class="chat_history_box">

          </div>
          <div class="chat_typing_box">

          </div>
        </div>
        <div class="main_contacts_box">

        </div>
      </div>
    </div>
  </body>
</html>
