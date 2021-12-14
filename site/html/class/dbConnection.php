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

    private function getSQLRequest($strSQLRequest){
        try {
            $this->openConnection();

            $query = $this->file_db->prepare($strSQLRequest);
            $query->execute();
            $response = $query->fetch();

            $query->closeCursor();
            $this->closeConnection();

            return ($response);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    private function getSQLRequestAll($strSQLRequest){
        try {
            $this->openConnection();

            $query = $this->file_db->prepare($strSQLRequest);
            $query->execute();
            $response = $query->fetchAll();

            $query->closeCursor();
            $this->closeConnection();

            return ($response);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    private function executeSQLRequest($strSQLRequest){
        try {
            $this->openConnection();

            $query = $this->file_db->prepare($strSQLRequest);
            $query->execute();

            $query->closeCursor();
            $this->closeConnection();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getUsers(){
        return $this->getSQLRequestAll('SELECT * FROM User');
    }

    public function getUser($username){
        return $this->getSQLRequest("SELECT * FROM User WHERE username = '$username'");
    }

    public function getUsernames($username){
        return $this->getSQLRequestAll("SELECT username FROM User WHERE username != '$username'");
    }

    public function addUser($username, $password, $validity, $role){
        $this->executeSQLRequest("INSERT INTO User (username, password, validity, role) VALUES ('$username', '$password', '$validity', '$role')");
    }

    public function deleteUser($username){
        $this->executeSQLRequest("DELETE FROM User WHERE username = '$username'");
    }

    public function editUser($username, $password, $validity, $role){
        $this->executeSQLRequest("UPDATE User SET password = '$password', validity = '$validity', role = '$role' WHERE username = '$username'");
    }
    
    public function editPassword($username, $password){
       $this->executeSQLRequest("UPDATE User SET password = '$password' WHERE username = '$username'");
    }

    public function newMessage($username, $date, $to, $subject, $message){
        $this->executeSQLRequest("INSERT INTO Message ('date', 'from', 'to', 'subject', 'message') VALUES ('$date', '$username', '$to', '$subject', '$message')");
    }

    public function getMessages(){
        return $this->getSQLRequestAll("SELECT * FROM Message ORDER BY date DESC");
    }

    public function getMessage($id){
        return $this->getSQLRequest("SELECT * FROM Message WHERE id = '$id'");
    }

    public function deleteMessage($id) {
        $this->executeSQLRequest("DELETE FROM Message WHERE id = '$id'");
    }
}