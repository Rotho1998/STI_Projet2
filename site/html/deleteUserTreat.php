<html>
<head></head>
<body>

<?php

// Appel de la classe de connexion
require ('class/dbConnection.php');

$dbConnection = new dbConnection();

// Récupération des identifiants entrés
$username = $_POST['userToDelete'];

$dbConnection->deleteUser($username);

header('Location:./users.php');

?>

</body>
</html>
