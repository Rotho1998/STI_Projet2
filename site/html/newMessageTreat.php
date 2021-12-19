<?php

require ('redirect.php');
require ('security.php');

// Test si l'utilisateur est connecté
if (!authentication()) {
    redirectError("You cannot access this ressource", "./index.php");
}

// Définition du nom des inputs reçues
const IN_TO = 'inputTo';
const IN_SUBJECT = 'inputSubject';
const IN_MESSAGE = 'inputMessage';
const IN_ID_MESSAGE = 'idMessage';

const VIEW_ERROR = './newMessage.php';
const VIEW_SUCCESS = './index.php';

// Test du token pour protéger du CSRF
$hmac = hash_hmac('sha256', 'actionMessage', $_SESSION['Token']);
if (!isset($_POST['token']) || $hmac != $_POST['token']) {
    redirectError("Invalid token", VIEW);
}

// Vérification des entrées
if (isset($_POST[IN_TO]) && $_POST[IN_TO] != "" &&
    isset($_POST[IN_SUBJECT]) && $_POST[IN_SUBJECT] != "" &&
    isset($_POST[IN_MESSAGE]) && $_POST[IN_MESSAGE] != "") {

    // Appel de la classe de connexion
    require ('class/dbConnection.php');

    $dbConnection = new dbConnection();

    session_start();

    // Récupération des entrées
    $username = sanitizeInputText($_SESSION['Login']);
    date_default_timezone_set('Europe/Paris');
    $date = date('Y-m-d-H-i-s');
    $to = sanitizeInputText($_POST[IN_TO]);
    $subject = sanitizeInputText($_POST[IN_SUBJECT]);
    $message = sanitizeInputText($_POST[IN_MESSAGE]);

    // Traitement de l'envoi de message lorsque c'est une réponse à un autre message
    if (isset($_POST[IN_ID_MESSAGE]) && $_POST[IN_ID_MESSAGE] != "") {
        $idMessage = sanitizeInputInt($_POST[IN_ID_MESSAGE]);
        $msg = $dbConnection->getMessage($idMessage, $username);
        if($msg['id'] != "") {
            // On reprend les données de la BDD, dans le cas où l'utilisateur a modifié les champs
            $subject = "RE: " . $msg['subject'];
        } else {
            // Redirection vers la page précédente avec un message d'erreur
            redirectError("An error occured, please try again", VIEW_ERROR);
        }
    }

    $invalidUsername = $dbConnection->newMessage($username, $date, $to, $subject, $message);

    // Vérification que l'utilisateur existe et que ce ne soit pas le même que celui qui envoie
    if ($invalidUsername || $username == $to) {
        // Redirection vers la page précédente avec un message d'erreur
        redirectError("An error occured, please try again", VIEW_ERROR);
    }

    // Tout a bien fonctionné
    redirectSuccess("The message has been sent", VIEW_SUCCESS);
} else {
    // Redirection vers la page précédente avec un message d'erreur
    redirectError("An error occured in the form, please try again", VIEW_ERROR);
}
