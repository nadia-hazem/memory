<?php
include 'includes/header.php';
require 'lib/Player.php';
?>

<?php
if(!empty($_POST)) {

    $user = new Player(); 
    $user->connect($_POST['login'], $_POST['password']);
}
?>
<main class="container">
    <a href="index.php">Retour</a>
        <h1>Connexion</h1>
            <form method="post">
                <label for="login">Login</label>
                <input type="text" name="login" id="login" required>
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
                <input type="submit" value="Connexion">                
            </form>
            <p>Vous n'avez pas de compte ? <a href="register.php">Inscrivez-vous</a></p>

</main>


<?php
include 'includes/footer.php';
?>