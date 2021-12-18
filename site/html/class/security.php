<?php

// Définition des constantes
const REGEX_PASSWORD = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[#$^+=!*()@%&.])[A-Za-z\d#$^+=!*()@%&.]{8,16}$/';

function verifyPassword($password) {
    return preg_match(REGEX_PASSWORD, $password);
}


