<?php

require('redirect.php');
require ('security.php');

// Test si l'utilisateur est connecté
if (!authentication()) {
    redirectError("You cannot access this ressource", "./index.php");
}


// Définition du nom des inputs reçues
const IN_ID = 'idMessage';

const VIEW = './index.php';

// Test du token pour protéger du CSRF
$hmac = hash_hmac('sha256', 'deleteMessage', $_SESSION['Token']);
if (!isset($_POST['token']) || !(hash_equals($hmac, $_POST['token']))) {
    redirectError("Invalid token", VIEW);
}

// Vérification de l'entrée
if(isset($_POST[IN_ID]) && $_POST[IN_ID] != "") {
    // Appel de la classe de connexion
    require ('class/dbConnection.php');

    $dbConnection = new dbConnection();

    // Récupération des identifiants entrés
    $id = sanitizeInputInt($_POST[IN_ID]);

    session_start();

    $username = $_SESSION['Login'];
    $invalidID = $dbConnection->deleteMessage($id, $username);
    if($invalidID){
        // Redirection vers la page précédente avec un message d'erreur
        redirectError("Something went wrong, please try again", VIEW);
    }

    // Tout a bien fonctionné
    redirectSuccess("The message has been deleted", VIEW);
} else {
    // Redirection vers la page précédente avec un message d'erreur
    redirectError("An error occured, please try again", VIEW);
}
