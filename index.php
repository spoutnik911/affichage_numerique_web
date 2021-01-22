<?php
session_start();

require("./var_config.php");

// si déjà connecté
if(isset($_SESSION["username"]) && isset($_SESSION["token"])){
    header("Location: panel.php");
}

?>

<!DOCTYPE html>
<html lang="fr">
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

        <div class="legal_info">
            Cette webapp crée des cookies de session. Une base de donnée contient nom d'utilisateur, mot de passe, étiquettes et un lien et fait entre l'utilisateur et l'étiquette afin de lui permettre de supprimer ses étiquettes, ce lien n'est pas affiché sur l'application. le tout est hébergé dans mon appartement. Vous pouvez supprimer votre compte dans la page de sécurité.
            <a href="https://github.com/spoutnik911/affichage_numerique_web">Code source</a>. Si vous connaissez les languages utilisés, vous pouvez proposer des améliorations.
        </div>


</body>
</html>