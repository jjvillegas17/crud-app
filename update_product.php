<?php
$page_title = "Update Product";
include_once("layout_header.php");
?>

<?php
    $productId = $_GET['id'];
    //echo $productId;
 
    include_once("config/database.php");
    include_once("objects/product.php");
    include_once("objects/category.php");

    $database = new Database;
    $db = $database->getConnection();

    $product = new Product($db);
    $category = new Category($db);

    // fetch all the info of the product id
    $product->id = $productId;
    $productInfo = $product->getProductById($productId);
    $product->name = $productInfo['name'];
    $product->price = $productInfo['price'];
    $product->description = $productInfo['description'];
    $product->category_id = $productInfo['category_id'];
    $productCategoryName = $category->readName($product->category_id);
?>

<form action="update_product_submit.php" method="post">
    <table class='table table-hover table-responsive table-bordered'>
 
        <tr>
            <td>Name</td>
            <td><input type='text' name='name' value='<?php echo $product->name; ?>' class='form-control' /></td>
                <input type='hidden' name='id' value='<?php echo $product->id; ?>'/>
        </tr>
 
        <tr>
            <td>Price</td>
            <td><input type='text' name='price' value='<?php echo $product->price; ?>' class='form-control' /></td>
        </tr>
 
        <tr>
            <td>Description</td>
            <td><textarea name='description' class='form-control'><?php echo $product->description; ?></textarea></td>
        </tr>
 
        <tr>
            <td>Category</td>
            <td>
                <!-- categories select drop-down will be here -->
                <select name='category_id'>
                    <?php
                        $categories = $category->read()->fetchAll();
                            echo "<option value='none'> Select category... </option>";
                        foreach($categories as $category){
                            if($category['name']==$productCategoryName){
                                echo "<option selected='selected' value='{$category['id']}'>{$category['name']} </option>";    
                            } else{
                                echo "<option value='{$category['id']}'>{$category['name']} </option>";
                            }
                        }
                    ?>
                </select>
            </td>
        </tr>
 
        <tr>
            <td></td>
            <td>
                <input type="submit" value="Update" name="submit" class="btn btn-primary">
            </td>
        </tr>
 
    </table>
</form>

<?php
include_once("layout_footer.php");
?>