<?php
    // Appel de la classe de connexion
    require ('class/dbConnection.php');

    $dbConnection = new dbConnection();

    $username = $_POST['userToEdit'];

    $user = $dbConnection->getUser($username);

    $usr = "";
    foreach ($user as $u){
        $usr = $u;
        break;
    }
?>

<!DOCTYPE html>
<html lang="fr">
<?php include_once('./include/header.inc.php'); ?>
<body>
<?php include_once('./include/navbar.inc.php'); ?>
<div class="container">
    <div class="jumbotron text-center">
        <h1>Edit user <?php echo $usr['username'] ?></h1>
    </div>
    <div class="row justify-content-lg-center">
        <div class="col-lg-6">
            <!-- Formulaire d'édition d'utilisateur' -->
            <form action="./editUserTreat.php" method="post">
                <div class="form-group">
                    <label for="inputPassword" class="col-lg-8">Password<span style="color: red">*</span></label>
                    <div class="col-lg-12">
                        <input type="password" class="form-control form-connexion-input" id="inputPassword" name="inputPassword" placeholder="Password" value="<?php echo $usr['password'] ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputValidity" class="col-lg-8">Validity<span style="color: red">*</span></label>
                    <div class="col-lg-12">
                        <select class="form-control" id="inputValidity" name="inputValidity">
                            <option <?php if($usr['validity'] == 1) { ?> selected <?php } ?> value="1">Yes</option>
                            <option <?php if($usr['validity'] == 0) { ?> selected <?php } ?> value="0">No</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputRole" class="col-lg-8">Role<span style="color: red">*</span></label>
                    <div class="col-lg-12">
                        <select class="form-control" id="inputRole" name="inputRole">
                            <option <?php if($usr['role'] == 0) { ?> selected <?php } ?> value="0">Standard</option>
                            <option <?php if($usr['role'] == 1) { ?> selected <?php } ?> value="1">Administrator</option>
                        </select>
                    </div>
                </div>

                <input type="hidden" id="inputUsername" name="inputUsername" value="<?php echo $usr['username'] ?>"/>

                <div class="form-group pull-right">
                    <div class="col-lg-8">
                        <button type="submit" class="btn btn-outline-primary">Edit user</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include_once('./include/footer.inc.php'); ?>
</body>
<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="./js/bootstrap.min.js"></script>
</html>