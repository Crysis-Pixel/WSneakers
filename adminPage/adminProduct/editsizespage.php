<?php
    session_start();
    include("../adminSessionAccess.php");
    include ("/xampp/htdocs/WSneakers/header.html");
    include("/xampp/htdocs/WSneakers/database/db.php"); //had to include directory like this else it was not working
    include("/xampp/htdocs/WSneakers/products/productService.php");
    $mainImageDIR = "/WSneakers/ProductImages/"; //location directory of product images
    $p = new ProductService();

    
    if (isset($_POST['GoBackButton'])){
        {header("location: ./adminproductpage.php");exit;}
    }
    if (isset($_POST['RemoveSizeButton'])){
        if (isset($_POST['sizechoose'])){
            try{
                $p->DeleteProductSize($_POST["product_id"],$_POST['sizechoose']);
                echo "<h3> Product size successfully removed.</h3>.";
            }
            catch (Exception $e){
                echo "Error: ".$e->getMessage()."<br";
                echo "<h3> Failed to delete product size.</h3>.";
            }
        }
    }

    if (isset($_POST['AddSizeButton'])){
        $sizeadd = filter_input(INPUT_POST, "AddSize", FILTER_SANITIZE_SPECIAL_CHARS);
        if (!empty($sizeadd)){
            try{
                $p->AddProductSize($_POST['product_id'], $sizeadd);
            }
            catch (Exception $e){
                echo "Error: ".$e->getMessage()."<br";
                echo "<h3> Failed to add product size.</h3>.";
            }
        }
        else{
            echo "<h3> Please enter a size to add.</h3>";
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
<body class = 'body'>
<!-- action="producteditpage.php"  -->
    <form role="form" action="" method="post"> 
    <table>
    <?php
        echo "<h2>Product Sizes Edit</h2>";
        echo "<h3 style='text-align: center;'> Editing sizes for Product: ".$_POST['product_id']."</h3>";   
        try{  
            $sizeresult = $p->getAllProductSizes($_POST['product_id']);
            echo "<tr>";
            echo "<td style='border:none;'>";
            echo "Stored sizes:<br>";
            if(mysqli_num_rows($sizeresult)==0){
                echo "No product sizes added. <br>";
            }
            else{
                while($sizerow = $sizeresult->fetch_assoc()){
                    echo "<input type='radio' name='sizechoose' value=".$sizerow["size"].">";
                    echo $sizerow["size"]."<br>";
                }
            }
            echo "
                    <td style='border:none;'><button type='submit' name='RemoveSizeButton' class='Button' style='width:auto;'>Remove Size</button><br><br></td></tr>
                    <td style='border:none;'><br>Add Size: <input type='number' name='AddSize' placeholder='Enter Size' size='5'></td>
                    <td style='border:none;'><br><br><button type='submit' name='AddSizeButton' class='Button' style='width:auto;'>Add Size</button><br><br></td></tr>";
            
            echo "<input type='hidden' name='product_id' value='{$_POST["product_id"]}'>";
        }
        catch(Exception $e){
            echo "Error: ".$e->getMessage()."<br";
            echo "Failed to get product information.";
        }
        
    ?>
    
    </table>
    <button type='submit' name='GoBackButton' class='Button'>Done</button>
    </form>
</body>
</html>