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
        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    </head>

    <body class="d-flex flex-column">
        <header>
            <div class="row float-right pr-3">
                <?php
                if ($player->isConnected()) {
                ?>
                <nav>
                    <div class="row ">
                        <h4 style="font-family: 'Simpsonfont'; padding-top: 20px; padding-right: 2rem;" class="text-start text-white">Bienvenue <?= $player->getLogin() ?></h4>
                        <a class="btn btn-info" href="profile.php">Profil</a>
                        <a class="btn btn-info" href="game.php">Jouer</a>
                        <a class="btn btn-info" href="scores.php">Classement</a>
                        <a class="btn btn-info logout" href="index.php?logout=true">Deconnexion</a>
                    </div>
                </nav>
                <?php
                } 
                else 
                {
                ?>
                <nav class="mx-auto">
                    <a class="btn btn-info" href="index.php">Accueil</a>
                    <a class="btn btn-info" href="login.php">Connexion</a>
                    <a class="btn btn-info" href="register.php">Inscription</a>
                </nav>

                <?php
                }
                ?>
            </div> <!--end row-->
        </header>
