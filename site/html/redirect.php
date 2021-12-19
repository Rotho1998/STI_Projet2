<?php

/**
 * Méthode de redirection en cas d'erreur
 * @param $message -> message à afficher
 * @param $location -> page où rediriger
 */
function redirectError($message, $location) {
    session_start();
    $_SESSION['error'] = $message;
    header('Location:' . $location);
    exit;
}

/**
 * Méthode de redirection en cas de succès
 * @param $message -> message à afficher
 * @param $location -> page où rediriger
 */
function redirectSuccess($message, $location) {
    session_start();
    $_SESSION['success'] = $message;
    header('Location:' . $location);
    exit;
}