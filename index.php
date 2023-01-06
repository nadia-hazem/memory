<?php include "includes/header.php"; 
require 'lib/Player.php';
?>

<main class="container">
    <div class="liensmenu">

<?php
$user= new Player();
if ($user->isConnected()) {
    echo "<a class='btn' href='profil.php'><h1>Profil</h1></a>";
    echo "<a class='btn' href='game.php'><h1>Jouer</h1></a>
    <a class='btn' href='score.php'><h1>Scores</h1></a>";
    echo '<a class="btn" href="index.php?exit=true"><h1>Déconnexion</h1></a>';
} else {
    echo "<a class='btn  btn-primary' href='login.php'><h1>Connexion</h1></a>";
    echo "<a class='btn  btn-primary' href='score.php'><h1>Scores</h1></a>";
}
if (isset($_GET["exit"])) {
    $user->disconnect();
    header("Refresh: 1;url=index.php");
}
?>
    </div>
</main>

<?php
include 'includes/footer.php'
?>
