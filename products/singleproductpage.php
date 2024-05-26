<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="productstyles.css">
</head>
<body>
    <?php
        include("../database/db.php");
        include ("../header.html");
        include("../brand/brandService.php");
        include("../category/categoryService.php");
        include("../reviews/reviewsService.php");
        include("../products/productService.php");
        include("../cart/cart.php");
        include("../cart/cartRepository.php");
        include("../cart/cartService.php");
        if (!empty($_POST["product_id"])){
            $productID = $_POST["product_id"];
        }
        else{
            header("location: customerproductpage.php");
            exit();
        }
        
        if (isset($_POST["Add_to_Cart"])){
            $quantity=$_POST["cart_quantity"];
            $productID=$_POST["product_id"];
            CartService::getInstance()->AddCart($productID, $quantity);
        }
        $mainImageDIR = "../ProductImages/";
        $p = new ProductService();
        $b = new BrandService();
        $c = new CategoryService();
        $r = new ReviewsService();
        $prod = $p->GetProduct($productID)->fetch_assoc();
    ?>
    <div class="cartDiv">
        <a class="cart" href="../cart/cartPage.php">My Cart 🛒</a>
    </div>
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
        <tr><td style='text-align:left;'>
            <br>
            <h3>Reviews</h3>
            <table>
                <tr>
                    <td style='text-align:left;'>
                        <?php
                            $reviewresult = $r->Search('',$prod["ProductName"]);
                            while ($row = $reviewresult->fetch_assoc()){
                                echo "<u>".$row["Username"]."</u><br>";
                                echo $row["Text"]."<br><br><br>";
                            }
                        ?>
                    </td>
                </tr>
            </table>
        </td></tr>
        <tr><td>
            <form action='singleproductpage.php' method='post'>
                <input class='Button' style='padding-right:10px;padding-left:10px;' type='submit' name='Add_to_Cart' value='Add to Cart' style='font-size: 35px;'></td>
                <?php
                    echo "<td><input type='hidden' name='product_id' value='{$productID}'>";
                ?>
                Quantity: <input type='number' name='cart_quantity' min="0" value='1'>
            </form>
        </td></tr>
    </table>
    
</body>
</html>