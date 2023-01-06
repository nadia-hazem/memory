<?php

class Card
{
    private $id;
    private $value;
    private $image;
    private $isFlipped;

    public function __construct($id, $value, $image)
    {
        $this->id = $id;
        $this->value = $value;
        $this->image = $image;
        $this->isFlipped = false;
    }

    public function createRank($data, $rank) 
    {
        extract($data); ?>
        <tr class="scored" id="rank-<?= $rank ?>">
            <td><a href="profil.php?id=<?= $data["id_user"] ?>" class="user-link"><img src="<?= $avatar ?>" class=""/><span>&nbsp;<?= $login ?></span></a></td>
            <td><?= $time ?></td>
            <td><?= $attempts ?></td>
            <td><?= $level ?></td>
        </tr>
    <?php }

    public function getId()
    {
        return $this->id;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function getIsFlipped()
    {
        return $this->isFlipped;
    }

    public function setIsFlipped($isFlipped)
    {
        $this->isFlipped = $isFlipped;
    }
}