<?php

// Suppression de la variable $_SESSION pour la déconnexion de l'utilisateur
session_start();
$_SESSION = [];
session_unset();
session_destroy();

// Redirection vers la page d'accueil
header('Location:./index.php');