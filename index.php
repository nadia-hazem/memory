<main>
<?php
include 'includes/header.php';

echo '<div class="menu">';

echo '<div class="liensmenu">';
if (isset($_SESSION["login"])) {
    echo "<a class='btn' href='profil.php'><h1>Profil</h1></a>";
    echo "<a class='btn' href='choixdiff.php'><h1>New game</h1></a>
    <a class='btn' href='score.php'><h1>Scores</h1></a>";
    echo '<a class="btn" href="index.php?exit=true"><h1>Déconnexion</h1></a>';
} else {
    echo "<a class='btn  btn-primary' href='login.php'><h1>Connexion</h1></a>";
    echo "<a class='btn  btn-primary' href='register.php'><h1>S'inscrire</h1></a>";
    echo "<a class='btn  btn-primary' href='score.php'><h1>Scores</h1></a>";
}
if (isset($_GET["exit"])) {
    if ($_GET["exit"] == true) {
        session_destroy();
        header("location: index.php");
    }
}
?>

</div>
</div>
<?php
include 'includes/footer.php'
?>
</main>