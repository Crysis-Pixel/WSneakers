<?php
include("header.html");
include("./database/db.php");
include("./customers/customer.php");
include("./customers/customerService.php");
include("./customers/customerRepository.php");
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link href="login.css" rel="stylesheet" />
    <h1 class="h1">Login Page</h1>
</head>

<body class="body">
    <form action="login.php" method="post">

        <div class="radio-button">

            <label class="custom-radio">
                <input type="radio" name="option" value="Customer" checked="checked">
                Customer
            </label>
            <label class="custom-radio">
                <input type="radio" name="option" value="Seller">
                Seller
            </label>

        </div>
        <br>
        <div class="username">
            <label>Username: </label>
            <input type="text" name="username" placeholder="Username"><br><br>
        </div>
        <div class="password">
            <label>Password: </label>
            <input type="password" name="password" placeholder="Password"><br><br>
        </div>
        <div>
            <input class="loginButton" type="submit" name="loginBtn" value="Login">
        </div>
        <div class="signUp">
            <div class="signUpsellers">
                <a href="sellers_signup.php" class="sign-up-sellers-link">Create sellers account</a>
            </div>
            <div class="signUpCustomer">
                <a href="customer_signup.php" class="sign-up-customers-link">Create customers account</a>
            </div>
        </div>
    </form>
</body>

</html>

<?php
$adminUsername = "admin";
$adminPassword = "123";
if (isset($_POST["loginBtn"])) {
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
    if (!empty($username) && !empty($password)) {        //Check Empty Text Box
        if ($username == $adminUsername)    //Admin Login
        {
            if ($password == $adminPassword) {
                $_SESSION["username"] = $username;
                $_SESSION["password"] = $password;
                header("location: adminpage.php");
            } else {
                echo "wrong admin password!";
            }
        } else                                        //Customer or Seller Login
        {
            if ($_POST["option"] == "Customer") {
                $customer = CustomerService::getInstance()->Login($username, $password);
                if ($customer != null) {
                    $_SESSION["Username"] = $username;
                    $_SESSION["Password"] = $password;
                    header("location: index.php");
                }
            } else if ($_POST["option"] == "Seller") {

                //TO BE CONTINUED

            }
        }
    } else {
        echo "username or password missing";
    }
}
?>