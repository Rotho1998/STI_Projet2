<?php
// Appel de la classe de connexion
require('class/dbConnection.php');

$dbConnection = new dbConnection();

$message = $dbConnection->getMessage($_POST['idMessage']);

$msg = "";
foreach ($message as $m){
    $msg = $m;
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
        <h1>New message</h1>
    </div>
    <div class="row justify-content-lg-center">
        <div class="col-lg-6">
            <!-- Formulaire d'affichage' -->
            <form action="./answerMessage.php" method="post">
                <div class="form-group">
                    <label for="inputDate" class="col-lg-8">Date</label>
                    <div class="col-lg-12">
                        <input type="text" readonly class="form-control form-connexion-input" id="inputDate" name="inputDate" placeholder="To" value="<?php echo $msg['date'] ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputFrom" class="col-lg-8">From</label>
                    <div class="col-lg-12">
                        <input type="text" readonly class="form-control form-connexion-input" id="inputFrom" name="inputFrom" placeholder="To" value="<?php echo $msg['from'] ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputSubject" class="col-lg-8">Subject</label>
                    <div class="col-lg-12">
                        <input type="text" readonly class="form-control form-connexion-input" id="inputSubject" name="inputSubject" placeholder="Subject" value="<?php echo $msg['subject'] ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputMessage" class="col-lg-8">Content</label>
                    <div class="col-lg-12">
                        <textarea readonly class="form-control" id="inputMessage" name="inputMessage" rows="3"><?php echo $msg['message'] ?></textarea>
                    </div>
                </div>

                <input type="hidden" id="idMessage" name="idMessage" value="<?php echo $msg['id'] ?>"/>

                <div class="form-group pull-right">
                    <div class="col-lg-8">
                        <button type="submit" class="btn btn-outline-primary">Answer</button>
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
