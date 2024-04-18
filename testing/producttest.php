<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/WSneakers/products/tablestyles.css">
</head>
<body>
   <?php
    include("/xampp/htdocs/WSneakers/database/db.php"); //had to include directory like this else it was not working
    include("/xampp/htdocs/WSneakers/products/productService.php");
    $p = new ProductService();
    //product will be added/updated through an object like this
    $prod = new Product("Nike Air Force One", 450.19, 5, array("Blue", "Gray", "Black"),"5.gif",[41,42,43],"Best of Nike! Better than Adidas!");
    //$p->Insert($prod);
    //$p->Delete(4);
    //$p->Search("Nike");
    //$p->Update($prod,4);
    $p->GetAll(); //gets all products
    ?> 
</body>
</html>

