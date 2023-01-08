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
    $password2 = trim($_POST['password2']);

    // Validate the form data
    if (empty($login)) {
        $error = "Please enter a login.";
    }
    elseif (empty($password)) {
        $error = "Please enter a password.";
    }
    elseif (empty($password2)) {
        $error = "Please confirm your password.";
    }
    elseif ($password !== $password2) {
        $error = "Passwords do not match!";
    }
    else {
        // The form data is valid, continue with registration
        $error = $player->register($login, $password);
    }
}
?>

<!-- Register form -->
<form method="post" action="register.php">
    <label for="login">Login:</label>
    <input type="text" id="login" name="login">
    <br>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password">
    <br>
    <label for="password2">Confirm Password:</label>
    <input type="password" id="password2" name="password2">
    <br>
    <input type="submit" value="Register">
</form>

<?php
if (isset($error)) {
    echo $error;
}
?>
