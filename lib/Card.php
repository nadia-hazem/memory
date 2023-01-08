<?php

    require_once 'lib/Game.php';


    class Card extends Game
    {
        public $value;
        public $image;
        public $flipped;

        public function __construct($value, $image)
        {
            $this->value = $value;
            $this->image = $image;
            $this->flipped = false;
        }
    }

?>