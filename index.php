<?php session_start() ?>
<?php require_once 'includes/header.php'; ?>
<?php require_once 'autoloader.php'; ?>

<?php
$db = new DbConnect();
// Create an instance of the Player class
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
                <a href="game.php"><h3>Jouer</h3></a>
                <a href="profile.php"><h3>Profil</h3></a>
                <a href="global_scores.php"><h3>Score global</h3></a>
                <a href="logout.php"><h3>Déconnexion</h3></a>
            </div>    
        </div> <!--end row-->

        <?php } else { 
        // The user is not logged in, show the login/registration form ?>
        <h1>Bienvenue au Memory Game</h1>
        <div class="row">
            <div class="col">
                <a href="login.php">Connexion</a>
                <a href="register.php">Inscription</a>
            </div>
        </div> <!--end row-->
        <?php
        }
        ?>
    </section>
</main>

<?php
require_once 'includes/footer.php'
?>
