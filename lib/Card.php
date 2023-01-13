<?php
class Card {
    public $id;
    private $front;
    private $back;
    private $flip1;
    private $flip2;
    private $height;
    private $width;

    public function __construct($id) {
        $this->id = $id;
        $this->front = $_SESSION['board'][$id];
        $this->back = 'assets/img/cards/back_img.png';

        if (isset($_SESSION['flip1'])){
            $this->flip1['id'] = $_SESSION['flip1']['id'];
            $this->flip1['front'] = $_SESSION['flip1']['front'];
        }
        else {
            $this->flip1['id'] = "";
            $this->flip1['front'] = "";
        }
        if (isset($_SESSION['flip2'])){
            $this->flip2['id'] = $_SESSION['flip2']['id'];
            $this->flip2['front'] = $_SESSION['flip2']['front'];
        }
        else {
            $this->flip2['id'] = "";
            $this->flip2['front'] = "";
        }
        if((int)$_SESSION['level'] < 6) {
            $this->height = 200;
            $this->width = 133;
        }
        elseif ((int)$_SESSION['level'] < 9) {
            $this->height = 175;
            $this->width = 117;
        }
        elseif ((int)$_SESSION['level'] < 12) {
            $this->height = 150;
            $this->width = 100;
        }

    }

    public function getId() {
        return $this->id;
    }
    public function displayCard() {
        if ($this->isFound()) { ?>
            <img src="<?=$this->front?>" alt="card" class="card" height="<?= $this->height ?>" width="<?= $this->width ?>"> <?php
        } else { ?>
            <button name="id" value="<?= $this->id?>" ><img src="<?=$this->back?>" alt="card" id="btn-card" height="<?= $this->height ?>" width="<?= $this->width ?>"></button> <?php
        }
    }

    public function flippedCards() {
        if($this->flip1['id']=== ""){
            $_SESSION['flip1']['id'] = $this->id;
            $_SESSION['flip1']['front'] = $this->front;
            $this->flip1['id'] = $this->id;
            $this->flip1['front'] = $this->front;
        }
        else{
            $_SESSION['flip2']['id'] = $this->id;
            $_SESSION['flip2']['front'] = $this->front;
            $this->flip2['id'] = $this->id;
            $this->flip2['front'] = $this->front;
        }
    }

    public function isFound() {
        if($this->id === $this->flip1['id'] || $this->id === $this->flip2['id'] || in_array($this->id, $_SESSION['find'])){
            return true;
        }
        else{
            return false;
        }
    }

}

?>