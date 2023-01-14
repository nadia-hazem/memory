<?php session_start() ?>
<?php require_once 'includes/header.php'; ?>

<?php
// Créer une instance de la classe DbConnect
$db = new DbConnect();
// Créer une instance de la classe Player
$player = new Player($db);

// Check if the user is logged in
if ($player->isConnected()) {
    $login = $player->getLogin();

?>

<body id="index">
    <div class="wrapper">
        <main class="index">
            
            <?php
            if(isset($_POST['level'])) {
                $level = $_POST['level'];
                header("Location: game.php?level=$level");
                exit;
                }  
            ?>
            <?php } else { 
            // The user is not logged in, show the login/registration links ?>
                <body id="index">
                    <main class="index"> -->
                        <!-- <div class="col-md-6 mx-auto align-self-center mt-5">
                            <h1 class="text-white">Simpson's Memory Game</h1>
                            <a class="btn btn-info" href="login.php"><h3>Connexion</h3></a>
                            <a class="btn btn-info" href="register.php"><h3>Inscription</h3></a>
                        </div> -->

            <?php
            }
            ?>
        </main>
        <div class="push"></div>
    </div> <!--/wrapper-->

<?php require_once 'includes/footer.php' ?>