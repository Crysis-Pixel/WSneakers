<?php
    include ("../header.html");
    include("../database/db.php"); //had to include directory like this else it was not working
    include("../products/productService.php");
    $mainImageDIR = "../ProductImages/"; //location directory of product images
    $p = new ProductService();
    if (isset($_POST["GoBack"])){
        header("location: adminproductpage.php");
        exit;
    }
    if (isset($_POST["SaveItem"])){

        $name = filter_input(INPUT_POST, "ProductName", FILTER_SANITIZE_SPECIAL_CHARS);
        $price =  filter_input(INPUT_POST, "Price", FILTER_SANITIZE_SPECIAL_CHARS);
        $quantity =  filter_input(INPUT_POST, "Quantity", FILTER_SANITIZE_SPECIAL_CHARS);
        $description =  filter_input(INPUT_POST, "Description", FILTER_SANITIZE_SPECIAL_CHARS);

        if (!empty($name) and !empty($price) and !empty($quantity) and !empty($description)){
            
            $updatedfile = $_POST['imagefile'];

            if (!empty($_FILES['image']['name'])){
                $targetFile = $mainImageDIR . basename($_FILES["image"]["name"]);
                $newFilename = strval($p->GetLastID());

                // Check if image file is a actual image or fake image
                $check = getimagesize($_FILES["image"]["tmp_name"]);
                if($check !== false) {
                    $uploadOk = 1;
                } 
                else {
                    echo "<h3>File is not an image.</h3>";
                    $uploadOk = 0;
                }
        
                // Allowing only certain file formats
                $allowedExtensions = array("jpg", "jpeg", "png", "gif");
                $fileExtension = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
                if (!in_array($fileExtension, $allowedExtensions)) {
                    echo "<h3>Sorry, only JPG, JPEG, PNG, and GIF files are allowed.</h3>";
                    $uploadOk = 0;
                }
        
                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    echo "<h3>Sorry, your file was not uploaded.</h3>";
                    return;
                // if everything is ok, try to upload file
                }
                else {
                    $newFilePath = $mainImageDIR . $newFilename . "." . $fileExtension;
                    if (move_uploaded_file($_FILES["image"]["tmp_name"], $newFilePath)) {

                        echo "<h3> Image file uploaded </h3>";
                        
                    } else {
                        echo "<h3>Sorry, there was an error uploading your file.</h3>";
                        return;
                    }
                    $updatedfile = $newFilename.".".$fileExtension;
                }
            }
            

            $prod = new Product($name,$price, $quantity, array(), $updatedfile, array(), $description);

            $p->UpdateProduct($prod, $_POST['product_id']);
        }
        else{
            echo "<h3> One of the field cannot be empty. Image must be uploaded. </h3>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="productstyles.css">
    <title>Document</title>
</head>
<body class = 'body'>
<!-- action="producteditpage.php"  -->
    <form role="form" method="post" enctype="multipart/form-data"> 
    <?php
        echo "<h2>Product Edit</h2>";

        try{
            if (isset($_POST['product_id'])){
                $result = $p->GetProduct($_POST['product_id']);
            }
            else{
                echo "Failed to get product";
                return;
            }
            $row = $result->fetch_assoc();
            echo "<table>";
            echo "<tr>";
            echo "<th>Edit Information</th>";
            echo "</tr>";
            echo "<tr>";
            echo "<td><br> Name: <input type='text' name='ProductName' value='". htmlspecialchars($row["ProductName"])."'></td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td><br> Price(tk): <input type='number' name='Price' value=".$row["Price"]."> </td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td><br> Quantity: <input type='number' name='Quantity' value=".strval($row["Quantity"])." ></td>";
            echo "</tr>";
            echo "<tr>";
            $image = $mainImageDIR.$row["Image"];
            echo "<input type='hidden' name='imagefile' value='{$row["Image"]}'>";
            echo
                "<td><br> Image: ".
                    '<img src="'.$image.'" height = "100"/><br />'  
                ."<br>";
            
            echo "Upload new image: <input type='file' name='image' /></td>";    
            echo "</tr>";
            echo "<tr>";
            echo "<br>";
            
            echo "<tr>";
            echo "<td><br> Description: <input type='text' name='Description' value='" . htmlspecialchars($row["ProductDesc"]) . "' size='50'> <br><br> </td>";
            echo "</tr>";
            echo "</table>";
            echo "<input class='Button' type='submit' name='DeleteProduct' value='Delete Product' style='font-size: 35px;'>";
            echo "<input class='Button' type='submit' name='GoBack' value='Done' style='font-size: 35px;'>";
            echo "<input class='Button' type='submit' name='SaveItem' value='Save changes' style='font-size: 35px;'>";
            
        }
        catch(Exception $e){
            echo "Error: ".$e->getMessage()."<br";
            echo "Failed to get product information.";
        }
        echo "<input type='hidden' name='product_id' value='{$_POST["product_id"]}'>";
        
    ?>
    </form>
</body>
</html>