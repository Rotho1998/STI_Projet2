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
    
    public function getUsers(){
        $this->openConnection();
        
        $result = $this->file_db->query('SELECT * FROM User');

        $this->closeConnection();
        
        return $result;
    }

    public function getUser($username){
        $this->openConnection();

        $result = $this->file_db->query("SELECT * FROM User WHERE username = '$username'");

        $this->closeConnection();

        return $result;
    }

    public function getUsernames($username){
        $this->openConnection();

        $result = $this->file_db->query("SELECT username FROM User WHERE username != '$username'");

        $this->closeConnection();

        return $result;
    }

    public function addUser($username, $password, $validity, $role){
        $this->openConnection();

        $this->file_db->exec("INSERT INTO User (username, password, validity, role) VALUES ('$username', '$password', '$validity', '$role')");

        $this->closeConnection();
    }

    public function deleteUser($username){
        $this->openConnection();

        $this->file_db->exec("DELETE FROM User WHERE username = '$username'");

        $this->closeConnection();
    }

    public function editUser($username, $password, $validity, $role){
        $this->openConnection();

        $this->file_db->exec("UPDATE User SET password = '$password', validity = '$validity', role = '$role' WHERE username = '$username'");

        $this->closeConnection();
    }
    
    public function editPassword($username, $password){
        $this->openConnection();

        $this->file_db->exec("UPDATE User SET password = '$password' WHERE username = '$username'");

        $this->closeConnection();
    }

    public function newMessage($username, $date, $to, $subject, $message){
        $this->openConnection();

        $this->file_db->exec("INSERT INTO Message ('date', 'from', 'to', 'subject', 'message') VALUES ('$date', '$username', '$to', '$subject', '$message')");

        $this->closeConnection();
    }

    public function getMessages(){
        $this->openConnection();

        $result = $this->file_db->query("SELECT * FROM Message ORDER BY date DESC");

        $this->closeConnection();

        return $result;
    }

    public function getMessage($id){
        $this->openConnection();

        $result = $this->file_db->query("SELECT * FROM Message WHERE id = '$id'");

        $this->closeConnection();

        return $result;
    }

    public function deleteMessage($id) {
        $this->openConnection();

        $this->file_db->exec("DELETE FROM Message WHERE id = '$id'");

        $this->closeConnection();
    }
}