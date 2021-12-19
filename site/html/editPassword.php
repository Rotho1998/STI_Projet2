<?php
    require ('redirect.php');
    require ('security.php');
    // Test si l'utilisateur est connecté
    if(!authentication()) {
        redirectError("You cannot access this ressource", "./index.php");
    }
?>
<!DOCTYPE html>
<html lang="fr">
<?php include_once('./include/header.inc.php'); ?>
<body>
<?php include_once('./include/navbar.inc.php'); ?>
<div class="container">
    <div class="jumbotron text-center">
        <h1>Edit password</h1>
    </div>
    <div class="row justify-content-lg-center">
        <div class="col-lg-6">
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
            <!-- Formulaire de modification de mot de passe -->
            <form action="./editPasswordTreat.php" method="post">
                <div class="form-group">
                    <label for="inputPassword" class="col-lg-8">New password<span style="color: red">*</span></label>
                    <div class="col-lg-12">
                        <input type="password" class="form-control form-connexion-input" id="inputPassword" name="inputPassword" placeholder="New password">
                    </div>
                    <small id="passwordHelpBlock" class="col-lg-12 form-text text-muted">
                        The password must be between 8 and 16 char long, should contain at least one uppercase char,
                        one lowercase char, one digit and one special char ($^+=!*()@%&.)
                    </small>
                </div>

                <div class="form-group">
                    <label for="inputPasswordRepeat" class="col-lg-8">Repeat new password<span style="color: red">*</span></label>
                    <div class="col-lg-12">
                        <input type="password" class="form-control form-connexion-input" id="inputPasswordRepeat" name="inputPasswordRepeat" placeholder="New password">
                    </div>
                </div>

                <input type="hidden" id="token" name="token" value="<?php echo hash_hmac('sha256', 'editPassword', $_SESSION['Token']) ?>"/>

                <div class="form-group pull-right">
                    <div class="col-lg-8">
                        <button type="submit" class="btn btn-outline-primary">Edit password</button>
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