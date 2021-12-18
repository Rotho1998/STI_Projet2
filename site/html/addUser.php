<!DOCTYPE html>
<html lang="fr">
<?php include_once('./include/header.inc.php'); ?>
<body>
<?php include_once('./include/navbar.inc.php'); ?>
<div class="container">
    <div class="jumbotron text-center">
        <h1>Add a new user</h1>
    </div>
    <div class="row justify-content-lg-center">
        <div class="col-lg-6">
            <div class="alert alert-dismissible alert-danger" id="alert" style="<?php if(isset($_SESSION['error'])) { ?> display: block; <?php } else { ?> display: none; <?php } ?>">
                <a id="alertMessage"><?php if(isset($_SESSION['error'])) { echo $_SESSION['error']; unset($_SESSION['error']); } ?></a>
            </div>
            <div class="alert alert-dismissible alert-success" id="alert" style="<?php if(isset($_SESSION['success'])) { ?> display: block; <?php } else { ?> display: none; <?php } ?>">
                <a id="alertMessage"><?php if(isset($_SESSION['success'])) { echo $_SESSION['success']; unset($_SESSION['success']); } ?></a>
            </div>
            <!-- Formulaire d'ajout d'utilisateur' -->
            <form action="./addUserTreat.php" method="post">
                <div class="form-group">
                    <label for="inputUsername" class="col-lg-8">Username<span style="color: red">*</span></label>
                    <div class="col-lg-12">
                        <input type="text" class="form-control form-connexion-input" id="inputUsername" name="inputUsername" placeholder="Username">
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputPassword" class="col-lg-8">Password<span style="color: red">*</span></label>
                    <div class="col-lg-12">
                        <input type="password" class="form-control form-connexion-input" id="inputPassword" name="inputPassword" placeholder="Password">
                    </div>
                    <small id="passwordHelpBlock" class="col-lg-12 form-text text-muted">
                        The password must be between 8 and 16 char long, should contain at least one uppercase char,
                        one lowercase char, one digit and one special char ($^+=!*()@%&.)
                    </small>
                </div>

                <div class="form-group">
                    <label for="inputValidity" class="col-lg-8">Validity<span style="color: red">*</span></label>
                    <div class="col-lg-12">
                        <select class="form-control" id="inputValidity" name="inputValidity">
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputRole" class="col-lg-8">Role<span style="color: red">*</span></label>
                    <div class="col-lg-12">
                        <select class="form-control" id="inputRole" name="inputRole">
                            <option value="0">Standard</option>
                            <option value="1">Administrator</option>
                        </select>
                    </div>
                </div>

                <div class="form-group pull-right">
                    <div class="col-lg-8">
                        <button type="submit" class="btn btn-outline-primary">Add user</button>
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