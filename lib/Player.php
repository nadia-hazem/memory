
<?php
    session_start();

    class Player
    {
        // attributs
        private $id;
        private $login;
        private $password;
        private $bdd;

        // Méthodes  
        public function __construct() { 
            // connexion à la base de données
            $host = 'localhost';
            $dbname = 'memory';
            $dbuser = 'root';
            $dbpass = '';
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

        public function register($login, $password, $password2)
        {
            // vérification des champs
            if ($login != "" && $password != "" && $password2 != "") 
            {
                // vérification de la correspondance des mots de passe
                if ($password != $password2) 
                {
                    echo "Les mots de passe ne correspondent pas !";
                    return;
                }
                else 
                {
                    // les vérifications sont faites, on passe à l'enregistrement dans la base de données:
                    //cryptage du mot de passe
                    $password = password_hash($password, PASSWORD_DEFAULT);
                    // requête de sélection
                    $request = "SELECT * FROM players WHERE login = :login ";
                    // préparation de la requête
                    $select = $this->bdd->prepare($request);
                    // exécution de la requête avec liaison des paramètres
                    $select->execute(array(
                        ':login' => $login
                    ));
                    // récupération des résultats
                    $fetch = $select->fetchAll();
                    $row = count($fetch);
                    // vérification de disponibilité du login et insertion dans la base de données
                    if ($row == 0) {
                        $register = "INSERT INTO players (login, password) VALUES
                        (:login, :password)";
                        // préparation de la requête             
                        $insert = $this->bdd->prepare($register);
                        // exécution de la requête avec liaison des paramètres
                        $insert->execute(array(
                            ':login' => $login,
                            ':password' => $password
                        ));
                        echo "Inscription réussie !";
                        header("Refresh: 3; url=login.php");
                    }
                    else {
                        $error = "Ce login existe déjà !";
                        return $error;
                    }
                }
            }
            else 
            {
                echo "Vous devez remplir tous les champs !";
                return;
            }

        } // fin de la méthode register

        public function connect($login, $password)
        {   
            // vérification des champs
            if($login != "" && $password != "") 
            {
                // requête de sélection
                $request = "SELECT * FROM players WHERE login = :login ";
                // préparation de la requête
                $select = $this->bdd->prepare($request);
                // exécution de la requête avec liaison des paramètres
                $select->execute(array(
                    ':login' => $login
                ));
                // récupération des résultats
                $result = $select->fetchAll();
                // vérification de l'existence du login
                if(count($result) == 1) 
                {
                    $select->execute(array(
                    ':login' => $login
                    ));
                    // récupération des résultats
                    $result = $select->fetch(PDO::FETCH_ASSOC);
                    // vérification du mot de passe
                    if(password_verify($password, $result['password'])) 
                    {
                        // création de la session
                        $_SESSION['user']= [
                            'id' => $result['id'],
                            'login' => $result['login'],
                            'password' => $result['password'],
                        ]; 
                        echo "Connexion réussie !";   
                        header("Refresh: 1;url=game.php"); 
                    }
                    else 
                    {
                        echo "Mot de passe incorrect !";
                        return;
                    } 
                }
            }
            else 
            {
                echo "Veuillez saisir un login et un mot de passe";
            }
        } // fin de la méthode connect

        public function disconnect()
        {   // vérification de la connexion
            if($this->isConnected()) 
                {
                // fermeture de la connexion
                echo "Dommage de vous voir partir !";
                session_destroy();
                header("Refresh: 1;url=index.php");
                }
                else {
                    echo "Connectez-vous pour jouer !";
                }
        }

        public function delete()
        {   
            if($this->isConnected()) 
            {   // requête de suppression
                $delete = "DELETE FROM players WHERE id = :id ";
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

        public function update($login, $password, $email, $firstname, $lastname)
        {
            if($this->isConnected())
            {
                if ($login != "" && $password != "") 
                {   // mise à jour des variables de session
                    $_SESSION['user']['login'] = $login;
                    $_SESSION['user']['password'] = $password;
                    // vérification de l'existence du login
                    $request = "SELECT * FROM players WHERE login = :login ";
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
                        $update = "UPDATE players SET login = :login, password = :password WHERE id = :id ";
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
            if($this->id != null && $this->login != null) {
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

            }
            else {
                echo "Vous devez être connecté(e) pour voir vos scores !";
            
            }

        }

        public function getLogin()
        {
            if($this->isConnected()) 
            {
                return $this->login;
            }
            else {
                echo "Connectez-vous !";
            }
        }

    }

$user = new Player();
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

//test getEmail PDO //OK
//echo $user->getEmail();

//test getFirstname PDO //OK
//echo $user->getFirstname();

//test getLastname PDO //OK
//echo $user->getLastname();

/* echo "<br>";
echo $user->login;
echo "<br>";
echo $user->email;
echo "<br>";
echo $user->firstname;
echo "<br>";
echo $user->lastname; */


?>