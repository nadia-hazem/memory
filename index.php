<?php
session_start();

// Include the necessary classes
?>
<?php require_once 'lib/Player.php'; ?>

<?php require_once 'includes/header.php'; ?>
<?php
// Check if the user is logged in
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) 
{
?>
<main class="container">
    <h1>Memory Game</h1>
    <table>
        <tr><td><h3>Bienvenue <?php echo $_SESSION['username']; ?></h3></td></tr>
        <!-- The user is logged in, show the game menu -->
        <tr><td><a href="game.php">Jouer</a></td></tr>
        <tr><td><a href="profile.php">Profil</a></td></tr>
        <tr><td><a href="global_scores.php">Score global</a></td></tr>
        <tr><td><a href="logout.php">Déconnexion</a></td></tr>
        
    </table>
    
    <?php } else { 
    // The user is not logged in, show the login/registration form ?>
    <h1>Bienvenue au Memory Game</h1>
    <table>
        <tr><td><a href="login.php">Connexion</a></td></tr>
        <tr><td><a href="register.php">Inscription</a></td></tr>
    </table>
    
    <?php
    }
    ?>

</main>

<?php
require_once 'includes/footer.php'
?>
