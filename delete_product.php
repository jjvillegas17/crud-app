<?php

include_once("config/database.php");
include_once("objects/product.php");

$database = new Database;
$db = $database->getConnection();

$product = new Product($db);

$productId = $_GET['id'];

echo $productId;
$product->id = $productId;
$product->deleteProductById();

header("Location:index.php");

?>