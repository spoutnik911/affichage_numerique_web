<?php
session_start();

require("./var_config.php");

$conn = new PDO("mysql:host=$mysql_host;dbname=$mysql_database;port=$mysql_port;", $mysql_username, $mysql_password);

$query = $conn->prepare("SELECT token, id FROM comptes WHERE username=:user");
$query->execute([
    ":user" => $_SESSION["username"]
]);

$rslt = $query->fetch();

if($_SESSION["token"] != $rslt["token"]){
    header("Location: ./index.html");
    return;
}


if(isset($_POST["action"])){

    try{
        switch($_POST["action"]){


            case "delete":
                $query = $conn->prepare("DELETE FROM labels WHERE user_id=:user_id AND id=:id;");
                $query->execute([
                    ":user_id" => $rslt["id"],
                    ":id" => $_POST["id"]
                ]);
                break;

            case "add":
                if(!empty($_POST["mylabel"]) && isset($_POST["mylabel"])){
                    $query = $conn->prepare("INSERT INTO labels(label, user_id) VALUES(:label, :user_id);");
                    $query->execute([
                        ":user_id" => $rslt["id"],
                        ":label" => $_POST["mylabel"]
                    ]);
                }
                break;
        
            default:
                break;
        }
        
        header("Location: ./panel.php");

    }
    catch(PDOException $e){
        header("Location: ./index.php?msg=Erreur+server");
    }

}

return;









?>