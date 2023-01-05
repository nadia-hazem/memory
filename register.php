<?php
include 'includes/header.php';
require 'lib/Player.php';

?>

<main>
    <a href="index.php">Retour</a>
    <div class="menu">

            <h1>Inscription</h1>

            <form method="post">
                Login : <input type="text" name="login">
                <br />
                Mot de passe : <input type="password" name="password">
                <br />
                Confirmez le mot de passe : <input type="password" name="password2">
                <input type="submit" value="Inscription">
            </form>


    </div>

</main>

<?php 
$user = new Player(); 
$user->register($_POST['login'], $_POST['password'], $_POST['password2']);
?>

<?php include 'includes/footer.php'; ?>