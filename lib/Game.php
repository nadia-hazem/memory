<?php
require_once 'autoloader.php';

class Game {
    private $card_1;
    private $card_2;
    private $card_3;
    private $card_4;
    private $card_5;
    private $card_6;
    private $card_7;
    private $card_8;
    private $card_9;
    private $card_10;
    private $card_11;
    private $card_12;
    private $cards;

    public function __construct() {
        $this->card_1 = './assets/img/cards/front_1.png';
        $this->card_2 = './assets/img/cards/front_2.png';
        $this->card_3 = './assets/img/cards/front_3.png';
        $this->card_4 = './assets/img/cards/front_4.png';
        $this->card_5 = './assets/img/cards/front_5.png';
        $this->card_6 = './assets/img/cards/front_6.png';
        $this->card_7 = './assets/img/cards/front_7.png';
        $this->card_8 = './assets/img/cards/front_8.png';
        $this->card_9 = './assets/img/cards/front_9.png';
        $this->card_10 = './assets/img/cards/front_10.png';
        $this->card_11 = './assets/img/cards/front_11.png';
        $this->card_12 = './assets/img/cards/front_12.png';
        $this->cards = array($this->card_1, $this->card_2, $this->card_3, $this->card_4, $this->card_5, $this->card_6, $this->card_7, $this->card_8, $this->card_9, $this->card_10, $this->card_11, $this->card_12);
    }

    // methods

    public function reset() {
        // Réinitialiser les variables de session
        unset($_SESSION['flip1']);
        unset($_SESSION['flip2']);
        unset($_SESSION['level']);
        unset($_SESSION['find']);
        unset($_SESSION['new']);
        $_SESSION['find'] = [];
        $_SESSION['coup'] = 1;
    }

    public function getCards() {
        // Distribuer les cartes en double avec un tableau aléatoire
        $rand = array_rand($this->cards, (int)$_SESSION['level']);
        for ($i = 0; isset($rand[$i]); $i++) {
            $board[] = $this->cards[$rand[$i]];
            $board[] = $this->cards[$rand[$i]];
        }
        // Mélanger les cartes
        shuffle($board);
        $_SESSION['board'] = $board;
    }

    public function checkMatch() {
        // Vérifier si les cartes sont identiques
        if ($_SESSION['flip1']['front'] === $_SESSION['flip2']['front']) {
            $_SESSION['find'][] = $_SESSION['flip1']['id'];
            $_SESSION['find'][] = $_SESSION['flip2']['id'];
            unset($_SESSION['flip1']);
            unset($_SESSION['flip2']);
        }
        else {
            // Les cartes ne sont pas identiques
            unset($_SESSION['flip2']);
            unset($_SESSION['flip1']);
        }
        // Vérifier si le jeu est terminé
        if($this->checkEnd()==false){
            $_SESSION['coup']++;
            header('Refresh: 1; URL=game.php');
        }
    }
    public function checkEnd() {
        // Vérifier si le jeu est terminé
        if (count($_SESSION['find']) === (int)$_SESSION['level'] * 2) {
            return true;
        }
        else {
            return false;
        }
    }
}
?>