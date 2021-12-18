<?php

function redirectError($message, $location) {
    session_start();
    $_SESSION['error'] = $message;
    header('Location:' . $location);
    exit;
}

function redirectSuccess($message, $location) {
    session_start();
    $_SESSION['success'] = $message;
    header('Location:' . $location);
    exit;
}