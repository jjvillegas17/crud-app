<?php

class Category {
    // db connection
    private $conn;
    private $table_name = "categories";

    // obj properties
    public $id;
    public $name;

    // connect the category class to the db whenever instantiated 
    public function __construct($db){
        $this->conn = $db;
    }

    // get id (primary key) and name of category
    public function read(){
        $query = "SELECT id, name FROM " . $this->table_name . " ORDER BY name"; 

        $stmt = $this->conn->prepare($query);
        $isSuccess = $stmt->execute();

        // error handling
        if($isSuccess==false){
            echo "PDO errorcode: " . $stmt->errorCode();
        }
        
        return $stmt;
    }

    public function readName($id){
        $this->id = $id;
        $query = "SELECT name FROM categories WHERE id = ? limit 0,1 ";
        
        $stmt = $this->conn->prepare($query);
        // prepared statements - para makapagexec ng query na may question mark
        // bind param - bind mo ung question mark sa query sa isang var
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
 
        // fetch - get a row from the result of the query
        // $row == assoc array  e.g. (array([name] -> value);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
     
        // get the name by accessing the assoc array
        $this->name = $row['name'];
        return $this->name;
    }

}

?>