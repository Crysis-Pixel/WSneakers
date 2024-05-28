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

    if (isset($_POST['Cancel'])){
        if (isset($_SESSION["SellerUsername"])) {
            header("location: ../sellerProfile/sellerProfile.php");
            exit;
        }
        else {header("location: ../products/adminproductpage.php");exit;}
        
    }

    if (isset($_POST['AddProduct'])){
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

        if (!empty($name) and !empty($price) and !empty($quantity) and !empty($description) and $_FILES['image']){
            
            $targetFile = $mainImageDIR . basename($_FILES["image"]["name"]);
            $newFilename = strval($p->GetLastID()+1);
    
            // Check if image file is a actual image or fake image
            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if($check !== false) {
                $uploadOk = 1;
            } else {
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
            } else {
                $newFilePath = $mainImageDIR . $newFilename . "." . $fileExtension;
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $newFilePath)) {

                    echo "<h3> Image file uploaded </h3>";
                    
                } else {
                    echo "<h3>Sorry, there was an error uploading your file.</h3>";
                    return;
                }
            }

            $prod = new Product( $name, $price, $quantity, array(), $newFilename.".".$fileExtension, array(), $description, $brand, $category, $seller);

            $p->Insert($prod);
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
        echo "<h2>Add Product</h2>";

        try{
            echo "<table>";
            echo "<tr>";
            echo "<th>Product Information</th>";
            echo "</tr>";
            echo "<tr>";
            echo "<td><br> Name: <input type='text' name='ProductName' placeholder='Enter product name'><br><br></td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td><br> Price(tk): <input type='number' name='Price' step='0.01' placeholder='Enter product price'><br><br></td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td><br> Quantity: <input type='number' name='Quantity' placeholder='Enter product quantity' ><br><br></td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td><br>Upload new image: <input type='file' name='image' /><br><br></td>";    
            echo "</tr>";
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

            if (empty($_SESSION["SellerUsername"])){
                echo "<tr><td>";
                echo "<br>";
                echo "Choose seller: ";
                echo "<select name='sellerdropdown'>";
                $seller = $s->getAllSellers();
                if ($seller){
                    while ($brow = $seller->fetch_assoc()){
                        echo "<option value='" . $brow['SellerID'] . "'>" . $brow['Username'] . "</option>";
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
            echo "<td><br> Description: <input type='text' name='Description' placeholder='Enter product description' size='50'> <br><br> </td>";
            echo "</tr>";
            echo "</table>";
            echo "<input class='Button' type='submit' name='AddProduct' value='Add' style='font-size: 35px;'>";
            echo "<input class='Button' type='submit' name='Cancel' value='Cancel' style='font-size: 35px;'>";
            
        }
        catch(Exception $e){
            echo "Error: ".$e->getMessage()."<br";
            echo "Failed to get product information.";
        }
        
    ?>
    </form>
</body>
</html>