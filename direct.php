<?php
session_start();
if(!isset($_SESSION['userid'])) {
	header('Location: login.php');
	exit;
}

$userid = $_SESSION['userid'];
$pdo = new PDO('mysql:host=localhost:3306;dbname=Diale', 'Diale', '0YGFOd2p4XNXm9FQZziX32av');
$directid = $_GET['id'];
?>
<!doctype html>
<head>
	<meta charset="utf-8" name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0'/>
	<title>Diale</title>
	<link rel="icon" href="global/Favicons/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="spectre/dist/spectre.min.css">
<!--  <link rel="stylesheet" href="main/css/sidebar.css">-->
	<link rel="stylesheet" href="CSS/team.css">
	<script language="javascript" type="text/javascript" src="JS/direct.js"></script>
</head>
<body>
  <div class="container">
    <!-- Header -->
    <div class="columns col-oneline" id="HeadDiv">
      <div class="column col-xs-3 col-lg-2 col-1" id="MenuDiv">
        <img src="global/IconsPurple/MenuLila.png" id="Menuicon" onclick="showSidebar()"/>
      </div>
      <div class="column col-md-6 col-sm-9 col-4 col-mx-auto">
        <img class="center" src="global/Logos/Diale_text_new.png" onclick="goBack()" id="headline"/>
      </div>
    </div>
    <!-- Content -->
    <div class="columns">
      <div class="column col-1"></div>
      <!-- Description ContentBox -->
      <div class="BoxDiv column col-md-10 col-4">
        <img class="profilepicture" src="global/IconsPurple/Icon_PadLila.png" alt="IconTeams"/>
        <h2 class="Headline">Pad's</h2>
        <hr class="HeadUnderline">
				<div class="boxes" onclick="Pad(' . $users['id']. ')">
					<p class="fonts"><!--' . $users['username']. '-->Englisch</p>
				</div>
				<hr class="Line">
				<div class="boxes" onclick="NewPad()">
          <p class="fonts">New Pad</p>
        </div>
      </div>
      <div class="column col-md-1 col-2"></div>
      <div class="column show-md col-1"></div>
      <div class="BoxDiv column col-md-10 col-4">
        <img class="profilepicture" src="global/IconsPurple/Icon_KalenderLila.png" alt="IconTeams"/>
        <h2 class="Headline">Date's</h2>
        <hr class="HeadUnderline">
				<div class="boxes" onclick="Date(' . $users['id']. ')">
					<p class="fonts"><!--' . $users['username']. '-->Kieferorthppäde</p>
				</div>
				<hr class="Line">
				<div class="boxes" onclick="NewDate()">
          <p class="fonts">New Date</p>
        </div>
      </div>
			<div class="column col-1"></div>
    </div>
		<div class="modal_background" id="ModalBackground"></div>
		<div class="columns">
			<div class="column col-xs-12 col-sm-6 col-md-5 col-lg-4 col-xl-4 col-3" id="SidebarModal">
				<div class="column col-12">
					<span class="close show-xs" onclick="closeSidebar()">&times;</span>
					<img width="99%" alt="Diale_logo" src="global/Logos/Diale_text_new.png" id="SidebarLogo"/>
				</div>
				<hr/>
				<div class="SB-boxes columns col-oneline" onclick="Messenger()">
					<div class="logos column col-4">
						<img height="60%" alt="Messenger_logo" src="global/IconsPurple/Icon_MessengerLila.png"/>
					</div>
					<div class="column col-8 col-lg-auto">
						<h2 class="SB-fonts">Message's</h2>
					</div>
				</div>
				<div class="SB-boxes columns col-oneline" onclick="Pads()">
					<div class="logos column col-4">
						<img height="60%" alt="Pad_logo" src="global/IconsPurple/Icon_PadLila.png"/>
					</div>
					<div class="column col-8 col-lg-auto">
						<h2 class="SB-fonts">Pad's</h2>
					</div>
				</div>
				<div class="SB-boxes columns col-oneline" onclick="Boards()">
					<div class="logos column col-4">
						<img height="60%" alt="Checklist_logo" src="global/IconsPurple/Icon_ChecklistLila.png"/>
					</div>
					<div class="column col-8 col-lg-auto">
						<h2 class="SB-fonts">Board's</h2>
					</div>
				</div>
				<div class="SB-boxes columns col-oneline" onclick="Kalender()">
					<div class="logos column col-4">
						<img height="60%" alt="Kalender_logo" src="global/IconsPurple/Icon_KalenderLila.png"/>
					</div>
					<div class="column col-8 col-lg-auto">
						<h2 class="SB-fonts">Kalender</h2>
					</div>
				</div>
				<div class="SB-boxes columns col-oneline" onclick="Datein()">
					<div class="logos column col-4">
						<img height="60%" alt="Dateimanager_logo" src="global/IconsPurple/Icon_Datei_ManagerLila.png"/>
					</div>
					<div class="column col-8 col-lg-auto">
						<h2 class="SB-fonts">Dateien</h2>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
