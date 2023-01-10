<?php session_start() ?>
<?php require_once 'includes/header.php'; ?>

<?php
// Créer une instance de la classe DbConnect
$db = new DbConnect();
// Créer une instance de la classe Player
$player = new Player($db);

// Check if the user is logged in
if ($player->isConnected()) {
?>
<!--HTML-->
<main class="main">
    <section class="container">
        <h1>Memory Game</h1>
        <div class="row mb-3">
            <div class="col mb-3">
                <!-- Le joueur est connecté, afficher le menu approprié -->
                <h3 class="text-center">Bienvenue <?php echo $_SESSION['user']['login']; ?></h3>
                <a href="profile.php"><h3>Profil</h3></a>
                <a href="game.php"><h3>Jouer</h3></a>
                <a href="global_scores.php"><h3>Score global</h3></a>
            </div> 
        </div> <!--end row-->
<?php
    if(isset($_POST['level'])) {
        $level = $_POST['level'];
        header("Location: game.php?level=$level");
        exit;
        }  
?>
        <?php } else { 
        // The user is not logged in, show the login/registration links ?>
        <h1>Memory Game</h1>
            <div class="col text-center">
                <a class="" href="login.php"><h3>Connexion</h3></a>
                <a class="" href="register.php"><h3>Inscription</h3></a>
            </div>

        <?php
        }
        ?>
    </section>
</main>

<?php
require_once 'includes/footer.php'
?>
