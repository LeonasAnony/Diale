<?php
session_start();
if(!isset($_SESSION['userid'])) {
	header('Location: login.php');
	exit;
}

$userid = $_SESSION['userid'];
$pdo = new PDO('mysql:host=localhost:3306;dbname=Diale', 'Diale', '0YGFOd2p4XNXm9FQZziX32av');
$teamid = $_GET['id'];
$statement = $pdo->prepare("SELECT * FROM in_team WHERE team_id = :teamid AND user_id = :userid");
$result = $statement->execute(array('teamid' => $teamid, 'userid' => $userid));
$permission = $statement->fetch();

if($permission == false) {
	echo 'Error: You have no permission for the Team with the id: ' . $teamid . '<br/>';
	die('<a href="index.php">Go back to the Startpage</a>');
}
$statement = $pdo->prepare("SELECT * FROM teams WHERE id = :teamid");
$result = $statement->execute(array('teamid' => $teamid));
$team = $statement->fetch();
?>
<!doctype html>
<head>
	<meta charset="utf-8" name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0'/>
	<title>Diale</title>
	<link rel="icon" href="global/Favicons/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="spectre/dist/spectre.min.css">
<!--  <link rel="stylesheet" href="main/css/sidebar.css">-->
	<link rel="stylesheet" href="CSS/team.css">
	<script language="javascript" type="text/javascript" src="JS/team.js"></script>
