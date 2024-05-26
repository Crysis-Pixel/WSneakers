<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="couponstyles.css">
    <title>Document</title>
</head>
<body>
        <?php
            session_start();
            include("../sellers/sellerSessionAccess.php");
            include ("../header.html");
            include("../database/db.php"); //had to include directory like this else it was not working
            include("couponRepo.php");
            $coupon = CouponRepo::getInstance();

            if (isset($_POST["edit"])){
                if (!empty($_POST['coupon_id']) && !empty($_POST['couponname']) && !empty($_POST['discount'])){
                    if (!$coupon->UpdateCoupon($_POST['coupon_id'],$_POST['couponname'], $_POST['discount'])){
                        echo "Failed to edit coupon.";
                    }
                }
            }

            if (isset($_POST["delete"])){
                if (!empty($_POST['coupon_id'])){
                    if (!$coupon->DeleteCoupon($_POST['coupon_id'])){
                        echo "Failed to delete coupon.";
                    }
                }
            }

            if (isset($_POST["add"])){
                if (!empty($_POST['newcoupon']) && !empty($_POST['newcoupondiscount'])){
                    if (!$coupon->AddCoupon($_POST['newcoupon'],$_POST['newcoupondiscount'])){
                        echo "Failed to add coupon.";
                    }
                }
            }
        ?>

    <table style='border: none;'><tr>
    <td style='border: none;'><form action="../sellerProfile/sellerProfile.php" method="post">
        <button class='Button' type='submit' style = 'padding:1%;width:10%;'>Go Back</button>
    </form></td>
    </tr></table>

        <?php
            $result = $coupon->getCoupons($_SESSION["SellerUsername"]);
        
            if ($result){
                
                echo "<h2>Coupon List</h2>";

                echo "<table>
                <tr>
                    <th>Coupon Code</th>
                    <th>Percentage Discount</th>
                    <th></th>
                </tr>";
                
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<form action='couponPage.php' method='post'>";
                    echo "<td><input type='text' name='couponname' value='".$row["Name"]."'></td>";
                    echo "<td><input type='number' name='discount' value='".$row["Percentage_Discount"]."'>%</td>";
                    echo "<td>
                        <input type='hidden' name='coupon_id' value='{$row["CouponID"]}'>
                        <button class='Button' type='submit' name='edit' style='padding: 0px;'>Edit coupon</button>
                        <button class='Button' type='submit' name='delete' style='padding: 0px;'>Delete coupon</button>
                        </td>";
                    echo "</tr>";  
                }
                echo "</table><br><br>";
                echo "Enter new coupon: <input type='text' name='newcoupon'>";
                echo "  Enter new percentage discount: <input type='text' name='newcoupondiscount'>";
                echo "<button class='Button' type='submit' name='add' style='padding:1%;width:10%;'>Add coupon</button>";
                echo "</form>";
            }
            else{
                echo "<h2>No category available.</h2>";
            }
        ?>
</body>
</html>

