<?php
include 'includes/header.php';
require 'lib/Player.php';
?>


<?php
$login = $_SESSION['login'];
$password = $_SESSION['password'];
$user = new Player(); 
$user->connect($login, $password);
$user->getLogin()
?>
<h3>Bienvenue <?php $login ?></h3>

<main class="container">
    <a href="index.php">Retour</a>
        <h1>Wall of fame</h1>

        <div class="liensmenu">
            <a class="btn" href="profil.php"><h1>Profil</h1></a>
            <a class="btn" href="game.php"><h1>Jouer</h1></a>
            <a class="btn" href="index.php?exit=true"><h1>Déconnexion</h1></a>
        </div>
</main>


<?php
include 'includes/footer.php';
?>