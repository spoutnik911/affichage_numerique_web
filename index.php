<?php
session_start();

require("./var_config.php");

// si déjà connecté
if(isset($_SESSION["username"]) && isset($_SESSION["token"])){
    header("Location: panel.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Affichage numérique</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    


        <form action="./login.php" method="post" class="box">

            <?php echo isset($_GET["msg"]) ?  "<h1>". $_GET["msg"] . "</h1>": " <h1>Panneau numérique</h1>"; ?> 
            <input type="text" name="username" placeholder="username">
            <input type="password" name="password" placeholder="password">

            <input type="submit" value="Connexion" placeholder="password">
            

        </form>


</body>
</html>