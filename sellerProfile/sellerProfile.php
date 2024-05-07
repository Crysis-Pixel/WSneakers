<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="sellerProfile.css">
    <title>Document</title>
</head>
<body>
    <?php
        if (isset($_POST["LogOutBtn"])){
            session_destroy();
            header("location: ../index.php");
        }

        include ("../header.html");
        
        session_start();

        if (empty($_SESSION["SellerUsername"])) {
            header("location: ../login.php");
            exit;
        }
        echo "<h1> Welcome " . $_SESSION["SellerUsername"] . "!</h1>";
    ?>
    <?php
            include("../database/db.php"); //had to include directory like this else it was not working
            include("../products/productService.php");
            include("../brand/brandService.php");
            include("../category/categoryService.php");
            $mainImageDIR = "../ProductImages/"; //location directory of product images
            $p = new ProductService();
            $b = new BrandService();
            $c = new CategoryService();
    ?>
    <form action="sellerProfile.php" method="post">
        <h3>Search by:</h3>

        Name:<input type="text" id="search" name="query" placeholder="Enter search term">
        Colour:
        <?php
            echo "<select name='Colourdropdown'>";
            $colour = $p->GetAllDistinctColours();
            echo "<option value='" . "Any". "'>" . "Any" . "</option>";
            if ($colour){
                while ($crow = $colour->fetch_assoc()){
                    echo "<option value='" . $crow['Colour'] . "'>" . $crow['Colour'] . "</option>";
                }
            }
            else {
                echo "Failed to get Colours.";
            }
            echo "</select>";
        ?>
        Size:
        <?php
            echo "<select name='Sizedropdown'>";
            $size = $p->GetAllDistinctSizes();
            echo "<option value='" . "Any". "'>" . "Any" . "</option>";
            if ($size){
                while ($crow = $size->fetch_assoc()){
                    echo "<option value='" . $crow['size'] . "'>" . $crow['size'] . "</option>";
                }
            }
            else {
                echo "Failed to get Sizes.";
            }
            echo "</select>";
        ?>
        Category:
        <?php
            echo "<select name='Categorydropdown'>";
            $category = $c->GetAllCategories();
            echo "<option value='" . "Any". "'>" . "Any" . "</option>";
            if ($category){
                while ($crow = $category->fetch_assoc()){
                    echo "<option value='" . $crow['Type'] . "'>" . $crow['Type'] . "</option>";
                }
            }
            else {
                echo "Failed to get Category.";
            }
            echo "</select>";
        ?>
        Brand:
        <?php
            echo "<select name='Branddropdown'>";
            $brand = $b->GetAllBrands();
            echo "<option value='" . "Any". "'>" . "Any" . "</option>";
            if ($brand){
                while ($brow = $brand->fetch_assoc()){
                    echo "<option value='" . $brow['Name'] . "'>" . $brow['Name'] . "</option>";
                }
            }
            else {
                echo "Failed to get brand.";
            }
            echo "</select>";
        ?>
        <button class='Button' type="submit" style="width:auto; padding:10px;">Search</button>

    </form>

    <br><br>
    <table><tr>
    <td><form action="../products/addproductpage.php">
        <button class='Button' type='submit'>Add Product</button>
    </form></td>

    <td><form action="../brand/brandpage.php">
        <button class='Button' type='submit'>Brands</button>
    </form></td>

    <td><form action="../category/categoryPage.php">
        <button class='Button' type='submit'>Categories</button>
    </form></td>

    <td><form action="sellerProfile.php" method="post">
        <button class='Button' name='LogOutBtn' type='submit'>Log Out</button>
    </form></td>
    </tr></table>

    <?php

        $namesearch = "";
        $coloursearch = "";
        $sizesearch = -1;
        $categorysearch = "";
        $brandsearch = "";
        

        if (!empty($_POST["query"])) $namesearch = $_POST["query"];
        if (isset($_POST["Colourdropdown"]) && (strcmp($_POST["Colourdropdown"],'Any')!=0)) $coloursearch = $_POST["Colourdropdown"];
        if (isset($_POST["Sizedropdown"]) && (strcmp($_POST["Sizedropdown"],'Any')!=0)) $sizesearch = $_POST["Sizedropdown"];
        if (isset($_POST["Categorydropdown"]) && (strcmp($_POST["Categorydropdown"],'Any')!=0)) $categorysearch = $_POST["Categorydropdown"];
        if (isset($_POST["Branddropdown"]) && (strcmp($_POST["Branddropdown"],'Any')!=0)) $brandsearch = $_POST["Branddropdown"];

        $result = $p->SearchofSeller($namesearch, $sizesearch, $coloursearch, $categorysearch, $brandsearch, $_SESSION["SellerID"]);
    
        if (mysqli_num_rows($result)>0){
            //added html code through PHP's echo function
            
            echo "<h2>Your Product List</h2>";

            echo "<table>
            <tr>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Brand</th>
                <th>Category</th>         
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
                if (strcmp($row["BrandID"],'')){
                    $brand = $b->GetBrand($row["BrandID"]);
                    if ($brand){
                        
                        echo "<td>".$brand->fetch_assoc()["Name"]."</td>";
                    }
                }
                else{
                    echo "<td> None. </td>";
                }
                
                if (strcmp($row["CategoryID"], '')){
                    $category = $c->getCategory($row["CategoryID"]);
                    if ($category){
                        echo "<td>".$category->fetch_assoc()["Type"]."</td>";
                    }
                }
                else{
                    echo "<td> None. </td>";
                }
                $image = $mainImageDIR.$row["Image"];
                echo 
                    "<td>".
                        '<img src="'.$image.'" height = "100"/><br />'  
                    ."</td>"
                ;

                echo "<td>".$row["ProductDesc"]."</td>";
                echo "<td>
                <form action='../products/editproductpage.php' method='post'>
                    <input type='hidden' name='product_id' value='{$row["ProductID"]}'>
                    <button class='Button' type='submit'>Edit/Update Product</button>
                </form>
                </td>";

                echo "<td>";
                $sizeresult = $p->getAllProductSizes($row["ProductID"]);
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
                echo "<form action='../products/editsizespage.php' method='post'>
                    <input type='hidden' name='product_id' value='{$row["ProductID"]}'>
                    <button class='Button' type='submit' style='padding: 0px;'>Edit/Update Product Sizes</button>
                    </form>
                    </td>";
                
                echo "<td>";
                $colourresult = $p->getAllProductColours($row["ProductID"]);
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
                echo "<form action='../products/editcolourspage.php' method='post'>
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