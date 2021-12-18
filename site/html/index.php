<!DOCTYPE html>
<html lang="fr">
<?php include_once('./include/header.inc.php'); ?>
<body>
<?php include_once('./include/navbar.inc.php'); ?>
<div class="container">
    <!-- Test si la variable $_SESSION['Login'] n'existe pas pour afficher le formulaire de connexion -->
    <?php if (!isset($_SESSION['Login'])) { ?>
        <div class="jumbotron text-center">
            <h1>Connect to the platform</h1>
        </div>
        <div class="row justify-content-lg-center">
            <div class="col-lg-6">
                <!-- Formulaire de connexion -->
                <form action="./loginTreat.php" method="post">
                    <div class="form-group">
                        <label for="inputLogin" class="col-lg-8">Username</label>
                        <div class="col-lg-12">
                            <input type="text" class="form-control form-connexion-input" id="inputLogin" name="inputLogin" placeholder="Username">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputPassword" class="col-lg-8">Password</label>
                        <div class="col-lg-12">
                            <input type="password" class="form-control form-connexion-input" id="inputPassword" name="inputPassword" placeholder="Password">
                        </div>
                    </div>

                    <div class="form-group pull-right">
                        <div class="col-lg-8">
                            <button type="submit" class="btn btn-outline-primary">Login</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    <!-- Si un utilisateur est connecté, affiche sa boîte mail -->
    <?php } else {

        // Appel de la classe de connexion
        require('class/dbConnection.php');

        $dbConnection = new dbConnection();

        $messages = $dbConnection->getMessages(); ?>
        <div class="jumbotron text-center">
            <h1>Mailbox</h1>
        </div>
        <div class="row justify-content-md-center">
            <div class="col-lg-10">
                <div class="alert alert-dismissible alert-danger" id="alert" style="<?php if(isset($_SESSION['error'])) { ?> display: block; <?php } else { ?> display: none; <?php } ?>">
                    <a id="alertMessage"><?php if(isset($_SESSION['error'])) { echo $_SESSION['error']; unset($_SESSION['error']); } ?></a>
                </div>
                <div class="alert alert-dismissible alert-success" id="alert" style="<?php if(isset($_SESSION['success'])) { ?> display: block; <?php } else { ?> display: none; <?php } ?>">
                    <a id="alertMessage"><?php if(isset($_SESSION['success'])) { echo $_SESSION['success']; unset($_SESSION['success']); } ?></a>
                </div>
                <div class="form-group">
                    <table class="table table-striped">
                        <tr>
                            <th>Date</th>
                            <th>From</th>
                            <th>Subject</th>
                            <th>Details</th>
                            <th>Answer</th>
                            <th>Delete</th>
                        </tr>
                        <?php foreach($messages as $m){
                            if($m['receiver'] == $_SESSION['Login']) {?>
                            <tr>
                                <td><?php echo $m['date'] ?></td>
                                <td><?php echo $m['sender'] ?></td>
                                <td><?php echo $m['subject'] ?></td>
                                <td>
                                    <form action="./showDetails.php" method="post">
                                        <input type="hidden" id="idMessage" name="idMessage" value="<?php echo $m['id'] ?>"/>
                                        <button type="submit" class="btn btn-outline-primary btn-xs">Details</button>
                                    </form>
                                </td>
                                <td>
                                    <form action="./answerMessage.php" method="post">
                                        <input type="hidden" id="idMessage" name="idMessage" value="<?php echo $m['id'] ?>"/>
                                        <button type="submit" class="btn btn-outline-primary btn-xs">Answer</button>
                                    </form>
                                </td>
                                <td>
                                    <form action="./deleteMessageTreat.php" method="post">
                                        <input type="hidden" id="idMessage" name="idMessage" value="<?php echo $m['id'] ?>"/>
                                        <button type="submit" class="btn btn-outline-danger btn-xs">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php } } ?>
                    </table>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
<?php include_once('./include/footer.inc.php'); ?>
</body>
<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="./js/bootstrap.min.js"></script>
</html>
