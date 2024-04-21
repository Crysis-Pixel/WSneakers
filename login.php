<?php
include_once("header.html");
include_once("login.html");
include_once("./database/db.php");
include_once("./customers/customer.php");
include_once("./customers/customerService.php");
include_once("./customers/customerRepository.php");
session_start();
?>

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
                    $_SESSION["Phone"] = $customer->getPhone();
                    $_SESSION["Birthdate"] = $customer->getBirthdate();
                    $_SESSION["Address"] = $customer->getAddress();
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