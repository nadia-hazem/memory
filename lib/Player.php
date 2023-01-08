
<?php


    class Player
    {
        // attributs
        private $id;
        public $login;
        private $password;
        private $bdd;

        // Méthodes  
        public function __construct() { 
            $host = 'localhost';
            $dbname = 'memory';
            $dbuser = 'root';
            $dbpass = '';

            /* $this->bdd = new PDO('mysql:host=localhost; dbname=memory; charset=utf8', 'root', ''); */
            try {
                $this->bdd = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $dbuser, $dbpass);
                $this->bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } 
            catch (PDOException $e) 
            {
                echo "Erreur : " . $e->getMessage();
                die();
            }
            //vérification de session
            if(isset($_SESSION['user'])) 
            {
                $this->id = $_SESSION['user']['id'];
                $this->login = $_SESSION['user']['login'];
                $this->password = $_SESSION['user']['password'];  
            }
        } 

        public function register($login, $password)
        {
            // Validate the form fields
            if ($login != "" && $password != "") {
                // Check if the login already exists
                $request = "SELECT * FROM players WHERE login = :login ";
                // Prepare the SQL statement
                $select = $this->bdd->prepare($request);
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
                    $insert = $this->bdd->prepare($register);
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
                $select = $this->bdd->prepare($request);
                $select->execute(array(':login' => $login));
                $hashed_password = $select->fetchColumn();
                
                // Verify the password
                if (password_verify($password, $hashed_password)) {
                    // Password is correct, continue with login
                    $request = "SELECT * FROM players WHERE login = :login";
                    // Prepare the SQL statement
                    $select = $this->bdd->prepare($request);
                    // Execute the statement with parameter binding
                    $select->execute(array(':login' => $login));
                    $result = $select->fetch();
                    
                    // Create the session
                    $_SESSION['user'] = [
                        'id' => $result['id'],
                        'login' => $result['login'],
                        'password' => $result['password'],
                    ];
                    // Redirect to the profile page
                    header('Location: profile.php');
                } 
                else 
                {
                    echo "Incorrect login or password!";
                }
            } else {
                echo "You must fill in all fields!";
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

        public function delete($playerId)
        {   
            if($this->isConnected()) 
            {   // requête de suppression avec INNERJOIN pour supprimer les scores associés
                $delete = "DELETE players, player_score, global_score FROM players INNER JOIN player_score ON players.id = player_score.player_id INNER JOIN global_score ON player_score.score_id = global_score.id WHERE players.id = :id ";
                // préparation de la requête
                $delete = $this->bdd->prepare($delete);
                // exécution de la requête avec liaison des paramètres
                $delete->execute(array(
                    ':id' => $this->id
                ));
                // récupération des résultats
                $result = $delete->fetchAll();
                // vérification de la suppression
                if ($result == TRUE) {
                    echo "Utilisateur supprimé !"; 
                    session_destroy();
                }
                else{
                    echo "Erreur lors de la suppression de l'utilisateur !";
                }
            }
            else {
                echo "Vous devez être connecté pour supprimer votre compte !";
            }
            // fermeture de la connexion
            $this->bdd = null; 
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
                    $select = $this->bdd->prepare($request);
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
                        $select = $this->bdd->prepare($update);
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
            if($this->id != null && $this->login != null && $this->password != null) {
                return true;
            }
            else {
                return false;
            }
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