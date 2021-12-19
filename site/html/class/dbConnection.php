<?php

class dbConnection {

    private $file_db;

    private function openConnection(){
        // Set default timezone
        date_default_timezone_set('UTC');


        // Create (connect to) SQLite database in file
        $this->file_db = new PDO('sqlite:/usr/share/nginx/databases/database.sqlite');
        // Set errormode to exceptions
        $this->file_db->setAttribute(PDO::ATTR_ERRMODE,
            PDO::ERRMODE_EXCEPTION);
    }

    private function closeConnection(){
        // Close file db connection
        $this->file_db = null;
    }

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

    public function getUsers(){
        $sqlRequest = "SELECT * FROM User";
        return $this->getSQLRequestAll($sqlRequest);
    }

    public function getUser($username){
        $sqlRequest = "SELECT * FROM User WHERE username = ?";
        $params = [$username];
        return $this->getSQLRequest($sqlRequest, $params);
    }

    public function getUsernames($username){
        $sqlRequest = "SELECT username FROM User WHERE username != ?";
        $params = [$username];
        return $this->getSQLRequestAll($sqlRequest, $params);
    }

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

    public function deleteUser($username){
        $sqlRequest = "DELETE FROM User WHERE username = ?";
        $params = [$username];
        $this->executeSQLRequest($sqlRequest, $params);
    }

    public function editUser($username, $password, $validity, $role){
        $sqlRequest = "UPDATE User SET password = ?, validity = ?, role = ? WHERE username = ?";
        $params = [$password, $validity, $role, $username];
        $this->executeSQLRequest($sqlRequest, $params);
    }

    public function editUserWithoutPassword($username, $validity, $role){
        $sqlRequest = "UPDATE User SET validity = ?, role = ? WHERE username = ?";
        $params = [$validity, $role, $username];
        $this->executeSQLRequest($sqlRequest, $params);
    }
    
    public function editPassword($username, $password){
        $sqlRequest = "UPDATE User SET password = ? WHERE username = ?";
        $params = [$password, $username];
       $this->executeSQLRequest($sqlRequest, $params);
    }

    public function newMessage($username, $date, $to, $subject, $message){
        $sqlRequest = "INSERT INTO Message (date, sender, receiver, subject, message) VALUES (?, ?, ?, ?, ?)";
        $params = [$date, $username, $to, $subject, $message];
        $this->executeSQLRequest($sqlRequest, $params);
    }

    public function getMessages(){
        $sqlRequest = "SELECT * FROM Message ORDER BY date DESC";
        return $this->getSQLRequestAll($sqlRequest);
    }

    public function getMessage($id, $username){
        // Vérification que le message soit bien celui reçu par l'utilisateur
        $sqlRequest = "SELECT * FROM Message WHERE id = ? AND receiver = ?";
        $params = [$id, $username];
        return $this->getSQLRequest($sqlRequest, $params);
    }

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