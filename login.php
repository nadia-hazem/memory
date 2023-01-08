<?php

// Include the Player class
require_once 'lib/Player.php';

// Create an instance of the Player class
$player = new Player();

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $login = trim($_POST['login']);
    $password = trim($_POST['password']);

    // Attempt to log the user in
    $player->connect($login, $password);
}

?>

<!-- Login form -->
<form method="post" action="login.php">
    <label for="login">Login:</label>
    <input type="text" id="login" name="login">
    <br>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password">
    <br>
    <input type="submit" value="Log In">
</form>
