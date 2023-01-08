
<?php
include_once 'lib/Player.php';
include_once 'lib/Score.php';

// Create an instance of the Score class
$score = new Score($id, $player_id, $score, $level);

// Get the player data
$players = $score->getPlayers();
foreach ($players as $player) {
    echo "<h2>Player: " . $player['name'] . "</h2>";

    // Get the player's individual scores
    $player_id = $player['id'];
    $scores = $score->getPlayerScores($player_id);
    foreach ($scores as $score) {
        echo "Score: " . $score['score'] . " (Level " . $score['level'] . ")<br>";
    }
}

// Get the global scores
echo "<h2>Global Scores</h2>";
$scores = $score->getGlobalScores();
foreach ($scores as $score) {
    echo $score['player_name'] . ": " . $score['score'] . " (Level " . $score['level'] . ")<br>";
}
?>
