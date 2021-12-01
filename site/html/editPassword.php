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
            <!-- Formulaire de modification de mot de passe -->
            <form action="./editPasswordTreat.php" method="post">
                <div class="form-group">
                    <label for="inputPassword" class="col-lg-8">New password<span style="color: red">*</span></label>
                    <div class="col-lg-12">
                        <input type="password" class="form-control form-connexion-input" id="inputPassword" name="inputPassword" placeholder="New password">
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputPasswordRepeat" class="col-lg-8">Repeat new password<span style="color: red">*</span></label>
                    <div class="col-lg-12">
                        <input type="password" class="form-control form-connexion-input" id="inputPasswordRepeat" name="inputPasswordRepeat" placeholder="New password">
                    </div>
                </div>

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