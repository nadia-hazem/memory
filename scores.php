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
        <div class="wrapper">
            <main>
                <h1 class=" panel-title">Classement</h1>
                <div class="panel">                    
                    <div class="col inner-panel">
                        <form method="get" class="select">
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
                            <input type="submit" value="Choisir le niveau des scores" class="">
                        </form>
                    </div>

                    <?php
                    // Récupérer les données du joueur
                    if(empty($_GET)) {
                        $_GET['level'] = 3;
                    } // Afficher le classement
                    $player->getGlobalScore($_GET['level']);
                    ?>   
                    <br>
                    <br>                    
            
                </div>
            </main>
            <div class="push"></div>
        </div> <!-- /wrapper -->

<?php require_once 'includes/footer.php'; ?>
