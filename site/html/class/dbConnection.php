<?php

class dbConnection {

    private $file_db;

    /**
     * Méthode de connexion à la base de données
     */
    private function openConnection(){
        // Set default timezone
        date_default_timezone_set('UTC');


        // Create (connect to) SQLite database in file
        $this->file_db = new PDO('sqlite:/usr/share/nginx/databases/database.sqlite');
        // Set errormode to exceptions
        $this->file_db->setAttribute(PDO::ATTR_ERRMODE,
            PDO::ERRMODE_EXCEPTION);
    }

    /**
     * Méthode de fermeture de la connexion à la base de données
     */
    private function closeConnection(){
        // Close file db connection
        $this->file_db = null;
    }

    /**
     * Méthode permettant d'obtenir une seule entrée de la base de données
     * @param $strSQLRequest -> requête SQL
     * @param null $params -> paramètres de la requête SQL
     */
    private function getSQLRequest($strSQLRequest, $params = null){
        try {
            $this->openConnection();

            $query = $this->file_db->prepare($strSQLRequest);
            $query->execute($params);
            $response = $query->fetch();

            $query->closeCursor();
            $this->closeConnection();

            return ($response);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    /**
     * Méthode permettant d'obtenir plusieurs entrées de la base de données
     * @param $strSQLRequest -> requête SQL
     * @param null $params -> paramètres de la requête SQL
     */
    private function getSQLRequestAll($strSQLRequest, $params = null){
        try {
            $this->openConnection();

            $query = $this->file_db->prepare($strSQLRequest);
            $query->execute($params);
            $response = $query->fetchAll();

            $query->closeCursor();
            $this->closeConnection();

            return ($response);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    /**
     * Méthode permettant d'exécuter des actions dans la base de données
     * @param $strSQLRequest -> requête SQL
     * @param null $params -> paramètres de la requête SQL
     */
    private function executeSQLRequest($strSQLRequest, $params = null){
        try {
            $this->openConnection();

            $query = $this->file_db->prepare($strSQLRequest);
            $query->execute($params);

            $query->closeCursor();
            $this->closeConnection();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    /**
     * Méthode permettant d'obtenir tous les utilisateurs
     */
    public function getUsers(){
        $sqlRequest = "SELECT * FROM User ORDER BY username";
        return $this->getSQLRequestAll($sqlRequest);
    }

    /**
     * Méthode permettant d'obtenir un seul utilisateur
     * @param $username -> nom de l'utilisateur
     */
    public function getUser($username){
        $sqlRequest = "SELECT * FROM User WHERE username = ?";
        $params = [$username];
        return $this->getSQLRequest($sqlRequest, $params);
    }

    /**
     * Méthode permettant d'obtenir tous les noms d'utilisateurs
     * @param $username -> nom de l'utilisateur à exclure
     */
    public function getUsernames($username){
        $sqlRequest = "SELECT username FROM User WHERE username != ?";
        $params = [$username];
        return $this->getSQLRequestAll($sqlRequest, $params);
    }

    /**
     * Méthode permettant d'ajouter un utilisateur
     * @param $username -> nom de l'utilisateur à ajouter
     * @param $password -> mot de passe de l'utilisateur à ajouter
     * @param $validity -> validité de l'utilisateur à ajouter
     * @param $role -> role de l'utilisateur à ajouter
     * @return bool -> si l'utilisateur est déjà existant
     */
    public function addUser($username, $password, $validity, $role){
        $sqlRequest = "SELECT username FROM User WHERE username == ?";
        $params = [$username];
        // Test si l'utilisateur existe déjà
        $user = $this->getSQLRequest($sqlRequest, $params);
        if($user['username'] == $username){
            return true;
        }

        $sqlRequest = "INSERT INTO User (username, password, validity, role) VALUES (?, ?, ?, ?)";
        $params = [$username, $password, $validity, $role];
        $this->executeSQLRequest($sqlRequest, $params);
        return false;
    }

    /**
     * Méthode de suppression d'un utilisateur
     * @param $username -> nom de l'utilisateur à supprimer
     */
    public function deleteUser($username){
        $sqlRequest = "DELETE FROM User WHERE username = ?";
        $params = [$username];
        $this->executeSQLRequest($sqlRequest, $params);
    }

    /**
     * Méthode permettant de mettre à jour les informations d'un utilisateur
     * @param $username -> nom de l'utilisateur à modifier
     * @param $password -> mot de passe de l'utilisateur à modifier
     * @param $validity -> validité de l'utilisateur à modifier
     * @param $role -> role de l'utilisateur à modifier
     */
    public function editUser($username, $password, $validity, $role){
        $sqlRequest = "UPDATE User SET password = ?, validity = ?, role = ? WHERE username = ?";
        $params = [$password, $validity, $role, $username];
        $this->executeSQLRequest($sqlRequest, $params);
    }

    /**
     * Méthode permettant de mettre à jour les informations d'un utilisateur (sans modifier le mot de passe)
     * @param $username -> nom de l'utilisateur à modifier
     * @param $validity -> validité de l'utilisateur à modifier
     * @param $role -> role de l'utilisateur à modifier
     */
    public function editUserWithoutPassword($username, $validity, $role){
        $sqlRequest = "UPDATE User SET validity = ?, role = ? WHERE username = ?";
        $params = [$validity, $role, $username];
        $this->executeSQLRequest($sqlRequest, $params);
    }

    /**
     * Méthode de modification de mot de passe d'un utilisateur
     * @param $username -> nom de l'utilisateur à editer le mot de passe
     * @param $password -> nouveau mot de passe
     */
    public function editPassword($username, $password){
        $sqlRequest = "UPDATE User SET password = ? WHERE username = ?";
        $params = [$password, $username];
       $this->executeSQLRequest($sqlRequest, $params);
    }

    /**
     * Méthode de création d'un message
     * @param $username -> nom de l'envoyeur
     * @param $date -> date du message
     * @param $to -> nom de récepteur
     * @param $subject -> sujet du message
     * @param $message -> contenu du message
     * @return bool -> si l'utilisateur n'existe pas
     */
    public function newMessage($username, $date, $to, $subject, $message){
        // Vérification que l'utilisateur existe
        $user = $this->getUser($to);
        if ($user['username'] == "") {
            return true;
        }

        $sqlRequest = "INSERT INTO Message (date, sender, receiver, subject, message) VALUES (?, ?, ?, ?, ?)";
        $params = [$date, $username, $to, $subject, $message];
        $this->executeSQLRequest($sqlRequest, $params);
        return false;
    }

    /**
     * Méthode de récupération de tous les messages
     */
    public function getMessages(){
        $sqlRequest = "SELECT * FROM Message ORDER BY date DESC";
        return $this->getSQLRequestAll($sqlRequest);
    }

    /**
     * Méthode de récupération d'un message
     * @param $id -> id du message à récupérer
     * @param $username -> nom de receveur du message
     */
    public function getMessage($id, $username){
        // Vérification que le message soit bien celui reçu par l'utilisateur
        $sqlRequest = "SELECT * FROM Message WHERE id = ? AND receiver = ?";
        $params = [$id, $username];
        return $this->getSQLRequest($sqlRequest, $params);
    }

    /**
     * Méthode de suppression d'un message
     * @param $id -> id du message à supprimer
     * @param $username -> nom d'utilisateur du recevant du message
     * @return bool -> si l'utilisateur est bien celui qui a reçu le message
     */
    public function deleteMessage($id, $username) {
        $sqlRequest = "SELECT id FROM Message WHERE id = ? AND receiver = ?";
        $params = [$id, $username];
        // Test si le message existe et si il appartient à l'utilisateur qui le supprime
        $message = $this->getSQLRequest($sqlRequest, $params);
        if($message['id'] == ""){
            return true;
        }

        $sqlRequest = "DELETE FROM Message WHERE id = ?";
        $params = [$id];
        $this->executeSQLRequest($sqlRequest, $params);
        return false;
    }
}