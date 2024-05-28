<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="../products/productstyles.css">
</head>

<body>
    <?php
    include("../database/db.php");
    include("../header.html");
    include("../brand/brandService.php");
    include("../category/categoryService.php");
    include("../reviews/reviewsService.php");
    include("../products/productService.php");
    include("../cart/cart.php");
    include("../cart/cartRepository.php");
    include("../cart/cartService.php");
    include("../report/report.php");

    if (!empty($_POST["product_id"])) {
        $productID = $_POST["product_id"];
    } else {
        header("location: customerproductpage.php");
        exit();
    }

    $mainImageDIR = "../ProductImages/";
    $p = new ProductService();
    $b = new BrandService();
    $c = new CategoryService();
    $r = new ReviewsService();
    $prod = $p->GetProduct($productID)->fetch_assoc();

    if (isset($_POST['ReviewSave'])){
        include_once("../customers/customerSessionAccess.php");
        $review = new Reviews($_POST["Review"],$_POST["product_id"],$_SESSION["CustomerID"]);
        if (isset($_POST["Exists"]) && $_POST["Exists"]==='1'){
            $r->UpdateReview($review, $_POST["ReviewID"]);
        }
        else{
            $r->Insert($review);
        }
    }

    if (isset($_POST["Add_to_Cart"])) {
        include_once("../customers/customerSessionAccess.php");
        $quantity = $_POST["cart_quantity"];
        $productID = $_POST["product_id"];
        CartService::getInstance()->AddCart($productID, $quantity);
    }
    ?>
    <div class="cartDiv">
        <a class="cart" href="../cart/cartPage.php">My Cart 🛒</a>
    </div>
    <table>
        <tr>
            <td>
                <form action="../customerProfile/customerProfile.php">
                    <input class='Button' type='submit' name='GoBack' value='Go Back' style='font-size: 35px;'>
                </form>
            </td>
        </tr>
        <tr>
            <td>
                <style>
                    .no-border table,
                    .no-border tr,
                    .no-border td {
                        border: none;
                    }
                </style>
                <table class='no-border'>
                    <tr>
                        <?php
                        $image = $mainImageDIR . $prod["Image"];
                        echo '<td><img src="' . $image . '" height="250"/><br /></td>';
                        echo '<td><br><b>' . $prod["ProductName"] . '</b><br><br>';
                        echo $prod["ProductDesc"] . '<br><br>';
                        ?>
                        Price:
                        <?php
                        echo $prod["Price"] . ' tk<br><br>';
                        ?>
            </td>
        </tr>
        <tr>
            <td colspan="2">
            <h3>Write your review</h3>
            <?php
                $r = new ReviewsService();
                $review = $r->Search($_SESSION["Username"], $prod["ProductName"]);
                $row = $review->fetch_assoc();
                $reviewexists = true;
                if (mysqli_num_rows($review)==0){
                    $reviewexists = false;
                    $reviewtext="";
                }
                else $reviewtext=$row["Text"];
            ?>
            <form action='reviewpage.php' method='post'>
                <textarea name="Review" rows="4" cols="50"><?php echo $reviewtext; ?></textarea>
                <br><br>
                <td><input type='hidden' name='product_id' value=<?php echo $productID ?>>
                <?php
                    if ($reviewexists){
                        echo "<input type='hidden' name='Exists' value='".$reviewexists."'>";
                        echo "<input type='hidden' name='ReviewID' value='".$row["ReviewID"]."'>";
                    }
                ?>
                <button class="Button" name="ReviewSave">Save Review</button>
            </form>
            </td>
        </tr>
    </table>

</body>

</html>