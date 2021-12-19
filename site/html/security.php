<?php

// Définition des constantes
const REGEX_PASSWORD = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[#$^+=!*()@%&.])[A-Za-z\d#$^+=!*()@%&.]{8,16}$/';

function verifyPassword($password) {
    return preg_match(REGEX_PASSWORD, $password);
}

function sanitizeInputText($input) {
    return htmlentities($input, ENT_QUOTES, 'UTF-8');
}

function sanitizeInputInt($input) {
    return filter_var($input, FILTER_SANITIZE_NUMBER_INT);
}

function sanitizeInputRoleAndValidity($input) {
    return in_array($input, array(0, 1)) ? $input : 0;
}

function sanitizeOutput($output) {
    $result = str_replace('<blockquote>', "[START]", $output);
    $result = str_replace('</blockquote>', "[END]", $result);
    $result = htmlspecialchars_decode($result, ENT_QUOTES);
    $result = str_replace("[START]", '<blockquote>', $result);
    return str_replace("[END]", '</blockquote>', $result);
}