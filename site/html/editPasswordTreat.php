<?php

require('security.php');
require('redirect.php');

// Définition du nom des inputs reçues
const IN_PASSWORD = 'inputPassword';
const IN_PASSWORD_REPEAT = 'inputPasswordRepeat';

const VIEW_ERROR = './editPassword.php';
const VIEW_SUCCESS = './index.php';

// Vérification de l'entrée
if(isset($_POST[IN_PASSWORD]) && $_POST[IN_PASSWORD] != "" &&
    isset($_POST[IN_PASSWORD_REPEAT]) && $_POST[IN_PASSWORD_REPEAT] != "") {

    // Récupération des identifiants entrés
    $pwd = $_POST['inputPassword'];
    $pwdRepeat = $_POST['inputPasswordRepeat'];

    // Test si le mot de passe remplit les critères d'acceptation
    if (!verifyPassword($pwd)) {
        // Redirection vers la page précédente avec un message d'erreur
        redirectError("The password is not strong enough", VIEW_ERROR);
    }

    if($pwd == $pwdRepeat){
        // Appel de la classe de connexion
        require ('class/dbConnection.php');

        $pwd = password_hash($pwd, PASSWORD_BCRYPT);

        $dbConnection = new dbConnection();
        session_start();
        $dbConnection->editPassword($_SESSION['Login'], $pwd);

        // Tout a bien fonctionné
        redirectSuccess("The password has been changed", VIEW_SUCCESS);
    } else {
        // Redirection vers la page précédente avec un message d'erreur
        redirectError("The passwords doesn't match", VIEW_ERROR);
    }
} else {
    // Redirection vers la page précédente avec un message d'erreur
    redirectError("An error occured, please try again", VIEW_ERROR);
}
