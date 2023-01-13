<?php session_start() ?>
<?php require_once 'includes/header.php'; ?>

<?php
if ($player->isConnected()) {
    // Le joueur n'est pas connecté, rediriger vers la page de connexion
    header('Location: index.php');
    exit();
}
/* $db = new DbConnect();

// Créer une instance de la classe Player
$player = new Player($db); */

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    // Récupérer les données du formulaire
    $login = trim(htmlspecialchars($_POST['login']));
    $password = trim(htmlspecialchars($_POST['password']));

    // Faire appel à la méthode connect()
    $player->connect($login, $password);
}

?>
<body id="login">
    <a class="btn-back" href="index.php"><img src="assets/img/btn-back.png"></a>
    <main class="flex-fill d-flex align-items-center justify-content-end mt-5 mr-5">  
        <section class="d-flex align-items-center ">
            <div class=" loginform col mx-auto float-right ">
                <h1>Connexion</h1>
                <!-- Login form -->
                <form class="form_global" method="post" action="login.php">
                    <div class="row mb-3">
                        <div class="col col-md-6">
                            <label for="login">Login :</label>
                        </div>
                        <div class="col md-6">
                            <input type="text" id="login" name="login">
                        </div>
                    </div> <!--end row-->

                    <div class="row mb-3">
                        <div class="col md-6">
                            <label for="password">Mot de passe :</label>
                        </div>
                        <div class="col md-6">
                            <input type="password" id="password" name="password">
                        </div>
                    </div> <!--end row-->
                    <br>
                    <div class="row mb-3">
                        <div class="col">
                            <input type="submit" value="Connexion" class="btn btn-success">
                        </div>
                    </div> <!--end row-->

                </form> <!--end form-->
                <br>
                <div class="d-inline-flex justify-content-center">
                    Vous êtes nouveau ici ?&nbsp;
                    <a href="register.php" class="inline-block">Inscription</a>
                </div>
            </div>
        </section>
    </main>