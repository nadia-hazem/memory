<?php
session_start();
require_once 'includes/header.php';
// Open session
if (!$player->isConnected()) {
    // Le joueur n'est pas connecté, rediriger vers la page de connexion
    header('Location: login.php');
    exit();
} ?>

<!-- <div class="player-name">
    <?php echo $player->getLogin() . " est connecté"; ?>
</div> -->

<?php
// Vérifier si le niveau a été sélectionné
if (isset($_POST['level'])) {
    // Le niveau a été sélectionné, créer une session
    $game->reset();
    $_SESSION['level'] = $_POST['level'];
    $_SESSION['new'] = true;

    // Créer une instance de la classe Game
    $game->getCards();
    /* var_dump($_SESSION['board']); */
    // créer les cartes
    // enlever variable post
    $_POST['level'] = null;
    unset($_POST['level']);
}
if(isset($_SESSION['level'])){
    for ($i = 0; $i < ((int)$_SESSION['level']*2); $i++) {
        $card= new Card($i);
        $cards[] = $card;
    }
}

// Vérifier le match
if (isset($_SESSION['flip2'])){
    // appel de la fonction checkMatch
    $game->checkMatch();
}
// Enlever la variable post
$_POST['card'] = null;
unset($_POST['card']);
?>
<!-- Display the game level and score -->
<body id="game">
    <a class="btn-back" href="index.php"><img src="assets/img/btn-back.png"></a>
    <!-- Afficher le tableau -->
    <main class="game d-flex flex-fill align-items-center justify-content-center mx-auto h-100">

        <section class="board m-auto">
            <?php if (!isset($_SESSION['new']))
            { ?>
                <div class="level h-60">
                    <form method="post" action="">
                        <select name="level">
                            <option value="3">3 paires</option>
                            <option value="4">4 paires</option>
                            <option value="5">5 paires</option>
                            <option value="6">6 paires</option>
                            <option value="7">7 paires</option>
                            <option value="8">8 paires</option>
                            <option value="9">9 paires</option>
                            <option value="10">10 paires</option>
                            <option value="11">11 paires</option>
                            <option value="12">12 paires</option>
                        </select>
                        <input type="submit" value="Jouer" class="btn btn-danger m-2">
                    </form>
                </div>
                <?php      
            }

            if(isset($_SESSION['new'])) { 
                /* var_dump($_SESSION['level']) */ ?>
                <div class="">
                    <form action="verif.php" method="post" class="cards_form flex-wrap justify-content-center align-content-center">
                    <?php
                    foreach ($cards as $card) { ?>
                        <div class=" ">
                            <?php
                            $card->displayCard();
                            ?>
                        </div>
                    <?php
                    }
                    ?>
                    </form>
                </div>

            <?php } 
            if(isset($_SESSION['level']) && $game -> checkEnd()) {
                unset($_SESSION['new']);
            
                ?>
                <div class="text-center mb-5 mx-auto">
                    <h2 class="text-center">Bravo, vous avez gagné !</h2>
                <?php
                $score = $_SESSION['level'] / $_SESSION['coup'];
                $player->saveScore($_SESSION['level'], $_SESSION['coup'])
                ?>
                <br>
                <h3 class="text-center">Votre score est de <?= $score; ?></h3>
                <h4 class="text-center">Vous avez fait <?= $_SESSION['coup']; ?> coups</h4>
                <br>
            <?php } ?>
                </div>
                <div class="text-center mb-5 mx-auto">
                    <a class="btn btn-info align-center" href='game.php?reset=true'>Relancer</a>
                <br><br>
                </div>
        </section>
    </main>
<?php
    require_once 'includes/footer.php'; ?>