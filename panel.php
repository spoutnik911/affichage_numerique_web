<?php
session_start();

require("./var_config.php");

$conn = new PDO("mysql:host=$mysql_host;dbname=$mysql_database;port=$mysql_port;", $mysql_username, $mysql_password);

$query = $conn->prepare("SELECT token, id FROM comptes WHERE username=:user");
$query->execute([
    ":user" => $_SESSION["username"]
]);

$rslt = $query->fetch();

if($_SESSION["token"] != $rslt["token"] || !isset($_SESSION["token"])){
    session_destroy();
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
    <title>Affichage numérique | <?php echo $_SESSION["username"]; ?></title>
</head>
<body>
        
    <div class="panel">

        <h1>Bienvenue, <?php echo $_SESSION["username"]; ?></h1>
        <form action="login.php" method="POST">
            <input type="hidden" name="deconnect" value="true"/>
            <input type="submit" value="Déconnexion">
        </form>
        <div class="btn" onclick="window.location.href='./edit.php';">
            Sécurité
        </div>

        <div class="table">
            
            <form action="my_label.php" class="mylabel" method="post">
                <textarea maxlength="500" placeholder="Blablabla (500 caractères max)" name="mylabel"></textarea>
                <input type="hidden" name="action" value="add"/>
                <input type="submit" value="Envoyer"/>
            </form>

            <?php
            try{
                $conn = new PDO("mysql:host=$mysql_host;port=$mysql_host;dbname=$mysql_database;", $mysql_username, $mysql_password);

                $query = $conn->prepare("SELECT * FROM labels");
                $query->execute();
                $labels = $query->fetchAll();

                if(!$labels) return;

                foreach($labels as $label){

                    $label_str = $label["label"];
                    $label_id  = $label["id"];
                    $label_userID = $label["user_id"];

                    echo "<div class='row'>$label_str";

                    if($label_userID == $rslt["id"]){
                        echo <<<EOT
                        <form method="post" action="my_label.php" >
                        <input type="hidden" name="id" value="$label_id"/>
                        <input type="hidden" name="action" value="delete"/>
                        <input type="submit" value="Supprimer"/>
                        </form>
                        EOT;
                    }

                    echo "</div>";
                   
                                }
            }
            catch(PDOException $e){
                echo $e;
            }
              

            ?>
   

        </div>
        


    </div>

</body>
</html>