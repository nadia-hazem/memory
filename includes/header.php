<?php require_once 'autoloader.php'; ?>
<?php
$db = new DbConnect();
$player = new Player($db);

// si l'utilisateur click sur déconnexion
if (isset($_GET['logout'])){
    if($_GET['logout']==true){
        $player->disconnect();
        header('Location: index.php');
    }
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
        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    </head>

    <body>
        <header>
            <div class="row justify-content-center ">
                <nav class="pl-5">
                    <ul class="nav nav-pills mx-auto">
                        <?php
                        if ($player->isConnected()) {
                        ?>
                        <li class="nav-item pb-3 ">
                            <a class="nav-link" href="index.php?logout=true">Déconnexion</a>
                        </li>
                    </ul>
                </nav>
                        <?php
                        } 
                        else 
                        {
                            ?>
                            <nav class="mx-auto">
                                <ul class="nav nav-pills mx-auto">
                                    <li class="nav-item pb-3 ">
                                    <a class="nav-link" href="index.php">Accueil</a>
                                    </li>
                                    <li class="nav-item pb-3 ">
                                    <a class="nav-link" href="login.php">Connexion</a>
                                    </li>
                                    <li class="nav-item pb-3 ">
                                    <a class="nav-link" href="register.php">Inscription</a>
                                    </li>
                                </ul>
                            </nav>

                            <?php
                        }
                        ?>
            </div> <!--end row-->
        </header>
