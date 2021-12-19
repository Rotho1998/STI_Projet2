<?php

require('security.php');
require('redirect.php');

// Test si l'utilisateur est un admin
if (!authentication(true)) {
    redirectError("You cannot access this ressource", "./index.php");
}

// Définition du nom des inputs reçues
const IN_USERNAME = 'inputUsername';
const IN_PASSWORD = 'inputPassword';
const IN_VALIDITY = 'inputValidity';
const IN_ROLE = 'inputRole';

const VIEW_ERROR = './addUser.php';
const VIEW_SUCCESS = './users.php';

// Test du token pour protéger du CSRF
$hmac = hash_hmac('sha256', 'addUser', $_SESSION['Token']);
if (!isset($_POST['token']) || $hmac != $_POST['token']) {
    redirectError("Invalid token", VIEW);
}

// Vérification des entrées
if (isset($_POST[IN_USERNAME]) && $_POST[IN_USERNAME] != "" &&
    isset($_POST[IN_PASSWORD]) && $_POST[IN_PASSWORD] != "" &&
    isset($_POST[IN_VALIDITY]) && $_POST[IN_VALIDITY] != "" &&
    isset($_POST[IN_ROLE]) && $_POST[IN_ROLE] != "") {

    // Appel de la classe de connexion
    require ('class/dbConnection.php');

    $dbConnection = new dbConnection();

    // Récupération des données entrées
    $username = sanitizeInputText($_POST[IN_USERNAME]);
    $password = $_POST[IN_PASSWORD];
    $validity = sanitizeInputBool($_POST[IN_VALIDITY]);
    $role = sanitizeInputBool($_POST[IN_ROLE]);

    // Test si le mot de passe remplit les critères d'acceptation
    if (!verifyPassword($password)) {
        // Redirection vers la page précédente avec un message d'erreur
        redirectError("The password is not strong enough", VIEW_ERROR);
    }

    $password = password_hash($password, PASSWORD_BCRYPT);

    // Ajout à la base de données
    $userAlreadyExist = $dbConnection->addUser($username, $password, $validity, $role);
    if ($userAlreadyExist) {
        // Redirection vers la page précédente avec un message d'erreur
        redirectError("Something went wrong, please try again", VIEW_ERROR);
    }

    // Tout a bien fonctionné
    redirectSuccess("The user has been added", VIEW_SUCCESS);
} else {
    // Redirection vers la page précédente avec un message d'erreur
    redirectError("An error occured in the form, please try again", VIEW_ERROR);
}