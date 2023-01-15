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
        <header>
            <?php
            // Si le joueur est connecté, afficher le menu
            if ($player->isConnected()) {
            ?>
            <nav id="navigation" role="navigation" class="row flex-end">
                <ul>
                    <li><p class="name font">Bienvenue <?= $player->getLogin() ?></p></li>
                    <li><button class="btn info"><a href="index.php">Accueil</a></button></li>
                    <li><button class="btn info"><a href="profile.php">Profil</a></button></li>
                    <li><button class="btn info"><a href="game.php">Jouer</a></button></li>
                    <li><button class="btn info"><a href="scores.php">Classement</a></button></li>
                    <li><button class="btn info"><a href="index.php?logout=true">Deconnexion</a></button></li>
                </ul>
            </nav>
            <!-- version mobile -->
            <div id="navigationmobile" role="navigation" class="col">
                <div id="menuToggle">
                    <input type="checkbox" />
                
                    <span></span>
                    <span></span>
                    <span></span>
        
                    <ul id="menu">
                        <li><h4 class="name">Bienvenue <?= $player->getLogin() ?></h4></li>
                        <li><a href="index.php">Accueil</a></li>
                        <li><a href="profile.php">Profil</a></li>
                        <li><a href="game.php">Jouer</a></li>
                        <li><a href="scores.php">Classement</a></li>
                        <li><a href="index.php?logout=true">Deconnexion</a></li>
                    </ul>
                </div>
            </div>
            <?php
            } 
            else 
            {
                // Sinon afficher le menu de connexion
            ?>
            <nav id="navigation" role="navigation" class="row flex-end">
                <ul>
                    <li><button class="btn info"><a href="index.php">Accueil</a></button></li>
                    <li><button class="btn info"><a href="login.php">Connexion</a></button></li>
                    <li><button class="btn info"><a href="register.php">Inscription</a></button></li>
                </ul>
            </nav>
            <!-- version mobile -->
            <div id="navigationmobile" role="navigation" class="col">
                <!--They are acting like a real hamburger, not that McDonalds stuff.-->
                <div id="menuToggle">
                    <input type="checkbox" />
                
                    <span></span>
                    <span></span>
                    <span></span>
        
                    <ul id="menu">
                        <li><a href="index.php">Accueil</a></li>
                        <li><a href="login.php">Connexion</li>
                        <li><a href="register.php">Inscription</a></li>
                    </ul>
                </div>
            </div>

            <?php
            }
            ?>

        </header>

