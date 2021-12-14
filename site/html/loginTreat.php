<html>
<head></head>
<body>

<?php

// Appel de la classe de connexion
require ('class/dbConnection.php');

$dbConnection = new dbConnection();

// Récupération des identifiants entrés
$username = $_POST['inputLogin'];
$password = $_POST['inputPassword'];

// Récupération des utilisateurs dans la bdd
$user = $dbConnection->getUser($username);

// Test des informations
$rightInfos = false;
$isAdmin = false;

if ($user['username'] == $username && $user['password'] == $password && $user['validity'] == 1){
    $rightInfos = true;
    if($user['role'] == 1){
        $isAdmin = true;
    }
}

session_start();

// Si cela correspond, on ouvre la connexion, puis on redirige vers la page index.php
if($rightInfos == true) {
    $_SESSION['Login'] = $username;
    if($isAdmin == true){
        $_SESSION['IsAdmin'] = 1;
    }
}

header('Location:./index.php');

?>

</body>
</html>