</head>
<body>
  <div class="container">
    <!-- Header -->
    <div class="columns col-oneline" id="HeadDiv">
      <div class="column col-xs-3 col-lg-2 col-1" id="MenuDiv">
        <img src="global/IconsPurple/MenuLila.png" id="Menuicon" onclick="ShowSidebar()"/>
      </div>
      <div class="column col-md-6 col-sm-9 col-4 col-mx-auto" onclick="GoBack()">
        <img class="center" src="global/Logos/Diale_text_new.png" id="headline"/>
      </div>
    </div>
    <!-- Content -->
    <div class="columns">
      <div class="column col-1"></div>
      <!-- Description ContentBox -->
      <div class="BoxDiv column col-md-10 col-4">
        <div class="center">
          <img src="global/team<?php echo $team['id'];?>.png" id="TeamPicture"/>
        </div>
        <div>
					<h2 class="Headline">
            <?php echo $team['name'];?>
          </h2>
				</div>
        <div>
					<p id="TeamDescription">
            <?php echo $team['description'];?>
          <p>
					</div>
        <div>
					<p id="edit" onclick="edit()">Bearbeiten</p>
				</div>
      </div>
      <div class="column col-md-1 col-2"></div>
      <div class="column show-md col-1"></div>
      <div class="BoxDiv column col-md-10 col-4">
        <img class="profilepicture" src="global/IconsPurple/Icon_GruppenLila.png" alt="IconTeams"/>
        <h2 class="Headline">Members</h2>
        <hr class="HeadUnderline">
        <!-- Members Modul
        <div class="boxes">
          <img class="profilepicture hide-sm" src="global/team1.png" alt="ProfilePicture"/>
          <p class="fonts">Haiiiii</p>
        </div>
        <hr class="Line">
        Members Modul End -->
        <?php
        $stack = array();
        $statement = $pdo->prepare("SELECT user_id FROM in_team WHERE team_id = :teamid");
        $statement->execute(array('teamid' => $teamid));
        while($loopdata = $statement->fetch()) {
          $stack = array_merge($stack, $loopdata);
        }

        array_shift($stack);
        foreach ($stack as $loopdata) {
          $statement = $pdo->prepare("SELECT * FROM users WHERE id = :userid");
          $result = $statement->execute(array('userid' => $loopdata));
          $users = $statement->fetch();

          echo '<div class="boxes" onclick="User(' . $users['id']. ')"><img class="profilepicture hide-sm" src="global/team' . $users['id']. '.png" alt="ProfilePicture"/><p class="fonts">' . $users['username']. '</p></div><hr class="Line">';
        }
        ?>
        <!-- new Member Footer -->
        <div class="boxes" onclick="AddMember()">
          <p class="fonts">Add Member</p>
        </div>
      </div>
			<div class="column col-1"></div>
    </div>
		<?php
		if(isset($_GET['add'])) {
			$error = false;
			$member = $_POST['newmember'];

			if(strlen($member) == 0) {
				echo "<style>.box p1 {display: inline;}</style>";
				$error = true;
			}

			if(!$error) {
					$statement = $pdo->prepare("SELECT * FROM users WHERE username = :username");
					$statement->execute(array('username' => $member));
					$user = $statement->fetch();

					if($user == false) {
							echo "<style>.box p1 {display: inline;}</style>";
							$error = true;
					}
			}

			if(!$error) {
				$statement = $pdo->prepare("SELECT id FROM users WHERE username = :username");
				$statement->execute(array('username' => $member));
				$memberid = $statement->fetch();

				$statement = $pdo->prepare("SELECT * FROM in_team WHERE team_id = :teamid AND user_id = :userid");
				$result = $statement->execute(array('teamid' => $teamid, 'userid' => $memberid['id']));
				$ismember = $statement->fetch();

				if($ismember !== false) {
					echo "<style>.box p2 {display: inline;}</style>";
					$error = true;
				} else {
					$statement = $pdo->prepare("INSERT INTO in_team(user_id, team_id) VALUES (:userid, :teamid)");
					$result = $statement->execute(array('userid' => $memberid['id'], 'teamid' => $teamid));
					if(!$result) {
						echo "<style>.box p3 {display: inline;}</style>";
						echo $statement->errorInfo()[2];
						$error = true;
					} else {
						header('Location: team.php?id=' . $teamid);
					}
				}
			}
			if($error) {
				echo "<style>.box {display: block;}</style>";
				echo "<style>.modal_background {display: block;}</style>";
			}
		}

		if(isset($_GET['edit'])) {
			$error = false;
			$edit = 0;
			$newname = $_POST['TeamName'];
			$newdescription = $_POST['TeamDescription'];

			echo $newname;
			echo $newdescription;

			if(strlen($newname) == 0 AND strlen($newdescription) == 0) {
				header('Location: team.php?id=' . $teamid);
				exit;
			}

			if(strlen($newname) == 0 AND strlen($newdescription) > 0) {
				$edit = 1;
			}

			if(strlen($newname) > 0 AND strlen($newdescription) == 0) {
				$edit = 2;
			}

			if($edit == 0) {
					$statement = $pdo->prepare("UPDATE teams SET name = :name, description = :description WHERE id = :teamid");
					$result = $statement->execute(array('name' => $newname, 'description' => $newdescription));

					if(!$result) {
						echo "<style>.box p {display: inline;}</style>";
						echo $statement->errorInfo()[2];
						$error = true;
					} else {
						header('Location: team.php?id=' . $teamid);
					}
			}

			if($edit == 1) {
					$statement = $pdo->prepare("UPDATE teams SET description = :description WHERE id = :teamid");
					$result = $statement->execute(array('description' => $newdescription));

					if(!$result) {
						echo "<style>.box p {display: inline;}</style>";
						echo $statement->errorInfo()[2];
						$error = true;
					} else {
						header('Location: team.php?id=' . $teamid);
					}
			}

			if($edit == 2) {
					$statement = $pdo->prepare("UPDATE teams SET name = :name WHERE id = :teamid");
					$result = $statement->execute(array('name' => $newname));

					if(!$result) {
						echo "<style>.box p {display: inline;}</style>";
						echo $statement->errorInfo()[2];
						$error = true;
					} else {
						header('Location: team.php?id=' . $teamid);
					}
			}
		}
		?>
		<div class="modal_background" id="ModalBackground"></div>
		<div class="columns">
			<div class="box column col-xs-11 col-sm-7 col-md-6 col-lg-5 col-xl-4 col-3" id="AddMemberModal">
				<form id="TBX" action="?id=<?php echo $teamid;?>&add=1" method="post">
					<h1>Add Member</h1>
					<input type="text" list="users" name="newmember">
					<datalist id="users">
						<?php
						$statement = $pdo->prepare("SELECT * FROM users");
	          $statement->execute();

						while($row = $statement->fetch()) {
							echo '<option value="' . $row['username'] . '">';
						}
						?>
					</datalist>
					<p1>Bitte einen Nutzer auswählen</p1>
					<p2>Dieser Nutzer ist schon Mitglied in diesem Team</p2>
					<input type="submit" id="AddMember" value="Add">
					<p3>Beim Abspeichern ist leider ein Fehler aufgetreten</p3>
					<p>Es ist leider ein Fehler aufgetreten</p>
				</form>
			</div>
		</div>
		<div class="columns">
			<div class="box2 column col-xs-11 col-sm-7 col-md-6 col-lg-5 col-xl-4 col-3" id="editTeamModal">
				<form id="TBX" action="?id=<?php echo $teamid;?>&edit=1" method="post">
					<h1>Edit Team</h1>
					<input type="text" maxlength="25" name="TeamName" placeholder="<?php echo $team['name'];?>">
					<textarea id="TeamDescription" maxlength="255" name="TeamDiscription" rows="5" placeholder="<?php echo $team['description'];?>"></textarea>
					<input type="submit" id="EditTeam" value="Edit">
					<p>Beim Abspeichern ist leider ein Fehler aufgetreten</p>
				</form>
			</div>
		</div>
		<div class="columns">
			<div class="column col-xs-12 col-sm-6 col-md-5 col-lg-4 col-xl-4 col-3" id="SidebarModal">
				<div class="column col-12">
					<img width="99%" alt="Diale_logo" src="global/Logos/Diale_text_new.png" id="SidebarLogo"/>
				</div>
				<hr/>
				<div class="columns col-oneline" onclick="Messenger()">
					<div class="logos column col-4">
						<img height="60%" alt="Messenger_logo" src="global/IconsPurple/Icon_MessengerLila.png"/>
					</div>
					<div class="column col-8 col-lg-auto">
						<h2 class="SB-fonts">Message's</h2>
					</div>
				</div>
				<div class="columns col-oneline" onclick="Pads()">
					<div class="logos column col-4">
						<img height="60%" alt="Pad_logo" src="global/IconsPurple/Icon_PadLila.png"/>
					</div>
					<div class="column col-8 col-lg-auto">
						<h2 class="SB-fonts">Pad's</h2>
					</div>
				</div>
				<div class="columns col-oneline" onclick="Boards()">
					<div class="logos column col-4">
						<img height="60%" alt="Checklist_logo" src="global/IconsPurple/Icon_ChecklistLila.png"/>
					</div>
					<div class="column col-8 col-lg-auto">
						<h2 class="SB-fonts">Board's</h2>
					</div>
				</div>
				<div class="columns col-oneline" onclick="Kalender()">
					<div class="logos column col-4">
						<img height="60%" alt="Kalender_logo" src="global/IconsPurple/Icon_KalenderLila.png"/>
					</div>
					<div class="column col-8 col-lg-auto">
						<h2 class="SB-fonts">Kalender</h2>
					</div>
				</div>
				<div class="columns col-oneline" onclick="Datein()">
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
