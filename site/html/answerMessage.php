<?php
    // Appel de la classe de connexion
    require('class/dbConnection.php');

    $dbConnection = new dbConnection();

    $message = $dbConnection->getMessage($_POST['idMessage']);
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
            <div class="alert alert-dismissible alert-danger" id="alert" style="<?php if(isset($_SESSION['error'])) { ?> display: block; <?php } else { ?> display: none; <?php } ?>">
                <a id="alertMessage"><?php if(isset($_SESSION['error'])) { echo $_SESSION['error']; unset($_SESSION['error']); } ?></a>
            </div>
            <!-- Formulaire de réponse -->
            <form action="./newMessageTreat.php" method="post">
                <div class="form-group">
                    <label for="inputTo" class="col-lg-8">To<span style="color: red">*</span></label>
                    <div class="col-lg-12">
                        <input type="text" readonly class="form-control form-connexion-input" id="inputTo" name="inputTo" placeholder="To" value="<?php echo $message['sender'] ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputSubject" class="col-lg-8">Subject<span style="color: red">*</span></label>
                    <div class="col-lg-12">
                        <input type="text" readonly class="form-control form-connexion-input" id="inputSubject" name="inputSubject" placeholder="Subject" value="RE: <?php echo $message['subject'] ?>">
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