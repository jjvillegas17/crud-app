<?php   // header

include_once 'config/database.php';
include_once 'objects/product.php';
include_once 'objects/category.php';

$database = new database();
$db = $database->getConnection(); // pdo

// create the objects
$product = new Product($db);
$category = new Category($db);


// item name searched in the URL
$searchItem = isset($_GET['search'])? $_GET['search']: "";
$page_title = "You searched for: " . $searchItem;

//header
include_once("layout_header.php");

?>

<?php
    $id = 0;
    while($_GET[$id]['name']){
        echo $_GET[$id]['name'] . "<br>";
        $id++;
    }

?>

<form action="search_product_submit.php" method='post'>
    <input type='text' placeholder='Enter product name' name='productName' size='60'>
    <input type='submit' value='Search' name='search'>
</form>
