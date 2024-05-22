<?php
session_start();
include("../adminSessionAccess.php");
include("/xampp/htdocs/WSneakers/header.html");
include("/xampp/htdocs/WSneakers/database/db.php"); //had to include directory like this else it was not working
include("/xampp/htdocs/WSneakers/products/productService.php");
$mainImageDIR = "/WSneakers/ProductImages/"; //location directory of product images
$p = new ProductService();

if (isset($_POST['GoBackButton'])) {

    header("location: ./adminproductpage.php");
    exit;
}
if (isset($_POST['RemoveColourButton'])) {
    if (isset($_POST['colourchoose'])) {
        try {
            $p->DeleteProductColour($_POST["product_id"], $_POST['colourchoose']);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "<br";
            echo "<h3> Failed to delete product colour.</h3>.";
        }
    }
}

if (isset($_POST['AddColourButton'])) {
    $colouradd = filter_input(INPUT_POST, "AddColour", FILTER_SANITIZE_SPECIAL_CHARS);
    if (!empty($colouradd)) {
        try {
            $p->AddProductColour($_POST['product_id'], $colouradd);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "<br";
            echo "<h3> Failed to add product colour.</h3>.";
        }
    } else {
        echo "<h3> Please enter a valid colour to add.</h3>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../products/productstyles.css">
    <title>Document</title>
</head>

<body class='body'>
    <!-- action="producteditpage.php"  -->
    <form role="form" action="editcolourspage.php" method="post">
        <table>
            <?php
            echo "<h2>Product Colours Edit</h2>";
            try {
                echo "<h3 style='text-align: center;'> Editing colours for Product: " . $_POST['product_id'] . "</h3>";
                $colourresult = $p->GetAllProductColours($_POST['product_id']);
                echo "<tr>";
                echo "<td style='border:none;'>";
                echo "Stored colours:<br>";
                if (!$colourresult) {
                    echo "Failed to get product colours. <br>";
                } else {
                    while ($colourrow = $colourresult->fetch_assoc()) {
                        echo "<input type='radio' name='colourchoose' value=" . $colourrow["Colour"] . ">";
                        echo $colourrow["Colour"] . "<br>";
                    }
                }
                echo "
                    <td style='border:none;'><button type='submit' name='RemoveColourButton' class='Button' style='width:auto;'>Remove Colour</button><br><br></td></tr>
                    <td style='border:none;'><br>Add Colour: <input type='text' name='AddColour' placeholder='Enter Colour' size='10'></td>
                    <td style='border:none;'><br><br><button type='submit' name='AddColourButton' class='Button' style='width:auto;'>Add Colour</button><br><br></td></tr>";

                echo "<input type='hidden' name='product_id' value='{$_POST["product_id"]}'>";
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage() . "<br";
                echo "Failed to get product information.";
            }

            ?>

        </table>
        <button type='submit' name='GoBackButton' class='Button'>Done</button>
    </form>
</body>

</html>