<?php
    include_once("config/database.php");
    include_once("objects/product.php");

    // db connection
    $database = new Database;
    $db = $database->getConnection();

    $product = new Product($db);
    
    //get the total number of rows
    $totalRows = $product->getTotalRows();

    //specify how many rows per page
    $rowsPerPage = 5;

    //compute how many pages will there be
    $totalPages = ceil($totalRows/$rowsPerPage);
    //get the current page number

    $pageNum = isset($_GET['page']) ? $_GET['page'] : 1;
    
/* 
    // first page button
    // if($page > 1){
    //     echo "<li>";
    //         echo "<a href='http://$_SERVER[HTTP_HOST]/php-oop-crud-level-1/index.php?page=1' title='Go to the first page'> FIRST </a>";
    //     echo "</li>";
    // }
*/

//create the li's per page and specify the href for each
    // numbered page buttons
    for($i = 1; $i < $totalPages+1; $i++){
        $actual_link = "http://$_SERVER[HTTP_HOST]/php-oop-crud-level-1/index.php?page=$i";
        echo "<li class='active'>";
            if($pageNum == $i){
                echo "<a href='$actual_link'><span class=\"sr-only\">(current)</span>$i</a>";
            }
            else{
                echo "<a href='$actual_link'>$i</a>";
            }
        echo "</li>";
    }

/*
    // last page button
    // if($page < $totalPages){
    //     echo "<li>";
    //         echo "<a href='http://$_SERVER[HTTP_HOST]/php-oop-crud-level-1/index.php?page=$totalPages'> LAST </a>";
    //     echo "</li>";
    // }
*/




?>