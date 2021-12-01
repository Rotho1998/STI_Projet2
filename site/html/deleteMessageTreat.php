<html>
<head></head>
<body>

<?php

// Appel de la classe de connexion
require ('class/dbConnection.php');

$dbConnection = new dbConnection();

// Récupération des identifiants entrés
$id = $_POST['idMessage'];

$dbConnection->deleteMessage($id);

header('Location:./index.php');

?>

</body>
</html>
