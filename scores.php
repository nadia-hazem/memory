<?php session_start() ?>
<?php require_once 'includes/header.php'; ?>

<?php
/* $_SESSION['login'] = $login; // Set la session login */
// vérifier l'état du joueur, pour la protection des pages privées
if (!$player->isConnected()) {
    // Le joueur n'est pas connecté, rediriger vers la page de connexion
    header('Location: login.php');
    exit();
}

// Créer une instance de la classe DbConnect
$db = new DbConnect();
// Créer une instance de la classe Player
$player = new Player($db);

// Récupérer les données des joueurs
    ?>
    <body id="scores">
        <a class="btn-back" href="index.php"><img src="assets/img/btn-back.png"></a>
        <main class="d-flex flex-fill align-items-center justify-content-center mx-auto h-100">
            <div class="col mx-auto">
                <h1 class="text-center">Classement</h1>
                <form method="get" action="">
                    <select name="level">
                        <option value="3">3 paires</option>
                        <option value="4">4 paires</option>
                        <option value="5">5 paires</option>
                        <option value="6">6 paires</option>
                        <option value="7">7 paires</option>
                        <option value="8">8 paires</option>
                        <option value="9">9 paires</option>
                        <option value="10">10 paires</option>
                        <option value="11">11 paires</option>
                        <option value="12">12 paires</option>
                    </select>
                    <input type="submit" value="Choisir le niveau des scores" class="btn btn-danger m-2">
                </form>
                <?php
                if(empty($_GET)) {
                    $_GET['level'] = 3;
                }
                $player->getGlobalScore($_GET['level']);
                ?>                  
                
            </div>

        </main>

<?php require_once 'includes/footer.php'; ?>