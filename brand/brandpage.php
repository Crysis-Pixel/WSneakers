<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="brandstyles.css">
    <title>Document</title>
</head>
<body>
        <?php
            session_start();
            include("../sellers/sellerSessionAccess.php");
            include ("../header.html");
            include("../database/db.php"); //had to include directory like this else it was not working
            include("../brand/brandService.php");
            $p = new BrandService();

        ?>
         
        <form action="brandpage.php" method="post">
        <label for="search">Search:</label>
        <input type="text" id="search" name="query" placeholder="Enter search term">
        <button class='Button' type="submit" style="width:auto; padding:10px;">Search</button>
        </form>

        <br><br>
        
        <table><tr>
        <td><form action="addbrandpage.php">
            <button class='Button' type='submit'>Add Brand</button>
        </form></td>
        
        
        <?php
            if (isset($_SESSION["SellerUsername"])) {
                echo "<td><form action='../sellerProfile/sellerProfile.php'>";
            }
            else echo "<td><form action='../adminPage/adminProduct/adminproductpage.php'>";
        ?>
            <button class='Button' type='submit'>Go back</button>
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
                
                echo "<h2>Brand List</h2>";

                echo "<table>
                <tr>
                    <th>Brand ID</th>
                    <th>Brand Name</th>
                    <th></th>
                </tr>";
                
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>".$row["BrandID"]."</td>";
                    echo "<td>".$row["Name"]."</td>";
                    echo "<td>";
                    echo "<form action='brandeditpage.php' method='post'>
                        <input type='hidden' name='brand_id' value='{$row["BrandID"]}'>
                        <button class='Button' type='submit' style='padding: 0px;'>Edit/Update brand</button>
                        </form>
                        </td>";
                    echo "</tr>";  
                }
                echo "</table>";
            }
            else{
                echo "<h2>No brand available.</h2>";
            }
        ?>
</body>
</html>

