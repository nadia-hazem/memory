<?php
require_once 'autoloader.php';

class Game {
    private $player;
    private $level;
    private $cards;
    private $score;
    private $numFlipped = 0;
    private $matches = 0;
    private $flippedCards = array();
    private $flippedCardsIndexes = array();
    private $firstCard;
    private $secondCard;
    private $flipped = false;
    private $db;

    public function __construct($player, $db) {
        $this->player = $player;
        $this->db = $db;
        $this->level = "Démarrer";
        $this->score = 0;
        $this->matches = false;
        $this->flipped = false;
        $this->flippedCards = array();
        $this->flippedCardsIndexes = array();

    }
    public function setLevel($level) {
        $this->level = $level;
    }
    public function getLevel() {
        return $this->level;
    }
    public function generateCards() {
        $this->cards = [];
        for ($i = 0; $i < $this->level; $i++) {
            $this->cards[] = new Card('../assets/img/cards/front_'.$i.'.png', '../assets/img/cards/back_img.png');
            $this->cards[] = new Card('../assets/img/cards/front_'.$i.'.png', '../assets/img/cards/back_img.png');
        }
        shuffle($this->cards);
    }
    public function getCards() {
        return $this->cards;
    }
    public function flipCard($card_index) {
        $this->flipped = !$this->flipped;
    }
    public function checkForMatch() {
        if ($this->cards[$this->firstCard]->getFrontImage() == $this->cards[$this->secondCard]->getFrontImage()) {
            $this->matches++;
        } else {
            $this->cards[$this->firstCard]->flip();
            $this->cards[$this->secondCard]->flip();
        }
        $this->flippedCards = array();
        $this->flippedCardsIndexes = array();
    }
    public function isOver() {
        if ($this->matches == count($this->cards) / 2) {
            return true;
        } else {
            return false;
        }
    }
    public function reset() {
        $this->cards = [];
        $this->matches = 0;
        $this->score = 0;
        $this->generateCards();
    }
    public function play() {
        if (isset($_POST['card_index'])) {
            $cardIndex = intval($_POST['card_index']);
            $this->cards[$cardIndex]->flip();
            $this->numFlipped++;
            if ($this->numFlipped == 1) {
                $this->firstCard = $cardIndex;
            } else {
                $this->secondCard = $cardIndex;
                if ($this->cards[$this->firstCard]->getFrontImage() == $this->cards[$this->secondCard]->getFrontImage()) {
                    $this->score++;
                } else {
                    $this->cards[$this->firstCard]->flip();
                    $this->cards[$this->secondCard]->flip();
                }
                $this->numFlipped = 0;
                $this->firstCard = null;
                $this->secondCard = null;
            }
        }
    }
    public function getScore(string $login,int $level): int {
        $stmt = $this->db->prepare("SELECT score FROM scores WHERE login = ? AND level = ?");
        $stmt->bind_param("si", $login, $level);
        $stmt->execute();
        $result = $stmt->get_result();
        $score = $result->fetch_assoc();
        return $score['score'];
    }
    public function saveScore($login, $level, $score) {
        // Prepare the SQL statement
        $stmt = $this->db->prepare("INSERT INTO scores (login, level, score) VALUES (?, ?, ?)");
        $stmt->bind_param("sis", $login, $level, $score);

        // Execute the statement
        $stmt->execute();

        // Close the connection
        $this->db->close();
    }
}
?>