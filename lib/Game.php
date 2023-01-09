<?php
require_once 'autoloader.php';

class Game extends DbConnect
{
    private $player;
    private $score;
    private $cards;
    private $guesses;

    public function __construct(Player $player, $level)
    {
        $this->player = $player;
        $this->cards = [];
        for ($i = 1; $i <= $level; $i++) {
        $this->cards[] = new Card($i, false);
        $this->cards[] = new Card($i, true);
        }
        shuffle($this->cards);
        $this->guesses = 0;
    }

    public function guess($card1, $card2)
    {
        $this->guesses++;
        if ($this->cards[$card1]->equals($this->cards[$card2])) {
        // The cards match, mark them as found
        $this->cards[$card1]->setFound(true);
        $this->cards[$card2]->setFound(true);
        }
    }

    public function render()
    {
        $html = '';
        $html .= '<table>';
        $html .= '  <tr>';
        foreach ($this->cards as $i => $card) {
        $html .= '<td>';
        if ($card->isFound()) {
            $html .= $card->getValue();
        } else {
            $html .= '<a href="#" onclick="document.forms[0].card1.value=' . $i . '; document.forms[0].card2.value=document.forms[0].card1.value; document.forms[0].submit(); return false;">';
            $html .= '  ?';
            $html .= '</a>';
        }
        $html .= '</td>';
        }
        $html .= '  </tr>';
        $html .= '</table>';
        $html .= '<p>Guesses: ' . $this->guesses . '</p>';
        return $html;
    }

    public function isFinished()
    {
        foreach ($this->cards as $card) {
        if (!$card->isFound()) {
            return false;
        }
        }
        return true;
    }
}
