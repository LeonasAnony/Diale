<?php
session_start();
if(!isset($_SESSION['userid'])) {
	header('Location: login.php');
	exit;
}

$userid = $_SESSION['userid'];
$pdo = new PDO('mysql:host=localhost:3306;dbname=Diale', 'Diale', '0YGFOd2p4XNXm9FQZziX32av');
?>
<!doctype html>
<head>
	<meta charset="utf-8" name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0'/>
	<title>Diale</title>
	<link rel="icon" href="global/Favicons/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="spectre/dist/spectre.min.css">
<!--  <link rel="stylesheet" href="main/css/sidebar.css">-->
	<link rel="stylesheet" href="CSS/index.css">
	<script language="javascript" type="text/javascript" src="JS/index.js"></script>
</head>
<body>
	<div class="container">
		<!-- Header -->
    <div class="columns col-oneline" id="HeadDiv">
      <div class="column col-md-6 col-sm-9 col-4 col-mx-auto" onclick="reload()">
				<img class="center" src="global/Logos/Diale_text_new.png" id="headline"/>
			</div>
      <div class="column col-xs-3 col-lg-2 col-1" id="SettingsDiv">
				<img src="global/IconsPurple/MenuLila.png" id="Settingsicon"/>
			</div>
    </div>
		<!-- Content -->
    <div class="columns">
      <div class="column col-1"></div>
			<!-- Direct ContentBox -->
      <div class="BoxDiv column col-md-10 col-4">
				<!-- Directs Header -->
				<img class="profilepicture" src="global/IconsPurple/Icon_EinzelLila.png" alt="IconDirect"/>
        <h2 class="Headline">Direct</h2>
        <hr class="HeadUnderline">
				<!-- Directs Modul -->
        <!--<div class="boxes">
          <img class="profilepicture hide-sm" src="global/team1.png" alt="ProfilePicture"/>
          <p class="fonts">Haiiiii</p>
        </div>
				<hr class="Line">-->
				<!-- Directs Modul End -->
				<?php
				$stack = array();
				$statement = $pdo->prepare("SELECT user_id2 FROM directs WHERE user_id1 = :userid");
				$statement->execute(array('userid' => $userid));
				while($loopdata = $statement->fetch()) {
					$stack = array_merge($stack, $loopdata);
				}

				array_shift($stack);
				foreach ($stack as $loop) {
					$statement = $pdo->prepare("SELECT * FROM users WHERE id = :userid");
					$result = $statement->execute(array('userid' => $loop));
					$directuser = $statement->fetch();

					$statement = $pdo->prepare("SELECT id FROM directs WHERE user_id1 = :userid AND user_id2 = :duserid");
					$result = $statement->execute(array('userid' => $userid, 'duserid' => $loop));
					$direct = $statement->fetch();

					echo '<div class="boxes" onclick="Direct(' . $direct['id'] . ')"><img class="profilepicture hide-sm" src="global/team' . $directuser['id']. '.png" alt="ProfilePicture"/><p class="fonts">' . $directuser['username']. '</p></div><hr class="Line">';
				}

				unset($stack);
				unset($loopdata);
				unset($loop);
				$stack = array();
				$statement = $pdo->prepare("SELECT user_id1 FROM directs WHERE user_id2 = :userid");
				$statement->execute(array('userid' => $userid));
				while($loopdata = $statement->fetch()) {
					$stack = array_merge($stack, $loopdata);
				}

				array_shift($stack);
				foreach ($stack as $loop) {
					$statement = $pdo->prepare("SELECT * FROM users WHERE id = :userid");
					$result = $statement->execute(array('userid' => $loop));
					$directuser = $statement->fetch();

					$statement = $pdo->prepare("SELECT id FROM directs WHERE user_id2 = :userid AND user_id1 = :duserid");
					$result = $statement->execute(array('userid' => $userid, 'duserid' => $loop));
					$direct = $statement->fetch();

					echo '<div class="boxes" onclick="Direct(' . $direct['id'] . ')"><img class="profilepicture hide-sm" src="global/team' . $directuser['id']. '.png" alt="ProfilePicture"/><p class="fonts">' . $directuser['username']. '</p></div><hr class="Line">';
				}
				?>
				<!-- new Direct Footer -->
        <div class="boxes" onclick="NewDirect()">
          <p class="fonts">New Direct</p>
        </div>
      </div>
      <div class="column col-md-1 col-2"></div>
      <div class="column show-md col-1"></div>
			<!-- Teams ContentBox -->
      <div class="BoxDiv column col-md-10 col-4">
				<!-- Teams Header -->
				<img class="profilepicture" src="global/IconsPurple/Icon_GruppenLila.png" alt="IconTeams"/>
        <h2 class="Headline">Teams</h2>
        <hr class="HeadUnderline">
				<!-- Teams Modul
        <div class="boxes" onclick="Team()">
          <img class="profilepicture hide-sm" src="global/team1.png" alt="ProfilePicture"/>
          <p class="fonts">Name</p>
        </div>
				<hr class="Line">
				Teams Modul End -->
				<?php
				$stack = array();
				$statement = $pdo->prepare("SELECT team_id FROM in_team WHERE user_id = :userid");
				$statement->execute(array('userid' => $userid));
				while($loopdata = $statement->fetch()) {
					$stack = array_merge($stack, $loopdata);
				}

				array_shift($stack);
				foreach ($stack as $loopdata) {
					$statement = $pdo->prepare("SELECT * FROM teams WHERE id = :teamid");
					$result = $statement->execute(array('teamid' => $loopdata));
					$teams = $statement->fetch();

					echo '<div class="boxes" onclick="Team(' . $teams['id'] . ')"><img class="profilepicture hide-sm" src="global/team' . $teams['id'] . '.png" alt="ProfilePicture"/><p class="fonts">' . $teams['name'] . '</p></div><hr class="Line">';
				}
				?>
				<!-- new Team Footer -->
        <div class="boxes" onclick="NewTeam()">
          <p class="fonts">New Team</p>
        </div>
      </div>
      <div class="column col-1"></div>
    </div>
		<?php
		$teamname = false;
		$teamdiscription = false;

		if(isset($_GET['teamcreate'])) {
			$error = false;
			$teamname = $_POST['TeamName'];
			$teamdiscription = $_POST['TeamDiscription'];

			if(strlen($teamname) == 0) {
				//echo 'Bitte einen Usernamen eingeben';
				echo "<style>.box p {display: inline;}</style>";
				$error = true;
			}
			if(strlen($teamdiscription) == 0) {
					//echo 'Bitte ein Passwort angeben<br>';
					echo "<style>.box p1 {display: inline;}</style>";
					$error = true;
			}

			//Keine Fehler, wir können den Nutzer registrieren
			function zufallsstring($laenge) {
				return strtoupper(substr(md5(rand()),0,$laenge));
			}

			function teamcode() {
				$random = zufallsstring(6);
//			echo $random . ".1.";
				$pdo = new PDO('mysql:host=localhost:3306;dbname=Diale', 'Diale', '0YGFOd2p4XNXm9FQZziX32av');
				$statement = $pdo->prepare("SELECT * FROM teams WHERE team_code = :random");
				$result = $statement->execute(array('random' => $random));
				$teamrandom = $statement->fetch();
				if($teamrandom !== false) {
						echo "<style>.box p3 {display: inline;}</style>";
						global $error;
						$error = true;
				} else {
//					echo $random . ".3.";
					return $random;
				}
			}

			$teamcode = teamcode();
//			echo $teamcode . ".5.";
			if (!$error) {
				$statement = $pdo->prepare("INSERT INTO teams(name, creator_id, team_code, description) VALUES (:teamname,:creatorid,:teamcode,:teamdiscription)");
				$result = $statement->execute(array('teamname' => $teamname, 'creatorid' => $userid, 'teamcode' => $teamcode, 'teamdiscription' => $teamdiscription));

				if(!$result) {
					echo "<style>.box p2 {display: inline;}</style>";
					echo $statement->errorInfo()[2];
					$error = true;
				} else {
					$statement = $pdo->prepare("SELECT id FROM teams WHERE team_code = :teamcode");
					$result = $statement->execute(array('teamcode' => $teamcode));
					$teams = $statement->fetch();
					$statement = $pdo->prepare("INSERT INTO in_team(user_id, team_id) VALUES (:userid,:teamid)");
					$result = $statement->execute(array('userid' => $userid, 'teamid' => $teams['id']));
					if(!$result) {
						echo "<style>.box p2 {display: inline;}</style>";
						echo $statement->errorInfo()[2];
						$error = true;
					} else {
						header('Location: index.php');
					}
				}
			} else {
				echo "<style>.box {display: block;}</style>";
				echo "<style>.modal_background {display: block;}</style>";
			}
		}

		if(isset($_GET['newdirect'])) {
			$error = false;
			$member = $_POST['newdirect'];

			if(strlen($member) == 0) {
				echo "<style>.box2 p1 {display: inline;}</style>";
				$error = true;
			}

			if(!$error) {
					$statement = $pdo->prepare("SELECT * FROM users WHERE username = :username");
					$statement->execute(array('username' => $member));
					$user = $statement->fetch();

					if($user == false) {
						echo "<style>.box2 p1 {display: inline;}</style>";
						$error = true;
					}

					if ($user['id'] == $userid) {
						echo "<style>.box2 p4 {display: inline;}</style>";
						$error = true;
					}
			}

			if(!$error) {
				$statement = $pdo->prepare("SELECT id FROM users WHERE username = :username");
				$statement->execute(array('username' => $member));
				$memberid = $statement->fetch();

				$statement = $pdo->prepare("SELECT * FROM directs WHERE user_id1 = :user1 AND user_id2 = :user2 OR user_id1 = :user2 AND user_id2 = :user1");
				$result = $statement->execute(array('user1' => $userid, 'user2' => $memberid['id']));
				$ismember = $statement->fetch();

				if($ismember !== false) {
					echo "<style>.box2 p2 {display: inline;}</style>";
					$error = true;
				} else {
					$statement = $pdo->prepare("INSERT INTO directs(user_id1, user_id2) VALUES (:user1, :user2)");
					$result = $statement->execute(array('user1' => $userid, 'user2' => $memberid['id']));
					if(!$result) {
						echo "<style>.box2 p3 {display: inline;}</style>";
						echo $statement->errorInfo()[2];
						$error = true;
					} else {
						header('Location: index.php');
					}
				}
			}
			if($error) {
				echo "<style>.box2 {display: block;}</style>";
				echo "<style>.modal_background {display: block;}</style>";
			}
		}
		?>
		<div class="modal_background" id="NewTeamModalBackground"></div>
		<div class="columns">
			<div class="box column col-xs-11 col-sm-7 col-md-6 col-lg-5 col-xl-4 col-3" id="NewTeamModal">
				<form id="BX" action="?teamcreate=1" method="post">
					<h1>New Team</h1>
					<input type="text" id="TeamName" maxlength="25" name="TeamName" placeholder="Team Name">
					<p>Bitte einen Namen für das Team eingeben</p>
					<textarea id="TeamDiscription" maxlength="255" name="TeamDiscription" rows="5" placeholder="Team Discription"></textarea>
					<p1>Bitte eine Beschreibung für das Team eingeben</p1>
					<input type="submit" id="CreateTeam" value="Create">
					<p2>Beim Abspeichern ist leider ein Fehler aufgetreten</p2>
					<p3>Beim Zufallscode generieren ist leider ein Fehler aufgetreten</p3>
				</form>
			</div>
		</div>
		<div class="columns">
			<div class="box2 column col-xs-11 col-sm-7 col-md-6 col-lg-5 col-xl-4 col-3" id="NewDirectModal">
				<form id="TBX" action="?newdirect=1" method="post">
					<h1>New Direct</h1>
					<input type="text" list="users" name="newdirect" placeholder="Username">
					<datalist id="users">
						<?php
						$statement = $pdo->prepare("SELECT * FROM users WHERE id != :userid");
	          $statement->execute(array('userid' => $userid));

						while($row = $statement->fetch()) {
							echo '<option value="' . $row['username'] . '">';
						}
						?>
					</datalist>
					<p1>Bitte einen Nutzer auswählen</p1>
					<p2>Sie führen bereits einen Direct mit diesem Nutzer</p2>
					<p4>Sie können keinen Direct mit sich selbst führen</p4>
					<input type="submit" id="NewDirect" value="Create">
					<p3>Beim Abspeichern ist leider ein Fehler aufgetreten</p3>
					<p>Es ist leider ein Fehler aufgetreten</p>
				</form>
			</div>
		</div>
  </div>
</body>
