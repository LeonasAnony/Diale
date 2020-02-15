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
    <title>Diale</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/all.css">
  </head>
  <body class="All">
    <div class="dl_all_wrap">
      <div class="dl_head">
        <div class="head_search_box">

        </div>
        <div class="head_main_box">

        </div>
      </div>
      <div class="dl_name">
        <img src="../img/Diale_logo.png" alt="Diale" id="name_diale">
      </div>
      <div class="dl_sidebar">
        <div class="sidebar_main_icons">
          <i class="fas smi fa-users"></i>
          <i class="fas smi fa-address-book"></i>
        </div>
        <div class="sidebar_low_icons">
          <i class="fas sli fa-cog"></i>
          <i class="fas sli fa-question-circle"></i>
        </div>
      </div>
<!--      <div class="sidebar_descriptions">
        <div class="sidebar_group_description">
          <p id="group_description">Create a new Group</p>
        </div>
        <div class="sidebar_contacts_description">

        </div>
        <div class="sidebar_settings_description">

        </div>
        <div class="sidebar_about_description">

        </div>
      </div>-->
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
