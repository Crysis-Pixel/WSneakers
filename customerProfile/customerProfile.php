<?php
include_once("../header.html");
session_start();
include("../customers/customerSessionAccess.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="customerProfile.css" rel="stylesheet" />
    <h1 class="h1">Your Profile</h1>
</head>
<body>
    <style>
        .no-border table,
        .no-border tr,
        .no-border td {
            border: none;
        }
    </style>
    <table class='no-border'>
        <tr>
            <td style="font-size: 150%;">
                <?php
                    $username = $_SESSION["Username"];
                    $phone = $_SESSION["Phone"];
                    $birthdate = $_SESSION["Birthdate"];
                    $address = $_SESSION["Address"];
                    echo "Username: " . $username . "<br>";
                    echo "Phone Number: " . $phone . "<br>";
                    echo "Birthdate: " . $birthdate . "<br>";
                    echo "Address: " . $address . "<br>";
                ?>
            </td>
            <td>
                <form action='../wishlist/displayWishlist.php' method='post'>
                    <button type=submit class='Button' style="font-size: 250%;">Your Wishlist &#128153</button>
                </form>
                <form action='customerorders.php' method='post'>
                    <button type=submit class='Button' style="font-size: 250%;">Your orders &#128666</button>
                </form>
                <form action='../customers/editCustomerPage.php' method='post'>
                    <button type=submit class='Button' name="editBtn" style="font-size: 250%;">Edit Information ✏️</button>
                </form>
            </td>
        </tr>
    </table>
</body>
</html>