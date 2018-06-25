<?php   // header

include_once 'config/database.php';
include_once 'objects/product.php';
include_once 'objects/category.php';

$database = new database();
$db = $database->getConnection(); // pdo

// create the objects
$product = new Product($db);
$category = new Category($db);

// page given in URL parameter, default page is one
$page = isset($_GET['page']) ? $_GET['page'] : 1;


//set header
$page_title = "Read products";
include_once("layout_header.php");

?>

<div class="right-button-margin">
    <a href="create_product.php" class="btn btn-default pull-right">Create Product </a>
</div>

<div class="right-button-margin">
    <a href='search_product.php?search=' class="btn btn-default pull-right">Search Product </a>
</div>

    <table class="table table-hover table responsive table-bordered" >
        <tr>
            <th> Product </th>
            <th> Price </th>
            <th> Description </th>
            <th> Category </th>
            <th> Actions </th>
    <?php        
        // set number of records per page
        $records_per_page = 5;

        if($page<=1){
            $page=1;
        }
        $row_num = ($page-1) * $records_per_page;
        $productsArray = $product->getAll($row_num,$records_per_page);
        
        
        foreach($productsArray as $productObj){
            $categoryName = $category->readName($productObj['category_id']);
            echo "<tr>";
                echo "<td>{$productObj['name']}</td>";
                echo "<td>{$productObj['price']}</td>";
                echo "<td>{$productObj['description']}</td>";
                echo "<td>{$categoryName}</td>";
                echo "<td>";
                    // read product button
                    echo "<a href='read_one.php?id={$productObj['id']}' class='btn btn-primary left-margin'>";
                    echo "<span class='glyphicon glyphicon-list'></span> Read";
                    echo "</a>";

                    // edit product button
                    echo "<a href='update_product.php?id={$productObj['id']}' class='btn btn-info left-margin'>";
                    echo "<span class='glyphicon glyphicon-edit'></span> Edit";
                    echo "</a>";

                    // delete product button
                    echo "<form action='delete_product.php?id={$productObj['id']}' method='POST'>";
                    echo "<input type='submit' name='delete' value='Delete' class='btn btn-danger delete-object'>";
                        //echo "<input type='hidden' name='idDelete' value={$productObj['id']}>";
                    echo "</form >";
                echo "</td>";
            echo "</tr>";
            $row_num+=5;            
        }
            
        
        // $productsArray = $product->getAll($startingRow,$records_per_page);
        // foreach($productsArray as $productElement){
        //     $categoryName = $category->readName($productElement['category_id']); // query
        //     echo "product - {$productElement['id']} - {$productElement['name']} - {$productElement['description']} - {$productElement['price']} - {$categoryName} <br>";
        // }
    
    ?>
    </table>

        <!-- paging buttons will be here -->
    <?php
        $page_url = "index.php?";
 
        // count all products in the database to calculate total pages
        $total_rows = $product->getTotalRows();
        // paging buttons here
        include_once 'paging.php';

    ?>

<?php   // foooter
include_once("layout_footer.php");
?>