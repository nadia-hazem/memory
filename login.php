<?php session_start() ?>
<?php require_once 'includes/header.php'; ?>
<?php require_once 'autoloader.php'; ?>

<?php
$db = new DbConnect();

// Créer une instance de la classe Player
$player = new Player($db);

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
<div class="back">
    <a href="index.php"><img src="assets/img/btn-back.png"></a>
</div>

<main class="main">
    <section class="container">
        <h1>Connexion</h1>
        <!-- Login form -->
        <form method="post" action="login.php">
            <div class="row mb-3">
                <div class="col col-md-5">
                    <label for="login">Login :</label>
                </div>
                <div class="col col-md-7">
                    <input type="text" id="login" name="login">
                </div>
            </div> <!--end row-->

            <div class="row mb-3">
                <div class="col col-md-5">
                    <label for="password">Mot de passe :</label>
                </div>
                <div class="col col-md-7">
                    <input type="password" id="password" name="password">
                </div>
            </div> <!--end row-->
            <div class="row mb-3">
                <div class="col">
                    <input type="submit" value="Connexion">
                </div>
            </div> <!--end row-->

        </form>
        <br>
        <div class="row">
            Vous êtes nouveau ici ? &nbsp;<a href="register.php">S'inscrire</a>
        </div>
    </section>
</main>