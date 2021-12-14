<html>
<head></head>
<body>

<?php

// Appel de la classe de connexion
require ('class/dbConnection.php');

$dbConnection = new dbConnection();

// Récupération des identifiants entrés
$username = $_POST['inputUsername'];
$pwd = $_POST['inputPassword'];
$validity = $_POST['inputValidity'];
$role = $_POST['inputRole'];

// Ne pas modifier le mot de passe
if($pwd == ""){
    $dbConnection->editUserWithoutPassword($username, $validity, $role);
} else {
    $pwd = password_hash($pwd, PASSWORD_BCRYPT);
    $dbConnection->editUser($username, $pwd, $validity, $role);
}

header('Location:./users.php');

?>

</body>
</html>
