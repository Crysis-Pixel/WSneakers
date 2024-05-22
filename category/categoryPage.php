<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="categorystyles.css">
    <title>Document</title>
</head>
<body>
        <?php
            include ("../header.html");
            include("../database/db.php"); //had to include directory like this else it was not working
            include("../category/categoryService.php");
            $p = new CategoryService();
            session_start();
        ?>
         
        <form action="categorypage.php" method="post">
        <label for="search">Search:</label>
        <input type="text" id="search" name="query" placeholder="Enter search term">
        <button class='Button' type="submit" style="width:auto; padding:10px;">Search</button>
        </form>

        <br><br>

        <table><tr>
        <td><form action="addcategorypage.php">
            <button class='Button' type='submit'>Add Category</button>
        </form></td>

        <?php
            if (isset($_SESSION["SellerUsername"])) {
                echo "<td><form action='../sellerProfile/sellerProfile.php'>";
            }
            else echo "<td><form action='../adminPage/adminProduct/adminproductpage.php'>";
        ?>
            <button class='Button' type='submit'>Go Back</button>
        </form></td>
        </tr></table>

        <?php

            if (!empty($_POST["query"])){
                $result = $p->Search($_POST["query"]);
            }
            else{
                $result = $p->Search("");
            }
        
            if ($result){
                
                echo "<h2>Category List</h2>";

                echo "<table>
                <tr>
                    <th>Category ID</th>
                    <th>Type</th>
                    <th></th>
                </tr>";
                
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>".$row["CategoryID"]."</td>";
                    echo "<td>".$row["Type"]."</td>";
                    echo "<td>";
                    echo "<form action='categoryeditpage.php' method='post'>
                        <input type='hidden' name='category_id' value='{$row["CategoryID"]}'>
                        <button class='Button' type='submit' style='padding: 0px;'>Edit/Update category</button>
                        </form>
                        </td>";
                    echo "</tr>";  
                }
                echo "</table>";
            }
            else{
                echo "<h2>No category available.</h2>";
            }
        ?>
</body>
</html>

