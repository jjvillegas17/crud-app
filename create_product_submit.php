<?php 
include_once 'config/database.php';
include_once 'objects/product.php';

// if the form was submitted - PHP OOP CRUD Tutorial
if(isset($_POST['submit'])){
    // get database connection
    $database = new Database();
    $db = $database->getConnection();
 
    // pass connection to objects
    $product = new Product($db);

    if($_POST['name'] == "" || $_POST['price'] == "" || $_POST['description'] == "" || $_POST['category_id'] == "Select category..."){    
        header("Location:create_product.php");
        exit();
    }

    var_dump((int)$_POST['category_id']);
    var_dump($isInt);

    // set product property values
    $product->name = $_POST['name'];
    $product->price = $_POST['price'];
    $product->description = $_POST['description'];
    $product->category_id = $_POST['category_id'];
 
    // create the product
    $product->create();

    header("Location:create_product.php");
}
?>