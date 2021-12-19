<?php

require('redirect.php');

// Définition du nom des inputs reçues
const IN_USERNAME = 'inputLogin';
const IN_PASSWORD = 'inputPassword';

const VIEW = './index.php';

// Vérification de l'entrée
if (isset($_POST[IN_USERNAME]) && $_POST[IN_USERNAME] != "" &&
    isset($_POST[IN_PASSWORD]) && $_POST[IN_PASSWORD] != "") {

    // Récupération des identifiants entrés
    $username = $_POST[IN_USERNAME];
    $password = $_POST[IN_PASSWORD];

    // Appel de la classe de connexion
    require ('class/dbConnection.php');

    $dbConnection = new dbConnection();

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

    // Si cela correspond, on ouvre la connexion, puis on redirige vers la page index.php
    if($rightInfos == true) {
        session_start();
        $_SESSION['Login'] = $username;
        if($isAdmin == true){
            $_SESSION['IsAdmin'] = 1;
        }
    // Prise de temps dans le cas des informations incorrectes, puis annonce login incorrect
    } else {
        password_hash($password, PASSWORD_BCRYPT);
        redirectError("The credentials are false", VIEW);
    }

    // Tout a bien fonctionné
    redirectSuccess("You are connected", VIEW);
} else {
    redirectError("An error occured, please try again", VIEW);
}
