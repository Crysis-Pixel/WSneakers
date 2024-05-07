<?php
    include ("../header.html");
    include("../database/db.php"); //had to include directory like this else it was not working
    include("../category/categoryService.php");
    $c = new CategoryService();

    if (isset($_POST['Cancel'])){
        header("location: ../category/categoryPage.php");
        exit;
    }

    if (isset($_POST['AddCategory'])){
        $name = filter_input(INPUT_POST, "CategoryName", FILTER_SANITIZE_SPECIAL_CHARS);

        if (!empty($name)){
            $category = new Category($name);
            $c->Insert($category);
        }
        else{
            echo "<h3>Field cannot be empty.</h3>"; 
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
        echo "<h2>Add Category</h2>";
        try{
            echo "<table>";
            echo "<tr>";
            echo "<th>Category Information</th>";
            echo "</tr>";
            echo "<tr>";
            echo "<td><br> Name: <input type='text' name='CategoryName' placeholder='Enter category name'><br><br></td>";
            echo "</tr>";
            echo "</table>";
            echo "<input class='Button' type='submit' name='AddCategory' value='Add' style='font-size: 35px;'>";
            echo "<input class='Button' type='submit' name='Cancel' value='Cancel' style='font-size: 35px;'>";
            
        }
        catch(Exception $e){
            echo "Error: ".$e->getMessage()."<br";
            echo "Failed to get brand information.";
        }
    ?>
    </form>
</body>
</html>