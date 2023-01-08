
<?php
    require_once 'lib/Player.php';
    require_once 'lib/Game.php';
    
    class Score extends Player
    {
        // PDO object
        private $pdo;

        // Constructor
        public function __construct($pdo) {
            $this->pdo = $pdo;
        }

        // Get the players
        public function getPlayers() {
            $stmt = $this->pdo->query("SELECT * FROM players");
            return $stmt->fetchAll();
        }

        // Get the player scores
        public function getPlayerScores($player_id) {
            $stmt = $this->pdo->query("SELECT * FROM player_scores WHERE player_id = $player_id");
            return $stmt->fetchAll();
        }

        // Get the global scores
        public function getGlobalScores() {
            $stmt = $this->pdo->query("SELECT * FROM global_scores");
            return $stmt->fetchAll();
        }

        public function saveScore($player_id, $score, $level) {
            // Save the score to the player_scores table
            $stmt = $this->pdo->prepare("INSERT INTO player_scores (player_id, score, level) VALUES (:player_id, :score, :level)");
            $stmt->execute(['player_id' => $player_id, 'score' => $score, 'level' => $level]);

            // Save the score to the global_scores table
            $stmt = $this->pdo->prepare("INSERT INTO global_scores (player_id, score, level) VALUES (:player_id, :score, :level)");
            $stmt->execute(['player_id' => $player_id, 'score' => $score, 'level' => $level]);
        }
    }

?>