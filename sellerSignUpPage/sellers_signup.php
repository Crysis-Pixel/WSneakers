<?php
include("../header.html");
include("../database/db.php");
include("../sellerSignUpPage/sellers_signup.html");
?>

<?php
if (isset($_POST["submit"])) {
    if (empty($_POST["phone"]) || empty($_POST["username"]) || empty($_POST["password"])) {
        echo "Please fillup the sign up form";
    } else {
        $con = db::getInstance()->getConnection();
        $phone = filter_input(INPUT_POST, "phone", FILTER_SANITIZE_SPECIAL_CHARS);
        $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

        $checkDuplicateUsername = "SELECT Username FROM seller WHERE Username = '$username'";
        $result = mysqli_query($con, $checkDuplicateUsername);

        if (mysqli_num_rows($result) > 0) {
            echo "The Username already exists";
        } else {
            // $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $hashedPassword = $password;
            $sql = "INSERT INTO seller (Username, Pwd) VALUES('$username', '$hashedPassword')";

            if (mysqli_query($con, $sql)) {
                $sellerID = mysqli_insert_id($con);
                $sql2 = "INSERT INTO seller_phonenumbers (SellerID, Phone_Number) VALUES('$sellerID', '$phone')";

                if (mysqli_query($con, $sql2)) {
                    echo "User is now registered";
                } else {
                    echo "Could not register phone number";
                }
            } else {
                echo "Could not register user";
            }
        }
    }
}
?>

