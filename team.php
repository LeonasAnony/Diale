<?php
session_start();
if(!isset($_SESSION['userid'])) {
	header('Location: login.php');
	exit;
}

$userid = $_SESSION['userid'];
$pdo = new PDO('mysql:host=localhost:3306;dbname=Diale', 'Diale', '0YGFOd2p4XNXm9FQZziX32av');
require 'global/EPRequest.php';
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
	$newname = false;
	$newdescription = false;
	$edit = 0;
	$newname = $_POST['TeamName'];
	if (!isset($_POST['TeamDescription'])) {
		$newdescription = null;
	} else {
		$newdescription = $_POST['TeamDescription'];
	}

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
			$result = $statement->execute(array('name' => $newname, 'description' => $newdescription, 'teamid' => $teamid));

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
			$result = $statement->execute(array('description' => $newdescription, 'teamid' => $teamid));

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
			$result = $statement->execute(array('name' => $newname, 'teamid' => $teamid));

			if(!$result) {
				echo "<style>.box p {display: inline;}</style>";
				echo $statement->errorInfo()[2];
				$error = true;
			} else {
				header('Location: team.php?id=' . $teamid);
			}
	}
	if($error) {
		echo "<style>.box2 {display: block;}</style>";
		echo "<style>.modal_background {display: block;}</style>";
	}
}

if(isset($_GET['pad'])) {
	$error = false;
	$padname = $_POST['PadName'];

	if(strlen($padname) == 0) {
		echo "<style>.box3 p1 {display: inline;}</style>";
		$error = true;
	}

	if(!$error) {
		$padtext = "Welcome to DialePad: " . $padname . " which is dedicated to Group: " . $team['name'] . "!";
		$response = request("createGroupPad", null, 3, true, $team['ep_groupID'], $padname, $padtext);

		if($response['code'] != 0) {
			echo "<style>.box3 p2 {display: inline;}</style>";
			$error = true;
		}
		if ($response['message'] == "pad does already exist") {
			echo "<style>.box3 p3 {display: inline;}</style>";
			$error = true;
		}
		if($response['code'] == 0) {
			header('Location: team.php?id=' . $teamid);
		}
	}

	if($error) {
		echo "<style>.box3 {display: block;}</style>";
		echo "<style>.modal_background {display: block;}</style>";
	}
}
?>
<!doctype html>
<head>
	<meta charset="utf-8" name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0'/>
	<title>Diale</title>
	<link rel="icon" href="global/Favicons/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="spectre/dist/spectre.min.css">
<!--  <link rel="stylesheet" href="main/css/sidebar.css">-->
	<link rel="stylesheet" href="CSS/loader.css">
	<link rel="stylesheet" href="CSS/team.css">
	<link href="global/fontawesome/css/all.css" rel="stylesheet">
