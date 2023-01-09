<?php
require_once 'autoloader.php';

class Score extends DbConnect
{
    // PDO object
    private $pdo;

    // Constructor
    public function __construct(DbConnect $db) {
        $this->pdo = $db->getPdo();
    }

    // Get all players
    public function getPlayers() {
        $stmt = $this->pdo->prepare("SELECT * FROM players");
        return $stmt->fetchAll();
    }

    // Get player's score
    public function getPlayerScore($player_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM player_score WHERE player_id = $player_id");
        return $stmt->fetchAll();
    }

    // Get global scores
    public function getGlobalScore() {
        $stmt = $this->pdo->prepare("SELECT * FROM global_score");
        return $stmt->fetchAll();
    }

    // Save score
    public function saveScore($player_id, $score, $level) {
        // Save the score to the player_scores table
        $stmt = $this->pdo->prepare("INSERT INTO player_score (player_id, score, level) VALUES (:player_id, :score, :level)");
        $stmt->execute(['player_id' => $player_id, 'score' => $score, 'level' => $level]);

        // Save the score to the global_scores table
        $stmt = $this->pdo->prepare("INSERT INTO global_score (player_id, score, level) VALUES (:player_id, :score, :level)");
        $stmt->execute(['player_id' => $player_id, 'score' => $score, 'level' => $level]);
    }

    // Get score date
    public function getPlayerDate($player_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM player_score WHERE player_id = $player_id");
        $result = $stmt->fetchAll();
        return $result[0]['date'];
    }

    // Get player's level
    public function getPlayerLevel($player_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM player_score WHERE player_id = $player_id");
        $result = $stmt->fetchAll();
        return $result[0]['level'];
    }
}
