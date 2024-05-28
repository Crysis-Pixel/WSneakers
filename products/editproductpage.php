<?php
    session_start();
    include("../sellers/sellerSessionAccess.php");
    include ("../header.html");
    include("../database/db.php"); //had to include directory like this else it was not working
    include("../products/productService.php");
    include("../brand/brandService.php");
    include("../category/categoryService.php");
    include("../sellers/sellerRepository.php");

    $mainImageDIR = "../ProductImages/"; //location directory of product images
    $p = new ProductService();
    $b = new BrandService();
    $c = new CategoryService();
    $s = new SellerRepo();
    if (isset($_POST["GoBack"])){
        if (isset($_SESSION["SellerUsername"])) {
            header("location: ../sellerProfile/sellerProfile.php");
            exit;
        }
        else header("location: ../products/adminproductpage.php"); exit;
        
    }
    if (isset($_POST["DeleteProduct"])){
        if (isset($_POST['product_id'])){
            $p->DeleteProduct($_POST['product_id']);
        }
        else{
            echo "<h3> Failed to delete product </h3>";
        }
        if (isset($_SESSION["SellerUsername"])) {
            header("location: ../sellerProfile/sellerProfile.php");
            exit;
        }
        else {header("location: ../products/adminproductpage.php");exit;}
    }
    if (isset($_POST["SaveItem"])){

        $name = filter_input(INPUT_POST, "ProductName", FILTER_SANITIZE_SPECIAL_CHARS);
        $price =  filter_input(INPUT_POST, "Price", FILTER_SANITIZE_SPECIAL_CHARS);
        $quantity =  filter_input(INPUT_POST, "Quantity", FILTER_SANITIZE_SPECIAL_CHARS);
        $description =  filter_input(INPUT_POST, "Description", FILTER_SANITIZE_SPECIAL_CHARS);
        $brand = $_POST["branddropdown"];
        $category = $_POST["categorydropdown"];
        if (isset($_POST["sellerdropdown"])){
            $seller = $_POST["sellerdropdown"];
        }
        else $seller = $_SESSION["SellerID"];

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
                    unlink($mainImageDIR.$updatedfile);
                    if (move_uploaded_file($_FILES["image"]["tmp_name"], $newFilePath)) {

                        echo "<h3> Image file uploaded </h3>";
                        
                    } else {
                        echo "<h3>Sorry, there was an error uploading your file.</h3>";
                        return;
                    }
                    $updatedfile = $newFilename.".".$fileExtension;
                }
            }
            

            $prod = new Product( $name, $price, $quantity, array(), $updatedfile, array(), $description, $brand, $category, $seller);

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
            echo "<td><br> Name: <input type='text' name='ProductName' value='". htmlspecialchars($row["ProductName"])."'><br><br></td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td><br> Price(tk): <input type='number' name='Price' value=".$row["Price"]."><br><br></td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td><br> Quantity: <input type='number' name='Quantity' value=".strval($row["Quantity"])." ><br><br></td>";
            echo "</tr>";
            echo "<tr>";
            $image = $mainImageDIR.$row["Image"];
            echo "<input type='hidden' name='imagefile' value='{$row["Image"]}'>";
            echo
                "<td><br> Image: ".
                    '<img src="'.$image.'" height = "100"/><br />'  
                ."<br>";
            
            echo "Upload new image: <input type='file' name='image' /><br><br></td>";    
            echo "</tr>";
            echo "<tr><td>";
            echo "<br>";
            echo "Choose brand: ";
            echo "<select name='branddropdown'>";
            $brand = $b->GetAllBrands();
            if ($brand){
                while ($brow = $brand->fetch_assoc()){
                    echo "<option value='" . $brow['BrandID'] . "'>" . $brow['Name'] . "</option>";
                }
            }
            else {
                echo "Failed to get brand.";
            }
            echo "</select>";
            echo "<br><br>";
            echo "</td></tr>";
            echo "<tr><td>";
            echo "<br>";
            echo "Choose category: ";
            echo "<select name='categorydropdown'>";
            $category = $c->GetAllCategories();
            if ($category){
                while ($crow = $category->fetch_assoc()){
                    echo "<option value='" . $crow['CategoryID'] . "'>" . $crow['Type'] . "</option>";
                }
            }
            else {
                echo "Failed to get Category.";
            }
            echo "</select>";
            echo "<br><br>";
            echo "</td></tr>";

            if (empty($_SESSION["SellerUsername"])){
                echo "<tr><td>";
                echo "<br>";
                echo "Choose seller: ";
                echo "<select name='sellerdropdown'>";
                $seller = $s->getAllSellers();
                if ($seller){
                    while ($crow = $seller->fetch_assoc()){
                        echo "<option value='" . $crow['SellerID'] . "'>" . $crow['Username'] . "</option>";
                    }
                }
                else {
                    echo "Failed to get seller.";
                }
                echo "</select>";
                echo "<br><br>";
                echo "</td></tr>";
            }

            echo "<tr>";
            echo "<td><br> Description: <input type='text' name='Description' value='" . htmlspecialchars($row["ProductDesc"],ENT_QUOTES) . "' size='50'> <br><br> </td>";
            echo "</tr>";
            echo "</table>";
            echo "<input class='Button' type='submit' name='DeleteProduct' value='Delete Product' style='font-size: 35px;'>";
            echo "<input class='Button' type='submit' name='GoBack' value='Back' style='font-size: 35px;'>";
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