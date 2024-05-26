<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="productstyles.css">
</head>

<body>
    <?php
    include("../header.html");
    include("../database/db.php"); //had to include directory like this else it was not working
    include("../products/productService.php");
    include("../brand/brandService.php");
    include("../category/categoryService.php");
    $mainImageDIR = "../ProductImages/"; //location directory of product images
    $p = new ProductService();
    $b = new BrandService();
    $c = new CategoryService();
    // //product will be added/updated through an object like this
    // $prod = new Product("Nike Air Force One", 450.19, 5, array("Blue", "Gray", "Black"),"5.gif",[41,42,43],"Best of Nike! Better than Adidas!");
    // //$p->Insert($prod);
    // //$p->Delete(4);
    // //$p->Search("Nike");
    // //$p->Update($prod,4);
    // $p->GetAll(); //gets all products
    ?>

    <form action="customerproductpage.php" method="post">
        <h3>Search by:</h3>

        Name:<input type="text" id="search" name="query" placeholder="Enter search term">
        Colour:
        <?php
        echo "<select name='Colourdropdown'>";
        $colour = $p->GetAllDistinctColours();
        echo "<option value='" . "Any" . "'>" . "Any" . "</option>";
        if ($colour) {
            while ($crow = $colour->fetch_assoc()) {
                echo "<option value='" . $crow['Colour'] . "'>" . $crow['Colour'] . "</option>";
            }
        } else {
            echo "Failed to get Colours.";
        }
        echo "</select>";
        ?>
        Size:
        <?php
        echo "<select name='Sizedropdown'>";
        $size = $p->GetAllDistinctSizes();
        echo "<option value='" . "Any" . "'>" . "Any" . "</option>";
        if ($size) {
            while ($crow = $size->fetch_assoc()) {
                echo "<option value='" . $crow['size'] . "'>" . $crow['size'] . "</option>";
            }
        } else {
            echo "Failed to get Sizes.";
        }
        echo "</select>";
        ?>
        Category:
        <?php
        echo "<select name='Categorydropdown'>";
        $category = $c->GetAllCategories();
        echo "<option value='" . "Any" . "'>" . "Any" . "</option>";
        if ($category) {
            while ($crow = $category->fetch_assoc()) {
                echo "<option value='" . $crow['Type'] . "'>" . $crow['Type'] . "</option>";
            }
        } else {
            echo "Failed to get Category.";
        }
        echo "</select>";
        ?>
        Brand:
        <?php
        echo "<select name='Branddropdown'>";
        $brand = $b->GetAllBrands();
        echo "<option value='" . "Any" . "'>" . "Any" . "</option>";
        if ($brand) {
            while ($brow = $brand->fetch_assoc()) {
                echo "<option value='" . $brow['Name'] . "'>" . $brow['Name'] . "</option>";
            }
        } else {
            echo "Failed to get brand.";
        }
        echo "</select>";
        ?>
        <button class='Button' type="submit" style="width:auto; padding:10px;">Search</button>

    </form>
    <div class="cartDiv">
        <a class="cart" href="../cart/cartPage.php">My Cart 🛒</a>
    </div>
    <?php
    $namesearch = "";
    $coloursearch = "";
    $sizesearch = -1;
    $categorysearch = "";
    $brandsearch = "";


    if (!empty($_POST["query"])) $namesearch = $_POST["query"];
    if (isset($_POST["Colourdropdown"]) && (strcmp($_POST["Colourdropdown"], 'Any') != 0)) $coloursearch = $_POST["Colourdropdown"];
    if (isset($_POST["Sizedropdown"]) && (strcmp($_POST["Sizedropdown"], 'Any') != 0)) $sizesearch = $_POST["Sizedropdown"];
    if (isset($_POST["Categorydropdown"]) && (strcmp($_POST["Categorydropdown"], 'Any') != 0)) $categorysearch = $_POST["Categorydropdown"];
    if (isset($_POST["Branddropdown"]) && (strcmp($_POST["Branddropdown"], 'Any') != 0)) $brandsearch = $_POST["Branddropdown"];

    $result = $p->Search($namesearch, $sizesearch, $coloursearch, $categorysearch, $brandsearch);

    if ($result) {
        //added html code through PHP's echo function

        echo "<h2>Product List</h2>";

        echo "<table>
                <tr>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Brand</th>
                    <th>Category</th> 
                    <th>Image</th>
                    <th>Sizes</th>
                    <th>Colours</th>
                    <th>Product Description</th>
                    <th><th>
                    </th>
                </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["ProductName"] . "</td>";
            echo "<td>" . $row["Price"] . "tk</td>";
            echo "<td>" . $row["Quantity"] . "</td>";
            if (strcmp($row["BrandID"], '')) {
                $brand = $b->GetBrand($row["BrandID"]);
                if ($brand) {

                    echo "<td>" . $brand->fetch_assoc()["Name"] . "</td>";
                }
            } else {
                echo "<td> None. </td>";
            }

            if (strcmp($row["CategoryID"], '')) {
                $category = $c->getCategory($row["CategoryID"]);
                if ($category) {
                    echo "<td>" . $category->fetch_assoc()["Type"] . "</td>";
                }
            } else {
                echo "<td> None. </td>";
            }
            $image = $mainImageDIR . $row["Image"];
            echo
            "<td>" .
                '<img src="' . $image . '" height = "100"/><br />'
                . "</td>";

            $sizeresult = $p->getAllProductSizes($row["ProductID"]);
            if (!$sizeresult) {
                echo "Failed to get product colours. <br>";
            } else {
                $sizestring = "";
                while ($sizerow = $sizeresult->fetch_assoc()) {
                    $sizestring = $sizestring . $sizerow["size"] . "<br>";
                }
                echo "<td>" . $sizestring . "</td>";
            }

            $colourresult = $p->getAllProductColours($row["ProductID"]);
            if (!$colourresult) {
                echo "Failed to get product colours. <br>";
            } else {
                $colourstring = "";
                while ($colourrow = $colourresult->fetch_assoc()) {
                    $colourstring = $colourstring . $colourrow["Colour"] . "<br>";
                }
                echo "<td>" . $colourstring . "</td>";
            }
            echo "<td>" . $row["ProductDesc"] . "</td>";
            echo "<td>
                <form action='../wishlist/wishlist.php' method='post'>
                    <input type='hidden' name='product_id' value='{$row["ProductID"]}'>
                    <input class='Button' type='submit' name='{$row["ProductID"]}' value='Add to wishlist'>
                </form>
                </td>";
            echo "<td>
                <form action='singleproductpage.php' method='post'>
                    <input type='hidden' name='product_id' value='{$row["ProductID"]}'>
                    <input class='Button' type='submit' name='{$row["ProductID"]}' value='See Item'>
                </form>
                </td>";
        
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<h2>No product available.</h2>";
    }
    ?>
</body>

</html>