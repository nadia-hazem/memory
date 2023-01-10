<?php
require_once 'includes/header.php';

// Open session
session_start();
$_SESSION['login'] = $login;
if(!isset($_SESSION['login'])){
    //The login session is not set. redirect to login page.
    header('Location: login.php');
    exit();
}

$db = new DbConnect();
$player = new Player($db);
$game = new Game($player, $db);
$stmt = $db->getPdo()->prepare("SELECT level FROM player_score WHERE login = ?");
$stmt->execute([$_SESSION['login']]);
if(!$level = $stmt->fetch(PDO::FETCH_ASSOC)['level']){
    //The level is not set for the current player
    $level = "easy"; //default level
}


// Check if the user is logged in
if ($player->isConnected()) {

    // Check if a level was selected
    if (isset($_POST['level'])) {
        // Set the game level and generate the cards
        $level = $_POST['level'];
        $game->setLevel($level);
        $game->generateCards();
    }
    // Check if a card was clicked
    if (isset($_POST['card_index'])) {
        // A card was clicked, flip it over and check for a match
        $game->flipCard($_POST['card_index']);
        $game->checkForMatch();
    }

    // Check if the game is over
    if ($game->isOver()) {
        // Game is over, add the score to the database and reset the game
        $game->saveScore($_SESSION['login'], $level, $game->getScore($_SESSION['login'], $level));
        $stmt = $db->getPdo()->prepare("SELECT score, level FROM player_score WHERE login = ?");
        $stmt->execute([$_SESSION['login']]);
        $score_data = $stmt->fetch(PDO::FETCH_ASSOC);
        $score = $score_data['score'];
        $game->reset();
    }
} else {
    // The user is not logged in, redirect to the login page
    header('Location: login.php');
    exit();
}

?>
<!-- Display the game level and score -->
<div class="level-info">
    <h2>Level: <?php echo $game->getLevel(); ?></h2>
    <h2>Score: <?php echo $game->getScore($_SESSION['login'], $level); ?></h2>
</div>

<!-- Afficher le tableau -->
<main class="main">
    <section class="container">

    <table>
        <?php
        /* foreach ($game->getCards() as $i => $card) { */
        for ($i = 0; $i < count($game->getCards()); $i++) {
            echo '
            <tr>
                <td>
                <form action="game.php" method="post">
                    <input type="hidden" name="level" value="'.$game->getLevel().'">
                    <input type="hidden" name="card_index" value="'.$i.'">
                    <input type="image" src="'.$card->getBackImage().'" width="100" height="100">
                </form>
                </td>
            </tr>
            ';
        }
        ?>
        </table>
    </section>
</main>

<?php
require_once 'includes/footer.php';
?>