<?php
include("../database/db.php");
$con = db::getInstance()->getConnection();

$WishlistID = $_POST['WishlistID'];

$sql = "DELETE FROM wishlist WHERE WishlistID = $WishlistID";
mysqli_query($con, $sql);

header("Location: displayWishlist.php");
exit();
