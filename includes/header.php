<?php require_once 'autoloader.php'; ?>
<?php
$db = new DbConnect();
$player = new Player($db);
$game = new Game();

// si l'utilisateur click sur déconnexion
if (isset($_GET['logout'])){
    if($_GET['logout']==true){
        $player->disconnect();
        header('Location: index.php');
    }
}
if (isset($_GET['reset'])) {
    $game->reset();
    header('Location: game.php');
}
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Memory game</title>
        <!-- css -->
        <link rel="stylesheet" href="assets/css/style.css">
        <!-- font -->
        <link href="https://fonts.cdnfonts.com/css/simpsonfont" rel="stylesheet">
    </head>

    <body>
        <div class="wrapper">
            <header>
                <?php
                if ($player->isConnected()) {
                ?>
                <nav id="navigation" role="navigation" class="row flex-end">
                    <ul>
                        <li><p class="name font">Bienvenue <?= $player->getLogin() ?></p></li>
                        <li><button class="btn info"><a href="profile.php">Profil</a></button></li>
                        <li><button class="btn info"><a href="game.php">Jouer</a></button></li>
                        <li><button class="btn info"><a href="scores.php">Classement</a></button></li>
                        <li><button class="btn info"><a href="index.php?logout=true">Deconnexion</a></button></li>
                    </ul>
                </nav>
                <!-- version mobile -->
                <nav id="navigationmobile" role="navigation">
                    <input type="checkbox" id="toggle-nav" aria-label="open/close navigation">
                    <label for="toggle-nav" class="nav-button"></label>
                    <div class="nav-inner">
                        <h4 class="name">Bienvenue <?= $player->getLogin() ?></h4>
                        <a href="profile.php">Profil</a>
                        <a href="game.php">Jouer</a>
                        <a href="scores.php">Classement</a>
                        <a href="index.php?logout=true">Deconnexion</a>
                    </div>
                </nav>
                <?php
                } 
                else 
                {
                ?>
                <nav id="navigation" role="navigation" class="row flex-end">
                    <ul>
                        <li><button class="btn info"><a href="index.php">Accueil</a></button></li>
                        <li><button class="btn info"><a href="login.php">Connexion</a></button></li>
                        <li><button class="btn info"><a href="register.php">Inscription</a></button></li>
                    </ul>
                </nav>
                <!-- version mobile -->
                <nav id="navigationmobile" role="navigation">
                    <input type="checkbox" id="toggle-nav" aria-label="open/close navigation">
                    <label for="toggle-nav" class="nav-button"></label>
                    <div class="nav-inner">
                        <a href="index.php">Accueil</a>
                        <a href="login.php">Connexion</a>
                        <a href="register.php">Inscription</a>
                    </div>
                </nav>

                <?php
                }
                ?>

            </header>

