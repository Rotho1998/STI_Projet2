<?php
if(!isset($_SESSION['Login'])){
    session_start();
}
?>

<!-- Barre de navigation du site web qui sera incluse dans chaque page -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="col-lg-2"></div>
    <div class="col-lg-8">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation" style="">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbar">
            <ul class="navbar-nav mr-auto">
                <?php if(isset($_SESSION['Login'])){ ?>

                    <li class="nav-item">
                        <a class="nav-link" href="./index.php">Home</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="./newMessage.php">New message</a>
                    </li>
                    <?php if(isset($_SESSION['IsAdmin'])){ ?>
                        <li class="nav-item">
                            <a class="nav-link" href="./addUser.php">Add a user</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="./users.php">Users</a>
                        </li>
                    <?php } ?>
                <?php }
                else { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="./index.php">Login <i class="fas fa-sign-in-alt"></i></a>
                    </li>

                <?php } ?>
            </ul>
            <?php if(isset($_SESSION['Login'])){ ?>
                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        My profile
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownmenu">
                        <a href="./editPassword.php" class="dropdown-item" title="editPassword">Edit password</a>
                        <a href="./logoutTreat.php" class="dropdown-item" title="disconnection">Logout</a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</nav>
