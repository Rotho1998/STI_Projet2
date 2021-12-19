<?php
require('class/security.php');
require('class/redirect.php');

// Définition du nom des inputs reçues
const IN_USERNAME = 'inputUsername';
const IN_PASSWORD = 'inputPassword';
const IN_VALIDITY = 'inputValidity';
const IN_ROLE = 'inputRole';

const VIEW = './users.php';

// Vérification des entrées
if (isset($_POST[IN_USERNAME]) && $_POST[IN_USERNAME] != "" &&
    isset($_POST[IN_PASSWORD]) && // Le mdp peut être vide si on ne veut pas le changer
    isset($_POST[IN_VALIDITY]) && $_POST[IN_VALIDITY] != "" &&
    isset($_POST[IN_ROLE]) && $_POST[IN_ROLE] != "") {

    // Appel de la classe de connexion
    require ('class/dbConnection.php');

    $dbConnection = new dbConnection();

    // Récupération des identifiants entrés
    $username = $_POST[IN_USERNAME];
    $pwd = $_POST[IN_PASSWORD];
    $validity = $_POST[IN_VALIDITY];
    $role = $_POST[IN_ROLE];

    // Ne pas modifier le mot de passe
    if($pwd == ""){
        $dbConnection->editUserWithoutPassword($username, $validity, $role);
    } else {
        // Test si le mot de passe remplit les critères d'acceptation
        if (!verifyPassword($pwd)) {
            // Redirection vers la page précédente avec un message d'erreur
            redirectError("The password is not strong enough", VIEW);
        }

        $pwd = password_hash($pwd, PASSWORD_BCRYPT);
        $dbConnection->editUser($username, $pwd, $validity, $role);
    }

    // Tout a bien fonctionné
    redirectSuccess("The user has been edited", VIEW);
} else {
    // Redirection vers la page précédente avec un message d'erreur
    redirectError("An error occured in the form, please try again", VIEW);
}
