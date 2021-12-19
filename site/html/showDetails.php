<?php
    require('redirect.php');
    require('security.php');

    // Test si l'utilisateur est connecté
    if (!authentication()) {
        redirectError("You cannot access this ressource", "./index.php");
    }

    if(isset($_POST['idMessage']) && $_POST['idMessage'] != ""){
        // Appel de la classe de connexion
        require ('class/dbConnection.php');

        session_start();
        $dbConnection = new dbConnection();

        $message = $dbConnection->getMessage($_POST['idMessage'], $_SESSION['Login']);

        if($message['id'] == ""){
            redirectError("You don't have access to this message", "./index.php");
        }
    } else {
        redirectError("Something went wrong, please try again", "./index.php");
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
                        <input type="text" readonly class="form-control form-connexion-input" id="inputDate" name="inputDate" placeholder="To" value="<?php echo $message['date'] ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputFrom" class="col-lg-8">From</label>
                    <div class="col-lg-12">
                        <input type="text" readonly class="form-control form-connexion-input" id="inputFrom" name="inputFrom" placeholder="To" value="<?php echo $message['sender'] ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputSubject" class="col-lg-8">Subject</label>
                    <div class="col-lg-12">
                        <input type="text" readonly class="form-control form-connexion-input" id="inputSubject" name="inputSubject" placeholder="Subject" value="<?php echo sanitizeOutput($message['subject']) ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputMessage" class="col-lg-8">Content</label>
                    <div class="col-lg-12">
                        <textarea readonly class="form-control" id="inputMessage" name="inputMessage" rows="3"><?php echo sanitizeOutput($message['message']) ?></textarea>
                    </div>
                </div>

                <input type="hidden" id="idMessage" name="idMessage" value="<?php echo $message['id'] ?>"/>

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
