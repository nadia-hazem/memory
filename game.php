<?php session_start() ?>
<?php require_once 'includes/header.php'; ?>
<?php require_once 'autoloader.php'; ?>

<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
// User is not logged in, redirect to the login page
header('Location: login.php');
exit;
}

//initialiser les variables
$pdo = new PDO('mysql:host=localhost;dbname=memory', 'root', '');
$login = "";
$score = 0;

// Get the level selected by the user
$level = intval($_POST['level']);

// Generate the cards for the selected level
$cards = [];
for ($i = 0; $i < $level; $i++) {
$cards[] = new Card('front_image_'.$i.'.jpg', 'back_image.jpg');
$cards[] = new Card('front_image_'.$i.'.jpg', 'back_image.jpg');
}
shuffle($cards);

// Initialize the game state
$numPairs = $level;
$numFlipped = 0;
$firstCard = null;
$secondCard = null;
$score = 0;

// Check if a card was clicked
if (isset($_POST['card_index'])) {
// A card was clicked, flip it over
$cardIndex = intval($_POST['card_index']);
$cards[$cardIndex]->flip();
$numFlipped++;

if ($numFlipped == 1) {
    // This is the first card flipped, store it
    $firstCard = $cardIndex;
} else {
    // This is the second card flipped, store it and check for a match
    $secondCard = $cardIndex;
    if ($cards[$firstCard]->getFrontImage() == $cards[$secondCard]->getFrontImage()) {
    // Cards match, increment the score and decrement the number of pairs left
    $score++;
    $numPairs--;
    } else {
    // Cards do not match, flip them back over
    $cards[$firstCard]->flip();
    $cards[$secondCard]->flip();
    }

    // Reset the game state for the next turn
    $numFlipped = 0;
    $firstCard = null;
    $secondCard = null;
}
}

if ($numPairs == 0) {
// All pairs have been found, end the game and add the score to the database
$Score = new Score($db);
$player->saveScore($_SESSION['username'], $level, $score);
}

?>

<!-- Display the game board -->
<table>
<?php
for ($i = 0; $i < count($cards); $i++) {
echo '
    <tr>
        <td>
        <form action="game.php" method="post">
            <input type="hidden" name="level" value="'.$level.'">
            <input type="hidden" name="card_index" value="'.$i.'">
            <input type="image" src="'.$cards[$i]->getBackImage().'" width="100" height="100">
        </form>
        </td>
    </tr>
    ';
}
?>
</table>

<!-- Display the score and number of pairs left -->
<p>Score: <?php echo $score ?> / <?php echo $level ?></p>
<p>Pairs left: <?php echo $numPairs ?></p>

<?php
if ($numPairs == 0) {
    // All pairs have been found, display a message and a button to play again
    echo '
    <p>Congratulations, you won!</p>
    <form action="game.php" method="post">
        <input type="hidden" name="level" value="'.$level.'">
        <input type="submit" value="Play again">
    </form>
    ';
}
?>