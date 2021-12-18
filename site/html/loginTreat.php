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

if ($user['username'] == $username && password_verify($password, $user['password']) && $user['validity'] == 1){
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
// Prise de temps dans le cas des informations incorrectes
} else {
    password_hash($password, PASSWORD_BCRYPT);
}

header('Location:./index.php');
