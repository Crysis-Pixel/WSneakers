<?php
    include("../database/db.php");
    include("../reviews/reviewsService.php");
    session_start();
    include("../adminPage/adminSessionAccess.php");
    include("../header.html");
    $r = new ReviewsService();

    if (isset($_POST["deletebutton"])){
        if (!empty($_POST["deletereview"])){
            $r->DeleteReview($_POST["deletereview"]);
        }
    }

    if (isset($_POST["editbutton"])){
        if (!empty($_POST["editreview"])){
            $review = new Reviews($_POST["editreview"],0,0);
            var_dump($_POST);
            $r->UpdateReview($review,$_POST["editreviewID"]);
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../products/productstyles.css">
    <a class="admin" href="./adminPage.html">Admin</a>
    <br><br>
</head>
<body>
<form action="allreviews.php" method="post">
        <h3>Search by:</h3>
        Username:<input type="text" id="search" name="query" placeholder="Enter search term">
        Product Name:<input type="text" id="search" name="query1" placeholder="Enter search term">
        <button class='Button' type="submit" style="width:auto; padding:10px;">Search</button>
    </form>
    <table>
        <th>ReviewID</th>
        <th>Text</th>
        <th>Product Name</th>
        <th>Customer Name</th>
        <?php
            $namesearch = "";
            $productsearch = "";
            if (!empty($_POST["query"])) $namesearch = $_POST["query"];
            if (!empty($_POST["query1"])) $productsearch = $_POST["query1"];
            $result = $r->Search($namesearch,$productsearch);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['ReviewID'] . "</td>";
                    echo "<td><form action='allreviews.php' method='post'>";
                        echo "<input type='hidden' name='editreviewID' value='{$row["ReviewID"]}'>";
                        echo "<br><input type='text' name='editreview' value='".htmlspecialchars($row["Text"],ENT_QUOTES)."'><br><br>";
                        echo "<button class='Button' name='editbutton' type='submit' style='padding: 4px;'>Edit</button>";
                    echo "</form></td>";
                    echo "<td>" . $row['ProductName'] . "</td>";
                    echo "<td>" . $row['Username'] . "</td>";
                    echo "<td>";
                    echo "<form action='allreviews.php' method='post'>
                            <input type='hidden' name='deletereview' value='{$row["ReviewID"]}'>
                            <button class='Button' name='deletebutton' type='submit' >Delete</button>
                        </form>";
                    echo "</td></tr>";
                }
            }
        ?>
    </table>
</body>
</html>
