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
    <div class="wrapper">
        <main>  
            <div class="row justify-content-center">          
                <div class="col loginform">
                    <h1 class="font">Connexion</h1>        
                    <!-- Login form -->
                    <form class="col" method="post" action="login.php">
                        <div class="row justify-between">
                            <div class="col">
                                <label for="login">Login :</label>
                            </div>
                            <div class="col">
                                <input type="text" id="login" name="login">
                            </div>
                        </div> <!--end row-->

                        <div class="row justify-between">
                            <div class="col">
                                <label for="password">Mot de passe :</label>
                            </div>
                            <div class="col">
                                <input type="password" id="password" name="password">
                            </div>
                        </div> <!--end row-->

                        <div class="spaceone"></div>

                        <div class="row">
                            <div class="col">
                                <input type="submit" value="Connexion"  class="button success">
                            </div>
                        </div> <!--end row-->

                        
                        
                        <div class="row justify-content-center">
                            <p class="text-black">Vous etes nouveau ici ?&nbsp;<a href="login.php">Inscription</a></p>
                        </div>
                    </form> <!--end form-->
                </div> <!--end col-->
            </div> <!--end row-->
        </main>
        <div class="push"></div>
    </div> <!-- /wrapper -->