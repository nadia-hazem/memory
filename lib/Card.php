<?php
class Card {
    private $frontImage;
    private $backImage;
    private $flipped = false;

    public function __construct() {
    }
    public function setFrontImage($frontImage){
        $this->frontImage = $frontImage;
    }
    public function getFrontImage(){
        return $this->frontImage;
    }
    public function setBackImage($backImage){
        $this->backImage = $backImage;
    }
    public function getBackImage(){
        return $this->backImage;
    }
    public function flip() {
        $this->flipped = !$this->flipped;
    }
}

?>