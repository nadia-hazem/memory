<?php session_start() ?>
<?php require_once 'includes/header.php'; ?>
<?php require_once 'autoloader.php'; ?>

<?php
$db = new DbConnect();
// Create an instance of the Player class
$player = new Player($db);

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $login = trim(htmlspecialchars($_POST['login']));
    $password = trim(htmlspecialchars($_POST['password']));
    $password2 = trim(htmlspecialchars($_POST['password2']));

    // Validate the form data
    if (empty($login)) {
        $error = "Please enter a login.";
    }
    elseif (empty($password)) {
        $error = "Please enter a password.";
    }
    elseif (empty($password2)) {
        $error = "Please confirm your password.";
    }
    elseif ($password !== $password2) {
        $error = "Passwords do not match!";
    }
    else {
        // The form data is valid, continue with registration
        $error = $player->register($login, $password);
    }
}
?>
<div class="back">
    <a href="index.php"><img src="assets/img/btn-back.png"></a>
</div>
<main class="main">
    <section class="container">

        <h1>S'inscrire</h1>        
        <!-- Register form -->
        <form method="post" action="register.php">
            <div class="row mb-3">
                <div class="col col-md-6">
                    <label for="login">Login:</label>
                </div>
                <div class="col col-md-6">
                    <input type="text" id="login" name="login">
                </div>
            </div> <!--end row-->
            <div class="row mb-3">
                <div class="col col-md-6">
                    <label for="password">Mot de passe:</label>
                </div>
                <div class="col col-md-6">
                    <input type="password" id="password" name="password">
                </div>
            </div> <!--end row-->
            <div class="row mb-3">
                <div class="col col-md-6">
                    <label for="password2">Confirmer le mot de passe:</label>
                </div>
                <div class="col col-md-6">
                    <input type="password" id="password2" name="password2">
                </div>
            </div> <!--end row-->
            <br>
            <div class="row">
                <div class="col col-12">
                    <input type="submit" value="S'inscrire">
                </div>
            </div> <!--end row-->
        </form>
        <br>
        <div class="row">
            Vous êtes déjà inscrit ? &nbsp;<a href="login.php">Se connecter</a>
        </div> <!--end row-->
    </section>
</main>

<?php
if (isset($error)) {
    echo $error;
}
?>
