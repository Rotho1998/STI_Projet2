<?php


require('redirect.php');
require('security.php');
// Test si l'utilisateur est connecté
if (!authentication()) {
    redirectError("You cannot access this ressource", "./index.php");
}


// Suppression de la variable $_SESSION pour la déconnexion de l'utilisateur
session_start();
$_SESSION = [];
session_unset();
session_destroy();

// Redirection vers la page d'accueil
redirectSuccess("You log out successfully", "./index.php");