<?php

require('redirect.php');
require('security.php');

// Test si l'utilisateur est admin
if (!authentication(true)) {
    redirectError("You cannot access this ressource", "./index.php");
}


// Définition du nom des inputs reçues
const IN_USER = 'userToDelete';

const VIEW = './users.php';

// Test du token pour protéger du CSRF
$hmac = hash_hmac('sha256', 'deleteUser', $_SESSION['Token']);
if (!isset($_POST['token']) || $hmac != $_POST['token']) {
    redirectError("Invalid token", VIEW);
}

// Vérification de l'entrée
if(isset($_POST[IN_USER]) && $_POST[IN_USER] != "") {
    // Appel de la classe de connexion
    require ('class/dbConnection.php');

    $dbConnection = new dbConnection();

    // Récupération des identifiants entrés
    $username = sanitizeInputText($_POST[IN_USER]);

    $dbConnection->deleteUser($username);

    // Tout a bien fonctionné
    redirectSuccess("The user has been deleted", VIEW);
} else {
    // Redirection vers la page précédente avec un message d'erreur
    redirectError("An error occured, please try again", VIEW);
}
