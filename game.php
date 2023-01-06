<?php include 'includes/header.php' ?>
<?php require 'lib/Player.php'; ?>
<?php require 'lib/Card.php'; ?>

<?php
    $user = new Player();
    if($user->isConnected() == false) {
        header("Location: login.php");
    }
?>

<main class="container">
    <a class="btn" href="profil.php"><h1>Profil</h1></a>
    <a class="btn" href="scores.php"><h1>Scores</h1></a>
    <a class="btn" href="index.php?exit=true"><h1>Déconnexion</h1></a>

    <div class="liensmenu">
        <h1>Game</h1>




    </div>
</main>

<?php include 'includes/footer.php' ?>