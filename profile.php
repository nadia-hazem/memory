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

// Vérifier si le joueur est connecté
if ($player->isConnected()) { ?>

    <h1 class="panel-title">Vos infos personnelles</h1>
    <div class="panel">
        <div class="col inner-panel">
            <div class="row justify-between">

                <div class="col">
                    <?php $perso = $player->getAllInfos(); ?>
                </div> <!-- /col -->

                <?php
                    if (isset($_POST['delete'])) {
                        $player->delete();
                    }
                ?>
                <div class="col">
                    <form method="post">
                        <h5  class="text-white arial"><span class="text-red bold">Attention ! </span>ceci supprimera définitivement votre compte</h5>
                        <input type="submit" name="delete" value="Supprimer mon compte" class="button danger">
                    </form>
                </div> <!-- /col -->

            </div> <!-- /row -->
            
        </div>
    </div>
    <div class="spaceone"></div>

    <?php
}
    // Récupérer les données du joueur
    ?>
    <body id="profile">
        <div class="wrapper">
            <main class="profile">
                <div class="panel">
                    <h1 class="panel-title text-white">Vos scores</h1>
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
                            <input type="submit" value="Choisir le niveau des scores" class="button success">
                        </form>
                    </div>

                    <?php
                    // Récupérer les données du joueur
                    if(empty($_GET)) {
                        $_GET['level'] = 3;
                    }
                    $player->getScore($_GET['level']);
                    ?>
                    <br>
                    <br>                    
                    
                </div> 
            </main>
            <div class="push"></div>
        </div> <!-- /wrapper -->

<?php require_once 'includes/footer.php'; ?>