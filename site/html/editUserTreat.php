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

$dbConnection->editUser($username, $pwd, $validity, $role);

header('Location:./users.php');

?>

</body>
</html>
