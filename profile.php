<?php session_start() ?>
<?php require_once 'includes/header.php'; ?>
<?php require_once 'autoloader.php'; ?>
<?php
// Create an instance of the DbConnect class
$db = new DbConnect();

// Create an instance of the Player class, passing the database connection as an argument
$player = new Player($db);

// Check if the user is logged in
if ($player->isConnected()) {
    // Create an instance of the Score class, passing the database connection as an argument
    $score = new Score($db);
    
    // Get the player's score
    $playerScore = $score->getPlayerScore($player->id);
    if (!empty($playerScore)) {
        ?>
        <main class="main">
            <section class="container">
                <h1>Profil</h1>
                <div class="row mb-3">
                    <div class="col mb-3">
                        <h3 class="text-center">Bienvenue <?php echo $_SESSION['user']['login']; ?></h3>
                        <a href="game.php"><h3>Jouer</h3></a>
                        <a href="global_scores.php"><h3>Score global</h3></a>
                        <a href="logout.php"><h3>Déconnexion</h3></a>
                        <a href="delete_account.php"><h3>Supprimer mon compte</h3></a>
                    </div>
                <div class="row mb-3">
                    <div class="col mb-3">
                        
                        Votre score : <?php $playerScore[0]['score']; ?>
                    </div>
                    
<?php
    } else {
?>
                    <div class="col mb-3">
                        <h3 class="text-center p-5">Vous n'avez pas encore de score</h3>
                    </div>
<?php
    } 
?>
                </div> <!--end row-->
<?php
} 
else 
{
?>
                <div class="row mb-3">
                    <div class="col mb-3">
<?php
    // User is not logged in, redirect to the login page
    header('Location: login.php');
}
?>
                    </div>
                </div> <!--end row-->
            </section>
        </main>
