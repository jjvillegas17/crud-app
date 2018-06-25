<?php
include_once("config/database.php");
include_once("objects/product.php");

if(isset($_POST['submit'])){
   // get database connection
   $database = new Database();
   $db = $database->getConnection();

   // pass connection to objects
   $product = new Product($db);
   $product->id = $_POST['id'];
   $product->name = $_POST['name'];
   $product->price = $_POST['price'];
   $product->description = $_POST['description'];
   $product->category_id = $_POST['category_id'];

   if($_POST['name'] == "" || $_POST['price'] == "" || $_POST['description'] == "" || $_POST['category_id'] == "none"){    
       header("Location:http://localhost:8888/php-oop-crud-level-1/update_product.php?id={$_POST['id']}");
       exit();
   }
   else{   //updated successfully
       $product->updateProductById();
       header("Location:index.php");
       exit();
   }
}
?>