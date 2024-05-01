<?php
    include ("../header.html");
    include("../database/db.php"); //had to include directory like this else it was not working
    include("../brand/brandService.php");
    $b = new BrandService();
    if (isset($_POST["GoBack"])){
        header("location: brandpage.php");
        exit;
    }
    if (isset($_POST["DeleteBrand"])){
        if (isset($_POST['brand_id'])){
            $b->Delete($_POST['brand_id']);
        }
        else{
            echo "<h3> Failed to delete brand.</h3>";
        }
        header("location: brandpage.php");
        exit;
    }
    if (isset($_POST["SaveItem"])){

        $name = filter_input(INPUT_POST, "BrandName", FILTER_SANITIZE_SPECIAL_CHARS);

        if (!empty($name)){

            $brnd = new Brand($name);

            $b->Update($brnd, $_POST['brand_id']);
        }
        else{
            echo "<h3> Field cannot be empty.</h3>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="brandstyles.css">
    <title>Document</title>
</head>
<body class = 'body'>
    <form role="form" method="post"> 
    <?php
        echo "<h2>Brand Edit</h2>";
        try{
            if (isset($_POST['brand_id'])){
                $result = $b->GetBrand($_POST['brand_id']);
            }
            else{
                echo "Failed to get brand.";
                return;
            }
            $row = $result->fetch_assoc();
            echo "<table>";
            echo "<tr>";
            echo "<th>Edit Information</th>";
            echo "</tr>";
            echo "<tr>";
            echo "<td><br> Name: <input type='text' name='BrandName' value='". htmlspecialchars($row["Name"])."'><br><br></td>";
            echo "</tr>";
            echo "</table>";
            echo "<input class='Button' type='submit' name='DeleteBrand' value='Delete Brand' style='font-size: 35px;'>";
            echo "<input class='Button' type='submit' name='GoBack' value='Done' style='font-size: 35px;'>";
            echo "<input class='Button' type='submit' name='SaveItem' value='Save changes' style='font-size: 35px;'>"; 
        }
        catch(Exception $e){
            echo "Error: ".$e->getMessage()."<br";
            echo "Failed to get brand information.";
        }
        echo "<input type='hidden' name='brand_id' value='{$_POST["brand_id"]}'>"; 
    ?>
    </form>
</body>
</html>