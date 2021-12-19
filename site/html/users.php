<?php


    require('redirect.php');
    require('security.php');

    // Test si l'utilisateur est admin
    if (!authentication(true)) {
        redirectError("You cannot access this ressource", "./index.php");
    }

    // Appel de la classe de connexion
    require ('class/dbConnection.php');

    $dbConnection = new dbConnection();

    $users = $dbConnection->getUsers();
?>

<!DOCTYPE html>
<html lang="fr">
<?php include_once('./include/header.inc.php'); ?>
<body>
<?php include_once('./include/navbar.inc.php'); ?>
<div class="container">
    <div class="jumbotron text-center">
        <h1>All users</h1>
    </div>
    <div class="row justify-content-md-center">
        <div class="col-lg-10">
            <?php if(isset($_SESSION['error'])) { ?>
                <div class="alert alert-dismissible alert-danger" id="alert">
                    <a id="alertMessage"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></a>
                </div>
            <?php }
            if(isset($_SESSION['success'])) { ?>
                <div class="alert alert-dismissible alert-success" id="alert">
                    <a id="alertMessage"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></a>
                </div>
            <?php } ?>
            <div class="form-group">
                <table class="table table-striped">
                    <tr>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Validity</th>
                        <th>Role</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                    <?php foreach($users as $u){ ?>
                        <tr>
                            <td><?php echo $u['username'] ?></td>
                            <td><?php echo $u['password'] ?></td>
                            <td><?php echo $u['validity'] ?></td>
                            <td><?php echo $u['role'] ?></td>
                            <td>
                                <form action="./editUser.php" method="post">
                                    <input type="hidden" id="userToEdit" name="userToEdit" value="<?php echo $u['username'] ?>"/>
                                    <button type="submit" class="btn btn-outline-primary btn-xs">Edit</button>
                                </form>
                            </td>
                            <td>
                                <form action="./deleteUserTreat.php" method="post">
                                    <input type="hidden" id="userToDelete" name="userToDelete" value="<?php echo $u['username'] ?>"/>
                                    <button type="submit" class="btn btn-outline-danger btn-xs">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include_once('./include/footer.inc.php'); ?>
</body>
<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="./js/bootstrap.min.js"></script>
</html>