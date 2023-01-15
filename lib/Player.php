<?php require_once 'autoloader.php'; ?>

<?php

class Player
{
    // attributs
    public $id;
    public $login;
    private $password;
    public $level;
    public $score;
    private $db;

    // constructor
    public function __construct($db) 
    {
        $this->db = $db;
        if (isset($_SESSION['login'])) {
            $this->login = $_SESSION['login']['login'];
            $this->id = $_SESSION['login']['id'];
        }
    } 
    public function register($login, $password)
    {
        // Valider les données
        if ($login != "" && $password != "") {
            // Vérifier si le login existe déjà
            $request = "SELECT * FROM players WHERE login = :login ";
            // Préparer la requête SQL
            $select = $this->db->getPdo()->prepare($request);
            // Exécuter la requête avec le binding des paramètres
            $select->execute(array(':login' => $login));
            // Récupérer le résultat
            $fetch = $select->fetchAll();
            $row = count($fetch);
            
            // Hasher le mot de passe
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Si le login n'existe pas, on peut l'enregistrer
            if ($row == 0) {
                $register = "INSERT INTO players (login, password) VALUES (:login, :password)";
                // Préparer la requête SQL
                $insert = $this->db->getPdo()->prepare($register);
                // Executer la requête avec le binding des paramètres
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
        // Vérifier si les champs formulaire ont bien été remplis
        if ($login != "" && $password != "") {
            // Récupérer le mot de passe hashé dans la bdd
            $request = "SELECT password FROM players WHERE login = :login";
            // Préparer la requête SQL
            $select = $this->db->getPdo()->prepare($request);
            // Exécuter la requête avec le binding des paramètres
            $select->execute(array(':login' => $login));
            // Récupérer le résultat
            $result = $select->fetch();
            // Récupérer le mot de passe hashé
            $hashed_password = $result['password'];
            
            // Verifier si le mot de passe est correct
            if (password_verify($password, $hashed_password)) {
                // Le mot de passe est correct, on peut créer la session
                $request = "SELECT * FROM players WHERE login = :login";
                // Préparer la requête SQL
                $select = $this->db->getPdo()->prepare($request);
                // Exécuter la requête avec le binding des paramètres
                $select->execute(array(':login' => $login));
                $result = $select->fetch();
                // Créer la session
                $_SESSION['login'] = [
                    'id' => $result['id'],
                    'login' => $login,
                ];
                header('Location: profile.php');
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
                $this->login= null;
                session_unset();
                session_destroy();
            }
            else {
                echo "Vous n'êtes pas connecté(e) !";
            }
    }
    public function delete()
    {
        if ($this->isConnected()) {
            // Effacer les scores du joueur
            $stmt = $this->db->getPdo()->prepare("DELETE FROM player_score WHERE player_id = :player_id");
            $stmt->execute(['player_id' => $this->id]);
    
            // Effacer les scores du joueur du classement global
            $stmt = $this->db->getPdo()->prepare("DELETE FROM global_score WHERE player_id = :player_id");
            $stmt->execute(['player_id' => $this->id]);
    
            // Effacer le joueur
            $stmt = $this->db->getPdo()->prepare("DELETE FROM players WHERE id = :id");
            $stmt->execute(['id' => $this->id]);
            // fermeture de la connexion
            session_destroy();
            echo "Utilisateur supprime !";
        } else {
            echo "Vous devez etre connecte pour supprimer votre compte !";
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
        if($this->login != null){
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
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th><?php echo $this->id; ?></td>
                        <td><?php echo $this->login; ?></td>
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
            return $this->login;
        }
        else {
            echo "Vous devez être connecté(e) pour voir vos informations !";
        }
    }
    public function getId()
    {
        return $this->id;
    }
    public function saveScore($level, $coups)
    {
        //Enregistrement du score dans la table player_score
        $stmt = $this->db->getPdo()->prepare("INSERT INTO player_score (player_id, level, coups) VALUES (?, ?, ?)");
        //Exécution de la requête
        $stmt->execute([$this->id, $level, $coups]);
    }
    public function getScore($level)
    {
        //Récupération des scores du joueur
        $stmt = $this->db->getPdo()->prepare("SELECT * FROM player_score WHERE player_id = :player_id AND level = :level ORDER BY coups DESC");
        //Exécution de la requête
        $stmt->execute (array(
            ':player_id' => $this->id,
            ':level' => $level
        ));
        $fetchall = $stmt->fetchAll(PDO::FETCH_ASSOC);

        //Affichage du score
        ?>
        <table class="scoreProfile">
            <thead>
                <tr>
                    <th>Paires</th>
                    <th>Score</th>
                    <th>Coups</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($fetchall as $row) {
                    $score = $row['level'] / $row['coups'];
                    ?>
                    <tr>
                        <td><?php echo $row['level']; ?></td>
                        <td><?php echo $score; ?></td>
                        <td><?php echo $row['coups']; ?></td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
        <?php
    }
    public function getGlobalScore()
    {
        // Requête pour récupérer le score global
        $stmt = $this->db->getPdo()->prepare("SELECT * FROM player_score INNER JOIN players ON player_score.player_id = players.id WHERE level = :level ORDER BY coups limit 10");
        // Exécution de la requête
        $stmt->execute(array(':level' => $_GET['level']));
        // Récupération des résultats avec fetch
        $score = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // Affichage du score
        ?>
        <table>
            <thead>
                <tr>
                    <th>Login</th>
                    <th>Score</th>
                    <th>Paires</th>
                    <th>Coups</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($score as $row) {
                    $score = $row['level'] / $row['coups'];
                    ?>
                    <tr>
                        <td><?php echo $row['login']; ?></td>
                        <td><?php echo $score; ?></td>
                        <td><?php echo $row['level']; ?></td>
                        <td><?php echo $row['coups']; ?></td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
        <?php
    }
}