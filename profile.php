<?php session_start() ?>
<?php require_once 'includes/header.php'; ?>

<?php
// Créer une instance de la classe DbConnect
$db = new DbConnect();
// Créer une instance de la classe Player
$player = new Player($db);

// Vérifier si le joueur est connecté
if ($player->isConnected()) {
    // Créer une instance de la classe Score
    $score = new Score($db);
    
    // Récupérer les données du joueur
    $playerScore = $score->getPlayerScore($player->id);
    if (!empty($playerScore)) {
        ?>
        <main class="main">
        <a href="index.php"><img src="assets/img/btn-back.png"></a>
            <section class="container">
                <h1>Profil</h1>
                <div class="row mb-3">
                    <div class="col mb-3">
                        <h3 class="text-center">Bienvenue <?php echo $_SESSION['user']['login']; ?></h3>
                        <a href="game.php"><h3>Jouer</h3></a>
                        <a href="global_scores.php"><h3>Score global</h3></a>
                    </div>
                <div class="row mb-3">
                    <div class="col mb-3">
                        
                        Votre score : <?php $playerScore[0]['score']; ?>
                    </div>
                </div> <!--end row--> 
            </section>
<?php
    } 
    else 
    {
?>          
            <a href="index.php"><img src="assets/img/btn-back.png"></a>
            <section class="container">        
                <div class="row mb-3">
                    <div class="col mb-3">
                        <h3 class="text-center">Bienvenue <?php echo $_SESSION['user']['login']; ?></h3>
                        <?php //var_dump($_SESSION['login']); ?>
                        <a href="game.php"><h3>Jouer</h3></a>
                        <a href="global_score.php"><h3>Score global</h3></a>
                        </form>                    
                    </div>
                <div class="row mb-3">
                    <div class="col mb-3">
                        <h3 class="text-center p-5">Vous n'avez pas encore de score</h3>
                    </div>
                </div> <!--end row-->
            </section>
<?php
    } 
} 
else 
{
?>
                <div class="row mb-3">
                    <div class="col mb-3">
<?php
    // L'utilisateur n'est pas connecté, afficher le formulaire de connexion/inscription
    header('Location: login.php');
}
?>
                    </div>
                </div> <!--end row-->
            </section>
        </main>
