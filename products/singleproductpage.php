<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="productstyles.css">
    <title>Document</title>
</head>
<body>
    <?php
        include("../cart/cartService.php");
        if (!empty($_POST["product_id"])){
            $productID = $_POST["product_id"];
        }
        else{
            header("location: customerproductpage.php");
            exit();
        }

        if (isset($_POST["Add_to_Cart"])){
            $Quantity=$_POST["cart_quantity"];
            $productID=$_POST["product_id"];
            //CartService::getInstance()->AddCart()
        }
        include ("../header.html");
        include("../database/db.php");
        include("../products/productService.php");
        include("../brand/brandService.php");
        include("../category/categoryService.php");
        $mainImageDIR = "../ProductImages/";
        $p = new ProductService();
        $b = new BrandService();
        $c = new CategoryService();
        $prod = $p->GetProduct($productID)->fetch_assoc();
    ?>
    <table>
        <tr><td>
        <form action="customerproductpage.php">
        <input class='Button' type='submit' name='GoBack' value='Go Back' style='font-size: 35px;'>
        </form>
        </td></tr>
        <tr><td>
            <style>
            .no-border table,
            .no-border tr,
            .no-border td {
                border: none;
            }
            </style>
            <table class='no-border'><tr>
            <?php
                $image = $mainImageDIR.$prod["Image"];
                echo '<td><img src="'.$image.'" height="250"/><br /></td>';
                echo '<td><br>'.$prod["ProductName"].'<br><br>';
                echo $prod["ProductDesc"].'<br><br>';
            ?>
            Price: 
            <?php
                echo $prod["Price"].' tk<br><br>';
            ?>
            Quantity available: 
            <?php
                echo $prod["Quantity"].'<br><br>';
            ?>
        </td></tr>
        <tr><td>
            <form action='singleproductpage.php' method='post'>
                <input class='Button' style='padding-right:10px;padding-left:10px;' type='submit' name='Add_to_Cart' value='Add to Cart' style='font-size: 35px;'></td>
                <?php
                    echo "<td><input type='hidden' name='product_id' value='{$productID}'>";
                ?>
                Quantity: <input type='number' name='cart_quantity' value='1'>
            </form>
        </td></tr>
    </table>
</body>
</html>