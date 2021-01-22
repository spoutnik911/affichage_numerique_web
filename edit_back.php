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

if($_SESSION["username"] == "testeur") header("Location: ./edit.php?msg=Vous+ne+pouvez+pas+changez+un+compte+de+teste"); return;

if(!empty($_POST["password1"]) && !empty($_POST["password0"]) && $_POST["password1"] == $_POST["password2"] && isset($_POST["password1"]) && isset($_POST["password0"]) && isset($_POST["password2"])){

    if(sizeof(str_split($_POST["password1"])) < 20){ header("Location: ./edit.php?msg=20+caract%C3%A8res+minimum"); return;}
    if(preg_match_all("/[0-9]/", $_POST["password1"]) < 2){ header("Location: ./edit.php?msg=2+Chffres+minimum"); return;}
    if(preg_match_all("/[A-Z]/", $_POST["password1"]) < 2){ header("Location: ./edit.php?msg=2+majuscules+minimum"); return;}
    if(preg_match_all("/[a-z]/", $_POST["password1"]) < 2){ header("Location: ./edit.php?msg=2+minuscules+minimum"); return;}

    $password = password_hash($_POST["password1"], PASSWORD_DEFAULT);


    try{
        $conn = new PDO("mysql:host=$mysql_host;port=$mysql_port;dbname=$mysql_database;", $mysql_username, $mysql_password);
        $query = $conn->prepare("SELECT password FROM comptes WHERE username=:user");
        $query->execute([
            ":user" => $_SESSION["username"]
        ]);
        if(!password_verify($_POST["password0"], $query->fetch()["password"])){ header("Location: ./edit.php?msg=Mot+de+passe+incorrect"); return;}
        
        $query = $conn->prepare("UPDATE comptes SET password=:password WHERE username=:user");
        $password = password_hash($_POST["password1"], PASSWORD_DEFAULT);
        $query->execute([
            ":user" => $_SESSION["username"],
            ":password" => $password
        ]);
        session_destroy();
        header("Location: ./index.php?msg=Mot+de+passe+chang%C3%A9%2C+reconnexion");
        return;
    }
    catch(PDOException $e){
        header("Location: ./index.php?msg=Erreur+server");
    }



}
else{
    header("Location: ./edit.php?msg=Champ+menquant");
}






?>