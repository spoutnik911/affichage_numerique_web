<?php
session_start();

require("./var_config.php");

$conn = new PDO("mysql:host=$mysql_host;dbname=$mysql_database;port=$mysql_port;", $mysql_username, $mysql_password);

$query = $conn->prepare("SELECT token, id, totp_key FROM comptes WHERE username=:user");
$query->execute([
    ":user" => $_SESSION["username"]
]);

$rslt = $query->fetch();

if($_SESSION["token"] != $rslt["token"] || !isset($_SESSION["token"])){
    header("Location: ./index.php");
    return;
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Affichage numérique | <?php echo $_SESSION["username"]; ?> (édition)</title>
</head>
<body>
        
    <div class="panel">
        <div class="btn" onclick="window.location.href='./panel.php';">
            Retour
        </div>

        <h1>Compte: <?php echo $_SESSION["username"]; ?></h1>
        <form action="login.php" method="POST">
            <input type="hidden" name="deconnect" value="true"/>
            <input type="submit" value="Déconnexion">
        </form>


            
            <form class="edit" action="edit_back.php" method="post">
                <?php echo isset($_GET["msg"]) ? "<h1>".$_GET["msg"]."</h1>" : "<h1>Sécurité</h1>" ?>
                <input type="password" placeholder="Ancien mot de passe" name="password0"/>
                <input type="password" placeholder="Mot de passe" name="password1"/>
                <input type="password" placeholder="Répétez le mot de passe" name="password2"/>
                <input type="submit" value="Changer">
            </form>


    </div>

</body>
</html>