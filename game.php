<?php
session_start();
require_once 'includes/header.php';
// Open session
if (!$player->isConnected()) {
    // Le joueur n'est pas connecté, rediriger vers la page de connexion
    header('Location: login.php');
    exit();
} ?>

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

    // enlever variable post
    $_POST['level'] = null;
    unset($_POST['level']);
}
if(isset($_SESSION['level'])){
    // Créer les cartes
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
<!-- A fficher le tableau -->
<body id="game">
    <div class="wrapper">
        <!-- Afficher le tableau -->
        <main class="game align-content-center justify-content-center">

            <section class="board">
                <?php if (!isset($_SESSION['new']))
                { ?>
                    <div class="level">
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
                            <input type="submit" value="Jouer" class="button success">
                        </form>
                    </div>
                    <?php      
                }

                if(isset($_SESSION['new'])) { 
                    /* var_dump($_SESSION['level']) */ ?>
                    <div>
                        <!--les class affichent les cartes en grille-->
                        <form action="verif.php" method="post" class="cards_form row wrap justify-content-center">
                            <?php
                            foreach ($cards as $card) { ?>
                                <div class="">
                                    <?php
                                    $card->displayCard();
                                    ?>
                                    
                                </div>
                            <?php
                            }
                            ?>
                        </form>
                    </div>
                    <div class="text-center">
                        <a class="button danger text-white align-center" href='game.php?reset=true'>Reset</a>
                    </div>

                <?php } 
                if(isset($_SESSION['level']) && $game -> checkEnd()) 
                { // Vérifier si la partie est terminée
                    unset($_SESSION['new']);
                
                    ?>
                    <div class="victory text-center justify-content-center align-content-center">
                        <h2 class="text-center pt-5">Bravo, la partie est terminee !</h2>
                        <?php
                        $score = $_SESSION['level'] / $_SESSION['coup'];
                        $player->saveScore($_SESSION['level'], $_SESSION['coup'])
                        ?>
                        <br>
                        <h3 class="text-center arial">Votre score est de <?= $score; ?></h3>
                        <h3 class="text-center arial">En&nbsp; <?= $_SESSION['coup']; ?> coups</h3>
                        <a class="button danger text-white" href='game.php?reset=true'>Reset</a>
                        <?php 
                }       ?>
                    </div>
                    
            </section>
        </main>
        <div class="push"></div>
    </div> <!-- wrapper -->
<?php
    require_once 'includes/footer.php'; ?>