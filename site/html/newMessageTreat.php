<?php

require ('redirect.php');

// Définition du nom des inputs reçues
const IN_TO = 'inputTo';
const IN_SUBJECT = 'inputSubject';
const IN_MESSAGE = 'inputMessage';

const VIEW_ERROR = './newMessage.php';
const VIEW_SUCCESS = './index.php';

if (isset($_POST[IN_TO]) && $_POST[IN_TO] != "" &&
    isset($_POST[IN_SUBJECT]) && $_POST[IN_SUBJECT] != "" &&
    isset($_POST[IN_MESSAGE]) && $_POST[IN_MESSAGE] != "") {

    // Appel de la classe de connexion
    require ('class/dbConnection.php');

    $dbConnection = new dbConnection();

    session_start();

    // Récupération des entrées
    $username = $_SESSION['Login'];
    date_default_timezone_set('Europe/Paris');
    $date = date('Y-m-d-H-i-s');
    $to = $_POST[IN_TO];
    $subject = $_POST[IN_SUBJECT];
    $message = $_POST[IN_MESSAGE];

    $invalidUsername = $dbConnection->newMessage($username, $date, $to, $subject, $message);

    // Vérification que l'utilisateur existe et que ce ne soit pas le même que celui qui envoie
    if ($invalidUsername || $username == $to) {
        // Redirection vers la page précédente avec un message d'erreur
        redirectError("An error occured in the form, please try again", VIEW_ERROR);
    }

    // Tout a bien fonctionné
    redirectSuccess("The message has been sent", VIEW_SUCCESS);
} else {
    // Redirection vers la page précédente avec un message d'erreur
    redirectError("An error occured in the form, please try again", VIEW_ERROR);
}
