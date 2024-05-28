<?php
session_start();
include("adminSessionAccess.php");
include("../database/db.php");
include("../reviews/reviewsService.php");
$rs = new ReviewsService();

if(isset($_POST["EditReview"])){
    $review = new Reviews($_POST["Text"], $_POST["product_id"], $_POST["customer_id"]);
    $rs->UpdateReview($review, $_POST["ReviewID"]);
}

if(isset($_POST["DeleteReview"])){
    $rs->DeleteReview($_POST["ReviewID"]);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./customerTable.css">
    <a class="admin" href="./adminPage.html">Admin</a>
    <br><br>
</head>

<body>
    <form action='adminPage.php'>
        <button class="Button" type="submit">Go back</button>
    </form>
    <form action="adminReviews.php" method="post">
        <h3>Search by:</h3>
        Username:<input type="text" id="search" name="query1" placeholder="Enter search term">
        Product Name:<input type="text" id="search" name="query2" placeholder="Enter search term">
        <button class='Button' type='submit' name="Search">Search</button>
    </form>
    
    <table>

        <caption>Review List</caption>
        
        <thead>
            <tr>
                <th>ReviewID</th>
                <th>Review</th>
                <th>Product</th>
                <th>Customer</th>
                <th>Action</th>
            </tr>
        </thead>
        <?php

        $Usernamesearch = "";
        $ProductNamesearch = "";
        if (!empty($_POST["query1"])) $Usernamesearch = $_POST["query1"];
        if (!empty($_POST["query2"])) $ProductNamesearch = $_POST["query2"];

        $result = $rs->Search($Usernamesearch,$ProductNamesearch);

        if (mysqli_num_rows($result)>0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tbody>";
                echo "<tr>";
                echo "<th>" . $row['ReviewID'] . "</th>";
                echo "<td><form action='adminReviews.php' method='post'>
                        <input type='hidden' name='ReviewID' value='{$row["ReviewID"]}'>
                        <input type='hidden' name='product_id' value='{$row["ProductID"]}'>
                        <input type='hidden' name='customer_id' value='{$row["CustomerID"]}'>
                        <input type='text' name='Text' value='{$row["Text"]}'>
                        <button class='Button' type='submit' name='EditReview'>Edit</button>
                    </form></td>";
                echo "<td>" . $row['Username'] . "</td>";
                echo "<td>" . $row['ProductName'] . "</td>";
                echo "<td>";
                echo "<div class = 'but2'>";
                    echo "<form action='adminReviews.php' method='post'>
                        <input type='hidden' name='ReviewID' value='{$row["ReviewID"]}' >
                        <button class='Button' type='submit' name='DeleteReview'>Delete</button>
                    </form>";
                echo "</div>";
                echo "</td></tr>";
                echo "</tbody>";
            }
        }
        else{
            echo "<tr><td colspan = '4'>No review found.</td></tr>";
        }
        
        ?>
    </table>
</body>
</html>
