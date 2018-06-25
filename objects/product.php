<?php
class Product{
 
    // database connection and table name
    private $conn;
    private $table_name = "products";
 
    // object properties
    public $id;
    public $name;
    public $price;
    public $description;
    public $category_id;
    public $timestamp;
 
    public function __construct($db){
        $this->conn = $db;
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
 
    // create product
    function create(){
        $query = "INSERT INTO products (name,price,description,category_id,created) VALUES (:name, :price, :description, :category_id, :created)";
        $stmt = $this->conn->prepare($query);

        // posted values
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->price=htmlspecialchars(strip_tags($this->price));
        $this->description=htmlspecialchars(strip_tags($this->description));
        $this->category_id=htmlspecialchars(strip_tags($this->category_id));

        $this->timestamp = date('Y-m-d H:i:s');

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":category_id", $this->category_id);
        $stmt->bindParam(":created", $this->timestamp);

        if($stmt->execute()){
            return true;
        } else {
            return false;
        }
    }

    function getAll($startingRow, $rowsPerPage){
        try{
            $query = "SELECT id,name,description,price,category_id from products limit :startingRow , :rowsPerPage";
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //$this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":startingRow", $startingRow, PDO::PARAM_INT);
            $stmt->bindParam(":rowsPerPage", $rowsPerPage, PDO::PARAM_INT);
            

            $stmt->execute();
            $array = $stmt->fetchAll();
            return $array;
        } catch (PDOException $e){
            echo $e->getMessage();
        } 
    }

    // used for paging products
    public function getTotalRows(){
        $query = "SELECT id from products";
        $stmt = $this->conn->prepare($query);

        $stmt->execute();
        $array = $stmt->fetchAll();
        return count($array);
    }

    //
    public function getProductByID(){
        $query = "SELECT name, price, description, category_id from products where id=:id";
        $stmt = $this->conn->prepare($query);
    
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();

        $array = $stmt->fetch(PDO::FETCH_ASSOC);

        return $array;
    }
/*  
    UPDATE THIS:: --- cannot be done since products table has no foreign key to 
    the name primary key of category

    public function getProductCategoryName(){
        try{
            $query = "SELECT category.name FROM categories where category.id=:id";
            $stmt = $this->conn->prepare($query);
        
            $stmt->bindParam(":id", $this->id, PDO::PARAM_INT);
            $stmt->execute();

            $array = $stmt->fetch(PDO::FETCH_ASSOC);
            $categoryName = $array['category.name'];
            echo "categoryName = $categoryName";
            return $categoryName;
            
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
  
*/
    public function updateProductByID(){
        try{
            $query="UPDATE PRODUCTS SET name=:name,price=:price,description=:description,category_id=:category_id WHERE id=:id";
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(":id",$this->id, PDO::PARAM_INT);
            $stmt->bindParam(":name",$this->name);
            $stmt->bindParam(":price",$this->price, PDO::PARAM_INT);
            $stmt->bindParam(":description",$this->description);
            $stmt->bindParam(":category_id",$this->category_id, PDO::PARAM_INT);

            $stmt->execute();

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        
    }

    public function deleteProductById(){
        try{
            $query = "DELETE FROM products WHERE id=:id";
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(":id", $this->id);

            $stmt->execute();

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function searchProductByName(){
        try{
            $query = "SELECT name from products WHERE name LIKE :name";
            $stmt = $this->conn->prepare($query);

            $name = "%$this->name%";
            $stmt->bindParam(":name", $name);

            $stmt->execute();
            $array = $stmt->fetchAll();

            return $array;

        } catch (PDOException $e) {
            echo $e->getMessage();
        } 
    }


}

// include_once("../config/database.php");

// $database = new Database;
// $db = $database->getConnection();

// $product = new Product($db);
// $product->getTotalRows();

?>