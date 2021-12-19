<?php

// Définition des constantes
const REGEX_PASSWORD = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[#$^+=!*()@%&.])[A-Za-z\d#$^+=!*()@%&.]{8,16}$/';

/**
 * Méthode de vérification du mot de passe
 * @param $password -> mot de passe à vérifier
 * @return false|int -> si le mot de passe est valide
 */
function verifyPassword($password) {
    return preg_match(REGEX_PASSWORD, $password);
}

/**
 * Méthode de sanitizer pour des entrées de format texte
 * @param $input -> entrée au format texte
 * @return string -> résultat du sanitizer
 */
function sanitizeInputText($input) {
    return htmlentities($input, ENT_QUOTES, 'UTF-8');
}

/**
 * Méthode de sanitizer pour des entrées de format int
 * @param $input -> entrée au format int
 * @return mixed -> résultat du sanitizer
 */
function sanitizeInputInt($input) {
    return filter_var($input, FILTER_SANITIZE_NUMBER_INT);
}

/**
 * Méthode de sanitizer pour des entrées de format booléen
 * @param $input -> entrée au format booléen
 * @return int|null -> résultat du sanitizer
 */
function sanitizeInputBool($input) {
    return in_array($input, array(0, 1)) ? $input : 0;
}

/**
 * Méthode de sanitizer pour reformater le texte en UTF-8
 * @param $output -> texte à sanitizer
 * @return array|string|string[] -> résultat du sanitizer
 */
function sanitizeOutput($output) {
    $result = str_replace('<blockquote>', "[START]", $output);
    $result = str_replace('</blockquote>', "[END]", $result);
    $result = htmlspecialchars_decode($result, ENT_QUOTES);
    $result = str_replace("[START]", '<blockquote>', $result);
    return str_replace("[END]", '</blockquote>', $result);
}

/**
 * Méthode de vérification de l'accès aux pages
 * @param false $admin -> si on veut tester un accès administrateur
 * @return bool -> résultat du test d'accès
 */
function authentication($admin = false) {
    session_start();
    if(isset($_SESSION['Login'])){
        if($admin && $_SESSION['Role'] == 1){
            return true;
        } elseif ($admin && $_SESSION['Role'] == 0) {
            return false;
        }
        return true;
    }
    return false;
}