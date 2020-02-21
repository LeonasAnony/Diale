<?php
session_start();
//echo("PHp works");
$pdo = new PDO('mysql:host=diale-db.ddns.net:3306;dbname=Diale', 'Diale', '0YGFOd2p4XNXm9FQZziX32av');
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>DaLe Login</title>
    <link rel="icon" href="../../global/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../css/style.css">
  </head>
  <body>
    <?php
    if(isset($_GET['login'])) {
      $email = $_POST['email'];
      $passwort = $_POST['password'];

      $statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
      $result = $statement->execute(array('email' => $email));
      $user = $statement->fetch();

      //Überprüfung des Passworts
      if ($user !== false && password_verify($passwort, $user['passwort'])) {
          $_SESSION['userid'] = $user['id'];
          header('Location: ../../main/php/index.php');
        } else {
          //$errorMessage = "E-Mail oder Passwort war ungültig<br>";
          echo "<style>.box p {display: inline;}</style>";
        }
    }

    if(isset($errorMessage)) {
      echo $errorMessage;
    }
    ?>
    <form class="box" id="BX" action="?login=1" method="post">
      <h1>Login</h1>
      <p1>Account wurde erfolgreich erstellt</p1>
      <input type="text" id="EM" size="40" maxlength="250" name="email" placeholder="E-mail">
      <input type="password" id="PW" size="40"  maxlength="250" name="password" placeholder="Password">
      <p>E-Mail oder Passwort ist ungültig</p>
      <input type="submit" id="LN" value="Login">
      <a href="../../regis/php/index.php">Registrieren</a>
    </form>
  </body>
</html>
