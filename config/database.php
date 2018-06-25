<?php

// for getting the connection of the db created
class Database {
    // database credentials
    private $host = "localhost";
    private $db_name = "php_oop_crud_level_1";
    private $username = "root";
    private $password = "root";

    public $conn;   // PDO obj

    // establish db connection

    public function getConnection(){
        $this->conn = null;
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
        } catch(PDOException $exception){
            echo "Db Connection Error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>