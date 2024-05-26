<?php
    session_start();
    include("../sellers/sellerSessionAccess.php");
    include ("../header.html");
    include("../database/db.php"); //had to include directory like this else it was not working
    include("../category/categoryService.php");
    $c = new CategoryService();
    if (isset($_POST["GoBack"])){
        header("location: categorypage.php");
        exit;
    }
    if (isset($_POST["DeleteCategory"])){
        if (isset($_POST['category_id'])){
            $c->Delete($_POST['category_id']);
        }
        else{
            echo "<h3> Failed to delete brand.</h3>";
        }
        header("location: categorypage.php");
        exit;
    }
    if (isset($_POST["SaveItem"])){

        $name = filter_input(INPUT_POST, "CategoryName", FILTER_SANITIZE_SPECIAL_CHARS);

        if (!empty($name)){

            $category = new Category($name);

            $c->Update($category, $_POST['category_id']);
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
    <link rel="stylesheet" href="categorystyles.css">
    <title>Document</title>
</head>
<body class = 'body'>
    <form role="form" method="post"> 
    <?php
        echo "<h2>Category Edit</h2>";
        try{
            if (isset($_POST['category_id'])){
                $result = $c->getCategory($_POST['category_id']);
            }
            else{
                echo "Failed to get category.";
                return;
            }
            $row = $result->fetch_assoc();
            echo "<table>";
            echo "<tr>";
            echo "<th>Edit Information</th>";
            echo "</tr>";
            echo "<tr>";
            echo "<td><br> Name: <input type='text' name='CategoryName' value='". htmlspecialchars($row["Type"])."'><br><br></td>";
            echo "</tr>";
            echo "</table>";
            echo "<input class='Button' type='submit' name='DeleteCategory' value='Delete Category' style='font-size: 35px;'>";
            echo "<input class='Button' type='submit' name='GoBack' value='Go Back' style='font-size: 35px;'>";
            echo "<input class='Button' type='submit' name='SaveItem' value='Save changes' style='font-size: 35px;'>"; 
        }
        catch(Exception $e){
            echo "Error: ".$e->getMessage()."<br";
            echo "Failed to get brand information.";
        }
        echo "<input type='hidden' name='category_id' value='{$_POST["category_id"]}'>"; 
    ?>
    </form>
</body>
</html>