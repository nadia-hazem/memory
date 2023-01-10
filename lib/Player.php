<?php require_once 'autoloader.php'; ?>

<?php

class Player
{
    // attributs
    public $id;
    public $login;
    private $password;
    private $db;

    // constructor
    public function __construct($db) 
    {
        $this->db = $db;
    } 
    public function register($login, $password)
    {
        // Validate the form fields
        if ($login != "" && $password != "") {
            // Check if the login already exists
            $request = "SELECT * FROM players WHERE login = :login ";
            // Prepare the SQL statement
            $select = $this->db->getPdo()->prepare($request);
            // Execute the statement with parameter binding
            $select->execute(array(':login' => $login));
            // Retrieve the results
            $fetch = $select->fetchAll();
            $row = count($fetch);
            
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // If the login does not exist, insert the new login and hashed password into the database
            if ($row == 0) {
                $register = "INSERT INTO players (login, password) VALUES (:login, :password)";
                // Prepare the SQL statement
                $insert = $this->db->getPdo()->prepare($register);
                // Execute the statement with parameter binding
                $insert->execute(array(
                    ':login' => $login,
                    ':password' => $hashed_password
                ));
                echo "Registration successful!";
                header('Location: login.php');
            }
            else {
                $error = "This login already exists!";
                return $error;
            }
        }
        else {
            echo "You must fill in all fields!";
        }
    }
    public function connect($login, $password)
    {
        // Check if login and password fields are not empty
        if ($login != "" && $password != "") {
            // Retrieve hashed password from database for the specified login
            $request = "SELECT password FROM players WHERE login = :login";
            $select = $this->db->getPdo()->prepare($request);
            $select->execute(array(':login' => $login));
            $result = $select->fetch();
            $hashed_password = $result['password'];
            
            // Verify the password
            if (password_verify($password, $hashed_password)) {
                // Password is correct, continue with login
                $request = "SELECT * FROM players WHERE login = :login";
                // Prepare the SQL statement
                $select = $this->db->getPdo()->prepare($request);
                // Execute the statement with parameter binding
                $select->execute(array(':login' => $login));
                $result = $select->fetch();
                
                // Create the session
                $_SESSION['user'] = [
                    'id' => $result['id'],
                    'login' => $login,
                ];
                
                // Redirect to the profile page
                if (isset($_SESSION['user'])) {
                    header('Location: profile.php');
                }
            } 
            else 
            {
                echo "Login ou mot de passe incorrect !";
            }
        } else {
            echo "Vous devez remplir tous les champs !";
        }
    }
    public function disconnect()
    {   // vérification de la connexion
        if($this->isConnected()) 
            {
            // fermeture de la connexion
            echo "déconnexion réussie";
            session_destroy();
            }
            else {
                echo "Vous n'êtes pas connecté(e) !";
            }
    }
    public function delete()
    {
        if ($this->isConnected()) {
            // Delete the player's score
            $stmt = $this->db->getPdo()->prepare("DELETE FROM player_score WHERE player_id = :player_id");
            $stmt->execute(['player_id' => $this->id]);
    
            // Delete the player's global score
            $stmt = $this->db->getPdo()->prepare("DELETE FROM global_score WHERE player_id = :player_id");
            $stmt->execute(['player_id' => $this->id]);
    
            // Delete the player
            $stmt = $this->db->getPdo()->prepare("DELETE FROM players WHERE id = :id");
            $stmt->execute(['id' => $this->id]);
    
            session_destroy();
            echo "Utilisateur supprimé !";
        } else {
            echo "Vous devez être connecté pour supprimer votre compte !";
        }
    }
    public function update($login, $password)
    {
        if($this->isConnected())
        {
            if ($login != "" && $password != "") 
            {   // mise à jour des variables de session
                $_SESSION['user']['login'] = $login;
                $_SESSION['user']['password'] = $password;
                // vérification de l'existence du login
                $request = "SELECT * FROM utilisateurs WHERE login = :login ";
                // préparation de la requête 
                $select = $this->db->getPdo()->prepare($request);
                // exécution de la requête avec liaison des paramètres
                $select->execute(array(
                    ':login' => $login
                ));
                // récupération des résultats
                $fetch = $select->fetchAll();
                $row = count($fetch);
                // vérification de la disponibilité du login et mise à jour dans la base de données
                if ($row == 0) {
                    // requête de mise à jour
                    $update = "UPDATE utilisateurs SET login = :login, password = :password, email = :email, firstname = :firstname, lastname = :lastname WHERE id = :id ";
                    // préparation de la requête
                    $select = $this->db->getPdo()->prepare($update);
                    // exécution de la requête avec liaison des paramètres
                    $select->execute(array(
                        ':login' => $login,
                        ':password' => $password,
                        ':id' => $this->id
                    ));
                    echo "Mise à jour terminée !";
                }
                else {
                    echo "Vous devez saisir un nouveau login !";
                }
            }
            else {
                echo "Vous devez remplir tous les champs !";
            }
        }
        else {
            echo "Vous devez être connecté pour modifier vos informations !";
        }
    }
    public function isConnected()
    {
        return isset($_SESSION['user']) && isset($_SESSION['user']['id']) && isset($_SESSION['user']['login']);
    }
    public function getAllInfos()
    {
        if($this->isConnected()) 
        {   ?>
            <table border="1" style="border-collapse: collapse;">
                <thead>
                    <tr>
                        <th>id</td>
                        <th>login</td>
                        <th>password</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th><?php echo $this->id; ?></td>
                        <td><?php echo $this->login; ?></td>
                        <td><?php echo $this->password; ?></td>
                    </tr>
                </tbody>
            </table>

            <?php
            /* echo "login : " . $this->login . "<br>";
            echo "password : " . $this->password . "<br>";
            echo "email : " . $this->email . "<br>";
            echo "firstname : " . $this->firstname . "<br>";
            echo "lastname : " . $this->lastname . "<br>"; */
        }
        else {
            echo "Vous devez être connecté(e) pour voir vos informations !";
        
        }

    }
    public function getLogin()
    {
        if($this->isConnected()) 
        {
            echo "login : " . $this->login . "<br>";
        }
        else {
            echo "Vous devez être connecté(e) pour voir vos informations !";
        }
    }
        public function getId()
    {
        return $this->id;
    }
    public function getScore($login, $level)
{
    $stmt = $this->db->getPdo()->prepare("SELECT score FROM player_score WHERE login = ? AND level = ?");
    $stmt->execute([$login, $level]);
    $score = $stmt->fetch(PDO::FETCH_ASSOC)['score'];
    return $score;
}

}


//$user = new Userpdo();
// test register PDO   //OK
//echo $user->register('test1', 'test1', 'test1@test.fr', 'testnom1', 'testprenom1');

//test connect  PDO //OK
//echo $user->connect('test2', 'test2');

//test disconnect PDO  //OK
//echo $user->disconnect();

//test update PDO //OK
//echo $user->update('test', 'test', 'test@test.fr', 'testnom', 'testprenom');

//test isConnected PDO  //OK
//echo $user->isConnected();

//test getAllInfos PDO  //OK
//echo $user->getAllInfos();

//test getLogin PDO //OK
//echo $user->getLogin();

/* echo "<br>";
echo $user->login;
echo "<br>";
echo $user->email;
echo "<br>";
echo $user->firstname;
echo "<br>";
echo $user->lastname; */


?>