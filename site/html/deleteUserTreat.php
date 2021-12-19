<?php

require('redirect.php');

// Définition du nom des inputs reçues
const IN_USER = 'userToDelete';

const VIEW = './users.php';

// Vérification de l'entrée
if(isset($_POST[IN_USER]) && $_POST[IN_USER] != "") {
    // Appel de la classe de connexion
    require ('class/dbConnection.php');

    $dbConnection = new dbConnection();

    // Récupération des identifiants entrés
    $username = $_POST[IN_USER];

    $dbConnection->deleteUser($username);

    // Tout a bien fonctionné
    redirectSuccess("The user has been deleted", VIEW);
} else {
    // Redirection vers la page précédente avec un message d'erreur
    redirectError("An error occured, please try again", VIEW);
}
