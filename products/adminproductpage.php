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
            include ("../header.html");
            include("../database/db.php"); //had to include directory like this else it was not working
            include("../products/productService.php");
            $mainImageDIR = "../ProductImages/"; //location directory of product images
            $p = new ProductService();
        ?>
        <form action="adminproductpage.php" method="post">
        <label for="search">Search:</label>
        <input type="text" id="search" name="query" placeholder="Enter search term">
        <button class='Button' type="submit" style="width:auto; padding:10px;">Search</button>
        </form>

        <form action="addproductpage.php">
            <br><br><button class='Button' type='submit' style='margin: 0 auto; display: block; width:20%;'>Add Product</button>
        </form>

        <?php
            // //product will be added/updated through an object like this
            // $prod = new Product("Nike Air Force One", 450.19, 5, array("Blue", "Gray", "Black"),"5.gif",[41,42,43],"Best of Nike! Better than Adidas!");
            // //$p->Insert($prod);
            // //$p->Delete(4);
            // //$p->Search("Nike");
            // //$p->Update($prod,4);
            // $p->GetAll(); //gets all products
            ?>
        <?php

            //var_dump($_POST);

            if (!empty($_POST["query"])){
                $result = $p->Search($_POST["query"]);
            }
            else{
                $result = $p->Search("");
            }
        
            if ($result){
                //added html code through PHP's echo function
                
                echo "<h2>Product List</h2>";

                echo "<table>
                <tr>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Image</th>
                    <th>Product Description</th>
                    <th></th>
                    <th>Sizes</th>
                    <th>Colours</th>
                </tr>";
                
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>".$row["ProductID"]."</td>";
                    echo "<td>".$row["ProductName"]."</td>";
                    echo "<td>".$row["Price"]."tk</td>";
                    echo "<td>".$row["Quantity"]."</td>";
                    $image = $mainImageDIR.$row["Image"];
                    echo 
                        "<td>".
                            '<img src="'.$image.'" height = "100"/><br />'  
                        ."</td>"
                    ;

                    echo "<td>".$row["ProductDesc"]."</td>";
                    echo "<td>
                    <form action='editproductpage.php' method='post'>
                        <input type='hidden' name='product_id' value='{$row["ProductID"]}'>
                        <button class='Button' type='submit'>Edit/Update Product</button>
                    </form>
                    </td>";

                    echo "<td>";
                    $sizeresult = $p->getAllSizes($row["ProductID"]);
                    if(mysqli_num_rows($sizeresult)==0){
                        echo "No size available. <br><br>";
                    }
                    else{
                        $sizestring = "";
                        while($sizerow = $sizeresult->fetch_assoc()){
                            $sizestring = $sizestring . $sizerow["size"] . "<br>";
                        }
                        echo $sizestring."<br>";
                    }
                    echo "<form action='editsizespage.php' method='post'>
                        <input type='hidden' name='product_id' value='{$row["ProductID"]}'>
                        <button class='Button' type='submit' style='padding: 0px;'>Edit/Update Product Sizes</button>
                        </form>
                        </td>";
                    
                    echo "<td>";
                    $colourresult = $p->getAllColours($row["ProductID"]);
                    if(mysqli_num_rows($colourresult)==0){
                        echo "No colours available. <br><br>";
                    }
                    else{
                        $colourstring = "";
                        while($colourrow = $colourresult->fetch_assoc()){
                            $colourstring = $colourstring . $colourrow["Colour"] . "<br>";
                        }   
                        echo $colourstring."<br>";
                    }
                    echo "<form action='editcolourspage.php' method='post'>
                        <input type='hidden' name='product_id' value='{$row["ProductID"]}'>
                        <button class='Button' type='submit' style='padding: 0px;'>Edit/Update Product Colours</button>
                        </form>
                        </td>";
        
                    echo "</tr>";  
                }

                echo "</table>";
            }
            else{
                echo "<h2>No product available.</h2>";
            }
        ?>
</body>
</html>

