<?php
session_start();
if(isset($_SESSION["UserType"]))
{
    if ($_SESSION["UserType"] == "admin") {
        header("location: http://localhost/wsneakers/adminPage/adminPage.php");
        exit();
    } else if ($_SESSION["UserType"] == "Seller") {
        header("location: http://localhost/wsneakers/sellerProfile/sellerProfile.php");
        exit();
    }
}
include("./database/db.php");
include("header.html");
include("./customers/customer.php");
include("./customers/customerService.php");
include("./customers/customerRepository.php");

if (isset($_POST["logoutBtn"])) {
    session_destroy();
    header("location: index.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="index.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <table style='width:100%;'>
        <tr>
            <td>
                <h1>Home Page</h1>
            </td>
            <td>
                <div class="h1">
                    <?php
                    if (empty($_SESSION["Username"])) {
                        echo '<a class="login" href="login.php">Login/Sign Up</a>';
                    } else {
                        echo '<a class="login" href="logout.php">Logout</a>';
                    }
                    ?>
                    <a class="profile" href="customerProfile/customerProfile.php">Profile</a>
                    <a class="cart" href="cart/cartPage.php">My Cart 🛒</a>
                </div>
            </td>
        </tr>
    </table>
</head>

<body>
    <div style="text-align: center;">
        <a class="login" style='text-align: center;' href="./products/customerproductpage.php">View all products</a>
    </div>
    <br>
    <div class="scroll-container">
        <div class="scroll-content">
            <?php
            foreach (glob("ProductImages/" . '*') as $filename) {
                echo "<form action='./products/singleproductpage.php' method='POST'>";
                $productID = pathinfo($filename, PATHINFO_FILENAME);
                echo "<input type='hidden' name='product_id' value='$productID'>";
                echo "<button type='submit' class='image'>
                                <img src='$filename' height = '350' />
                            </button>";
                echo "</form>";
            }
            ?>
        </div>
    </div>
</body>

</html>