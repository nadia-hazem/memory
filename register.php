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
        // Le formulaire est valide, enregistrer le joueur
        $error = $player->register($login, $password);
        header ("Refresh:1; url=Location: login.php");
    }
}
?>
<body id="register">
    <div class="wrapper">
        <main>  
            <div class="row justify-content-center">          
                <div class="col loginform">
                    <h1 class="font">Inscription</h1>        
                    <!-- Register form -->
                    <form class="col" method="post" action="register.php">
                        <div class="row justify-between">
                            <div class="col">   
                                <label for="login">Login</label>
                            </div>
                            <div class="col">
                                <input type="text" id="login" name="login">
                            </div>
                        </div> <!--/row-->

                        <div class="row justify-between">
                            <div class="col">
                                <label for="password">Mot de passe</label>
                            </div>
                            <div class="col">
                                <input type="password" id="password" name="password">
                            </div>
                        </div> <!--/row-->

                        <div class="row justify-between">
                            <div class="col">
                                <label for="password2">Confirmez<br>le mot de passe:</label>
                            </div>
                            <div class="col">
                                <input type="password" id="password2" name="password2">
                            </div>
                        </div> <!--/row-->

                        <div class="spaceone"></div>

                        <div class="row">
                            <input type="submit" value="Inscription" class="button success">
                        </div> <!--/row-->
                        <br>
                        <div class="row justify-content-center">
                            <p class="text-black">Deja inscrit ?&nbsp;<a href="login.php">Connexion</a></p>
                        </div> <!--/row-->

                    </form>
                    <br>
                </div> <!--/col loginform-->
            </div> <!--/row-->
            
        </main>
        <div class="push"></div>
    </div> <!--/wrapper-->

    <?php require_once 'includes/footer.php'; ?>
<?php
if (isset($error)) {
    echo $error;
}
?>
