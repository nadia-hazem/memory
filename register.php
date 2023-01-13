<?php session_start() ?>
<?php require_once 'includes/header.php'; ?>

<?php
// Créer une instance de la classe DbConnect
$db = new DbConnect();
// Créer une instance de la classe Player
$player = new Player($db);

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $login = trim(htmlspecialchars($_POST['login']));
    $password = trim(htmlspecialchars($_POST['password']));
    $password2 = trim(htmlspecialchars($_POST['password2']));

    // Validate the form data
    if (empty($login)) {
        $error = "Veuillez saisir un login.";
    }
    elseif (empty($password)) {
        $error = "Veuillez saisir un mot de passe.";
    }
    elseif (empty($password2)) {
        $error = "Veuillez confirmer le mot de passe.";
    }
    elseif ($password !== $password2) {
        $error = "Les mots de passe ne correspondent pas.";
    }
    else {
        // The form data is valid, continue with registration
        $error = $player->register($login, $password);
        header ("Refresh:1; url=Location: login.php");
    }
}
?>
<body id="register">
    <a class="btn-back" href="index.php"><img src="assets/img/btn-back.png"></a>
        <main class="flex-fill d-flex align-items-center justify-content-end mt-5 mr-5">  
            <section class="d-flex align-items-center">
                <div class="loginform col mx-auto float-right">
                    <h1>S'inscrire</h1>        
                    <!-- Register form -->
                    <form class="form_global" method="post" action="register.php">
                        <div class="row mb-3">
                            <div class="col md-6">
                                <label for="login">Login:</label>
                            </div>
                            <div class="col md-6">
                                <input type="text" id="login" name="login">
                            </div>
                        </div> <!--end row-->
                        <div class="row mb-3">
                            <div class="col col-md-6">
                                <label for="password">login:</label>
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
                                <input type="submit" value="S'inscrire" class="btn btn-success">
                            </div>
                        </div> <!--end row-->
                    </form>
                    <br>

                    <div class="d-inline-flex justify-content-center">
                    Vous êtes nouveau ici ?&nbsp;
                    <a href="register.php" class="inline-block">Inscription</a>
                </div>
                </div>
            </section>
        </main>

<?php
if (isset($error)) {
    echo $error;
}
?>
