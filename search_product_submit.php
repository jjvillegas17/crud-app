<?php

include_once 'config/database.php';
include_once 'objects/product.php';

$database = new database();
$db = $database->getConnection(); // pdo

// create the objects
$product = new Product($db);

$product->name = $_POST['productName'];

echo $product->name . "<br>";

$products = $product->searchProductByName();

foreach($products as $aProduct){
    echo $aProduct['name'] . "<br>";
}

$productsUrl = http_build_query($products,$output);
parse_str($productsUrl, $searchResult);

// $myArray = array(  
//     "car"=>array("ford", "vauxhall", "dodge"),  
//     "animal"=>"elephant",  
//     "language"=>"php"  
// ); 

// echo "<br> myArray: " . http_build_query($myArray) . "<br>";
print_r("<br> productsURL: $productsUrl <br><br>");

// $output1 = array();
// parse_str(http_build_query($myArray),$output1);
// echo "<br> output1: " . print_r($output1);
// echo "array: " . $output1['animal'] . "<br>";

$url = "search_product.php?" . http_build_query($products);


echo "<br> output: ";
print_r($searchResult);

header("Location:$url" . "search=$product->name");
?>
