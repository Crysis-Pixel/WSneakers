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
            // //product will be added/updated through an object like this
            // $prod = new Product("Nike Air Force One", 450.19, 5, array("Blue", "Gray", "Black"),"5.gif",[41,42,43],"Best of Nike! Better than Adidas!");
            // //$p->Insert($prod);
            // //$p->Delete(4);
            // //$p->Search("Nike");
            // //$p->Update($prod,4);
            // $p->GetAll(); //gets all products

            $result = $p->GetAllProducts();

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
                    <th>Sizes</th>
                    <th>Colours</th>
                    <th>Product Description</th>
                    <th></th>
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

                    $sizeresult = $p->getAllSizes($row["ProductID"]);
                    if(!$sizeresult){
                        echo "Failed to get product colours. <br>";
                    }
                    else{
                        $sizestring = "";
                        while($sizerow = $sizeresult->fetch_assoc()){
                            $sizestring = $sizestring . $sizerow["size"] . "<br>";
                        }
                        echo "<td>".$sizestring."</td>";
                    }

                    $colourresult = $p->getAllColours($row["ProductID"]);
                    if(!$colourresult){
                        echo "Failed to get product colours. <br>";
                    }
                    else{
                        $colourstring = "";
                        while($colourrow = $colourresult->fetch_assoc()){
                            $colourstring = $colourstring . $colourrow["Colour"] . "<br>";
                        }
                        echo "<td>".$colourstring."</td>";
                    }
                    echo "<td>".$row["ProductDesc"]."</td>";
                    echo "<td>
                    <input class='Button' type='button' name='{$row["ProductID"]}' value='Add to cart' onclick='alert(\"Product added to cart\")'>
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