</head>
<body>
	<div class="spinner">
    <div class="right">
      <h4 class="randoms top"></h4>
      <h1 class="randoms middle"></h1>
      <h4 class="randoms bottom"></h4>
    </div>
    <div class="left">
      <h4 class="randoms top"></h4>
      <h1 class="randoms middle"></h1>
      <h4 class="randoms bottom"></h4>
    </div>
  </div>
  <script language="javascript" type="text/javascript" src="JS/loader.js"></script>
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
      <div class="BoxDiv column col-lg-10 col-4">
        <div class="center">
          <img src="user-data/teams/id<?php echo $team['id'];?>.png" id="TeamPicture"/>
        </div>
        <div>
					<h2 class="Headline">
            <?php echo $team['name'];?>
          </h2>
				</div>
        <div>
					<p id="TeamDescription">
            <?php echo $team['description'];?>
          </p>
				</div>
				<hr class="Line">
				<p class="fonts">Code:</p>
				<p id="TeamCode">
					<?php echo $team['team_code'];?>
				</p>
        <div>
					<p id="edit" onclick="edit()">Bearbeiten</p>
				</div>
      </div>
      <div class="column col-lg-1 col-2"></div>
      <div class="column show-lg col-1"></div>
      <div class="BoxDiv column col-lg-10 col-4">
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

          echo '<div class="boxes" onclick="User(' . $teamid. ',' . $users['id']. ')"><img class="profilepicture hide-sm" src="user-data/users/id' . $users['id']. '.png" alt="ProfilePicture"/><p class="fonts">' . $users['username']. '</p></div><hr class="Line">';
        }
        ?>
				<!-- new Member Footer -->
        <div class="boxes" onclick="addMember()">
          <p class="fonts">Add Member</p>
        </div>
      </div>
			<div class="column col-1"></div>

			<!---------------------------------->

			<div class="column col-1"></div>
      <!-- Description ContentBox -->
      <div class="BoxDiv column col-md-10 col-4">
        <img class="profilepicture" src="global/IconsPurple/Icon_PadLila.png" alt="IconTeams"/>
        <h2 class="Headline">Pad's</h2>
        <hr class="HeadUnderline">
				<?php
        $grouppadids = request('listPads', 'padIDs', 1, false, $team['ep_groupID']);

        foreach ($grouppadids as $padid) {
          $padidsplit = explode("$", $padid);

          echo '<div class="boxes" onclick="Pad(`' . $padid . '`)"><p class="fonts">' . $padidsplit[1] . '</p><i class="fas fa-trash fa-lg" onclick="DeletePad(`' . $padid . '`)"></i></div><hr class="Line">';
        }
        ?>
				<div class="boxes" onclick="newPad()">
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
				<div class="boxes" onclick="newDate()">
          <p class="fonts">New Date</p>
        </div>
      </div>
			<div class="column col-1"></div>
    </div>
		<div class="modal_background" id="ModalBackground"></div>
		<div class="columns">
			<div class="box column col-xs-11 col-sm-7 col-md-6 col-lg-5 col-xl-4 col-3" id="addMemberModal">
				<form id="TBX" action="?id=<?php echo $teamid;?>&add=true" method="post">
					<h1>Add Member</h1>
					<input type="text" list="users" name="newmember" placeholder="Username">
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
				<form id="TBX" action="?id=<?php echo $teamid;?>&edit=true" method="post">
					<h1>Edit Team</h1>
					<input type="text" maxlength="25" name="TeamName" value="<?php echo $team['name'];?>">
					<textarea id="TeamDescription" maxlength="255" name="TeamDescription" rows="5"><?php echo $team['description'];?></textarea>
					<input type="submit" id="EditTeam" value="Edit">
					<p>Beim Abspeichern ist leider ein Fehler aufgetreten</p>
				</form>
			</div>
		</div>
		<div class="columns">
			<div class="box3 column col-xs-11 col-sm-7 col-md-6 col-lg-5 col-xl-4 col-3" id="newPadModal">
				<form id="TBX" action="?id=<?php echo $teamid;?>&pad=true" method="post">
					<h1>New Pad</h1>
					<p3>Dieses Pad existiert bereits</p3>
					<input type="text" maxlength="50" name="PadName" placeholder="Pad Name">
					<p>Creating a Pad which is<br/>shared with the Team:<br/><b style="text-decoration: underline;"><?php echo $team['name'];?></b></p>
					<p1>Bitte einen Namen für das neue Pad eingeben</p1>
					<input type="submit" id="CreatePad" value="Create">
					<p2>Beim erstellen ist ein Fehler aufgetreten</p2>
				</form>
			</div>
		</div>
<!--		<div class="columns">
			<div class="box4 column col-xs-11 col-sm-8 col-md-7 col-lg-6 col-xl-5 col-4" id="UserModal">
				< ?php
				if(isset($_GET['user'])) {
					echo "<style>#UserModal {display: block;}</style>";
					echo "<style>#ModalBackground {display: block;}</style>";
					$membermodalid = $_GET['user'];

					$statement = $pdo->prepare("SELECT * FROM users WHERE id = :userid");
					$result = $statement->execute(array('userid' => $membermodalid));
					$user = $statement->fetch();
				}
				?>
        <div>
					<h1>< ?php echo $user['username'];?></h1>
				</div>
				<div class="center">
          <img src="global/user< ?php echo $user['id'];?>.png" id="UserPicture"/>
        </div>
			</div>
		</div>-->
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
	<script src="https://code.jquery.com/jquery-1.12.3.min.js"></script>
	<script src="global/Jcrop/js/jquery.Jcrop.min.js"></script>
	<script language="javascript" type="text/javascript" src="JS/team.js"></script>
</body>
