<?php session_start() ?>
<?php require_once 'includes/header.php'; ?>
<?php require_once 'autoloader.php'; ?>

<?php
// Create an instance of the Score class
$score = new Score($id, $player_id, $score, $level);

// Get the player data
$player = $player->getPlayer();
foreach ($players as $player) {
    echo "<h2>Player: " . $player['name'] . "</h2>";

    // Get the player's individual score
    $player_id = $player['id'];
    $scores = $score->getPlayerScore($player_id);
    foreach ($scores as $score) {
        echo "Score: " . $score['score'] . " (Level " . $score['level'] . ")<br>";
    }
}

// Get the global score
echo "<h2>Global Score</h2>";
$scores = $score->getGlobalScore();
foreach ($scores as $score) {
    echo $score['player_name'] . ": " . $score['score'] . " (Level " . $score['level'] . ")<br>";
}
?>
