<html>
<head></head>
<body>

<?php

// Récupération des identifiants entrés
$pwd = $_POST['inputPassword'];
$pwdRepeat = $_POST['inputPasswordRepeat'];

session_start();

if($pwd == $pwdRepeat){
    // Appel de la classe de connexion
    require ('class/dbConnection.php');

    $dbConnection = new dbConnection();

    $dbConnection->editPassword($_SESSION['Login'], $pwd);

    header('Location:./index.php');
} else {
    header('Location:./editPassword.php');
}

?>

</body>
</html>
