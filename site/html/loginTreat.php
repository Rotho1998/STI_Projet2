<?php

require('redirect.php');
require('security.php');

// Test si l'utilisateur est connecté
if (authentication()) {
    redirectError("You cannot access this ressource", "./index.php");
}

// Définition du nom des inputs reçues
const IN_USERNAME = 'inputLogin';
const IN_PASSWORD = 'inputPassword';

const VIEW = './index.php';

// Vérification de l'entrée
if (isset($_POST[IN_USERNAME]) && $_POST[IN_USERNAME] != "" &&
    isset($_POST[IN_PASSWORD]) && $_POST[IN_PASSWORD] != "") {

    // Récupération des identifiants entrés
    $username = sanitizeInputText($_POST[IN_USERNAME]);
    $password = $_POST[IN_PASSWORD];

    // Appel de la classe de connexion
    require ('class/dbConnection.php');

    $dbConnection = new dbConnection();

    // Récupération des utilisateurs dans la bdd
    $user = $dbConnection->getUser($username);

    // Test des informations
    $rightInfos = false;

    if ($user['username'] == $username && password_verify($password, $user['password']) && $user['validity'] == 1){
        session_start();
        $_SESSION['Login'] = $username;
        $_SESSION['Role'] = $user['role'];
        // Génération d'un token pour protéger du CSRF
        $_SESSION['Token'] = bin2hex(openssl_random_pseudo_bytes(32));

        // Tout a bien fonctionné
        redirectSuccess("You are connected", VIEW);
    // Prise de temps dans le cas des informations incorrectes, puis annonce login incorrect
    } else {
        password_hash($password, PASSWORD_BCRYPT);
        redirectError("The credentials are false / the user is not active", VIEW);
    }
} else {
    redirectError("An error occured, please try again", VIEW);
}
