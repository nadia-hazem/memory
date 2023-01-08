<?php
    require_once 'lib/Score.php'; 
    require_once 'lib/Player.php';
    
    // Start the session
    session_start();
    
    // Include the necessary classes
    require_once 'lib/Player.php';
    require_once 'lib/Score.php';
    require_once 'includes/header.php';

    // Connect to the database
    $database = new Database();
    $pdo = $database->connect();

    // Check if the user is logged in
    if (!isset($_SESSION['login'])) {
        // The user is not logged in, redirect them to the login page
        header('Location: login.php');
        exit;
    }

    // Get the current user's login
    $login = $_SESSION['login'];

    // Create a new Player object
    $player = new Player($pdo, $login);

    // Get the player's data
    $data = $player->getAllInfos();

?>

<main>
    <nav class="nav">
        <a class="btn" href="index.php"><h3>Retour</h3></a>
        <a class="btn" href="game.php"><h3>Jouer</h3></a>
        <a class="btn" href="scores.php"><h3>Classement</h3></a>
        <a class="btn" href="index.php?exit=true"><h3>Déconnexion</h3></a>
        <form method="post">
            <input type="hidden" name="playerId" value="<?php echo $playerId; ?>">
            <input type="submit" class="btn btn-danger" value="Supprimer le compte">
        </form>
    </nav>
    <br>
    <h1>Profil</h1>
    <table>
        <tr>
            <th>Login</th>
            <th>Score</th>
        </tr>
        <tr>
            <td><?php echo $data['login']; ?></td>
            <td><?php echo $data['score']; ?></td>
        </tr>
    </table>
    <h2>Scores</h2>
    <table>
        <tr>
            <th>Score</th>
            <th>Niveau</th>
            <th>Date</th>
        </tr>
        <?php
            // Récupère les scores du joueur à partir de la base de données
            $stmt = $pdo->prepare('SELECT * FROM player_scores WHERE player_id = ? ORDER BY score DESC');
            $stmt->execute([$user->id]);
            $scores = $stmt->fetchAll();
            // Affiche les scores du joueur dans un tableau
            foreach ($scores as $score) {
                echo '<tr>';
                echo '<td>' . $score['score'] . '</td>';
                echo '<td>' . $score['level'] . '</td>';
                echo '<td>' . $score['date'] . '</td>';
                echo '</tr>';
            }

            // Supprime le compte du joueur
            if (isset($_POST['submit'])) {
                $player = new Player();
                $player->delete($playerId);
            }
        ?>
</main>

<?php include 'includes/footer.php' ?>
