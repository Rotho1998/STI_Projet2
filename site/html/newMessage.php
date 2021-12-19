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
        <h1>New message</h1>
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
            <!-- Formulaire de nouveau message -->
            <form action="./newMessageTreat.php" method="post">

                <?php
                // Appel de la classe de connexion
                require ('class/dbConnection.php');

                $dbConnection = new dbConnection();

                $users = $dbConnection->getUsernames($_SESSION['Login']);
                ?>

                <div class="form-group">
                    <label for="inputTo" class="col-lg-8">To<span style="color: red">*</span></label>
                    <div class="col-lg-12">
                        <select class="form-control" id="inputTo" name="inputTo">
                            <?php foreach($users as $u) { ?>
                                <option><?php echo $u['username'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="inputSubject" class="col-lg-8">Subject<span style="color: red">*</span></label>
                    <div class="col-lg-12">
                        <input type="text" class="form-control form-connexion-input" id="inputSubject" name="inputSubject" placeholder="Subject">
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputMessage" class="col-lg-8">Content<span style="color: red">*</span></label>
                    <div class="col-lg-12">
                        <textarea class="form-control" id="inputMessage" name="inputMessage" rows="3"></textarea>
                    </div>
                </div>

                <div class="form-group pull-right">
                    <div class="col-lg-8">
                        <button type="submit" class="btn btn-outline-primary">Send</button>
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