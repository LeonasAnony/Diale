<?php
session_start();
$pdo = new PDO('mysql:host=localhost:3306;dbname=DaLe', 'root', '');
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>DaLe Registration</title>
    <link rel="stylesheet" href="../css/style.css">
    <!--<script type="text/javascript" src="../js/script.js"></script>-->
  </head>
  <body>
    <?php
    $showFormular = true; //Variable ob das Registrierungsformular anezeigt werden soll
    $username = false;
    $email = false;

    if(isset($_GET['register'])) {
        $error = false;
        $username = $_POST['username'];
        $email = $_POST['email'];
        $passwort = $_POST['passwort'];
        $passwort2 = $_POST['passwort2'];

        if(strlen($username) == 0) {
          //echo 'Bitte einen Usernamen eingeben';
          echo "<style>.box p {display: inline;}</style>";
          $error = true;
        }
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            //echo "Bitte eine gültige E-Mail-Adresse eingeben<br>";
            echo "<style>.box p2 {display: inline;}</style>";
            $error = true;
        }
        if(strlen($passwort) == 0) {
            //echo 'Bitte ein Passwort angeben<br>';
            echo "<style>.box p3 {display: inline;}</style>";
            $error = true;
        }
        else {
            if(strlen($passwort) < 8){
                echo "<style>.box p7 {display: inline;}</style>";
                $error = true;
            }
        }
        if($passwort != $passwort2) {
            //echo 'Die Passwörter müssen übereinstimmen<br>';
            echo "<style>.box p4 {display: inline;}</style>";
            $error = true;
        }

        //Überprüfe, dass die E-Mail-Adresse noch nicht registriert wurde
        if(!$error) {
            $statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
            $result = $statement->execute(array('email' => $email));
            $user = $statement->fetch();

            if($user !== false) {
                //echo 'Diese E-Mail-Adresse ist bereits vergeben<br><?php';
                echo "<style>.box p5 {display: inline;}</style>";
                $error = true;
            }
        }

        //Keine Fehler, wir können den Nutzer registrieren
        if(!$error) {
            $passwort_hash = password_hash($passwort, PASSWORD_BCRYPT);

            $statement = $pdo->prepare("INSERT INTO users (email, passwort, username, firstlogin) VALUES (:email, :passwort, :username, 1)");
            $result = $statement->execute(array('email' => $email, 'passwort' => $passwort_hash, 'username' => $username));

            if($result) {
                //echo 'Du wurdest erfolgreich registriert. <a href="login.php">Zum Login</a>';
                header('Location: ../../login/php/index.php');
                $showFormular = false;
            } else {
                //echo 'Beim Abspeichern ist leider ein Fehler aufgetreten<br>';
                echo "<style>.box p6 {display: inline;}</style>";
                echo $statement->errorInfo()[2];
            }
        }
    }
    ?>
    <form class="box" id="BX" action="?register=1" method="post">
      <h1>Registration</h1>
      <input type="text" id="US" name="username" placeholder="Username" value="<?php echo $username;?>" autocomplete="off">
      <p>Bitte einen Usernamen eingeben</p>
      <input type="text" id="EM" name="email" placeholder="Your E-Mail" value="<?php echo $email;?>" autocomplete="off">
      <p2>Bitte eine gültige E-Mail-Adresse eingeben</p2>
      <p5>Diese E-Mail-Adresse ist bereits vergeben</p5>
      <input type="password" id="PW" name="passwort" placeholder="Password">
      <p3>Bitte ein Passwort angeben</p3>
      <p7>Das Passwort muss mindestens 8 Zeichen haben</p7>
      <input type="password" id="PW2" name="passwort2" placeholder="Confirm">
      <p4>Die Passwörter müssen übereinstimmen</p4>
      <input type="submit" id="LN" name="LN" value="Register">
      <p6>Beim Abspeichern ist leider ein Fehler aufgetreten</p6>
      <a href="../../login/php/index.php">Login</a>
    </form>
  </body>
</html>
