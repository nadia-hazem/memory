<?php session_start() ?>
<?php require_once 'includes/header.php'; ?>

<?php

// Créer une instance de la classe DbConnect
$db = new DbConnect();
// Créer une instance de la classe Player
$player = new Player($db);

// Check if the user is logged in
if ($player->isConnected()) {
    $login = $player->getLogin();

?>
<!--HTML-->
<body id="index">
    <main class="index  flex-fill d-flex align-items-center justify-content-center mx-auto h-100">
        <section class="d-flex align-items-center justify-content-center">
            <div class="col mx-auto align-self-strech mt-5 mb-3 h-50">
                <!-- Le joueur est connecté, afficher le menu approprié -->
                <!-- <h3 class="text-center mb-5">Bienvenue <?php //echo $login ?></h3> -->
                <!-- <a class="text-center" href="profile.php"><h3>Profil</h3></a>
                <a class="text-center" href="game.php"><h3>Jouer</h3></a>
                <a class="text-center" href="global_scores.php"><h3>Score global</h3></a> -->
            </div> 
        </div>

        <?php
        if(isset($_POST['level'])) {
            $level = $_POST['level'];
            header("Location: game.php?level=$level");
            exit;
            }  
        ?>
        <?php } else { 
        // The user is not logged in, show the login/registration links ?>
<body id="index">
    <main class="index  flex-fill d-flex align-items-center justify-content-center mx-auto h-100">
        <section class="d-flex align-items-center justify-content-center">
            <!-- <div class="col-md-6 mx-auto align-self-center mt-5">
                <h1 class="text-white">Simpson's Memory Game</h1>
                <a class="btn btn-info" href="login.php"><h3>Connexion</h3></a>
                <a class="btn btn-info" href="register.php"><h3>Inscription</h3></a>
            </div> -->

        <?php
        }
        ?>

    </main>

<?php
require_once 'includes/footer.php'
?>
