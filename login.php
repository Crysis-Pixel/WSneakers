<?php
session_start();
if(isset($_SESSION["UserType"])) 
{
    if($_SESSION["UserType"] == "customer")
    {
        header("location: http://localhost/wsneakers/index.php");
    } else if ($_SESSION["UserType"] == "admin")
    {
        header("location: http://localhost/wsneakers/adminPage/adminPage.php");
    } else if($_SESSION["UserType"] == "Seller")
    {
        echo "true";
        header("location: http://localhost/wsneakers/sellerProfile/sellerProfile.php");
    }
    exit();
}
include_once("header.html");
include_once("login.html");
include_once("./database/db.php");
include_once("./customers/customer.php");
include_once("./customers/customerService.php");
include_once("./customers/customerRepository.php");

//added by Mostakim
include_once("./sellers/sellerRepository.php");
//

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

                $_SESSION = array();

                $_SESSION["Username"] = $username;
                $_SESSION["Password"] = $password;
                $_SESSION["UserType"] = "admin";
                header("location: ./adminPage/adminPage.php");
            } else {
                echo "wrong admin password!";
            }
        } else                                        //Customer or Seller Login
        {
            if ($_POST["option"] == "Customer") {
                $customer = CustomerService::getInstance()->Login($username, $password);
                if ($customer != null) {
                    $_SESSION["CustomerID"] = $customer->getCustomerID();
                    $_SESSION["Username"] = $username;
                    $_SESSION["Password"] = $password;
                    $_SESSION["Phone"] = $customer->getPhone();
                    $_SESSION["Birthdate"] = $customer->getBirthdate();
                    $_SESSION["Address"] = $customer->getAddress();
                    $_SESSION["UserType"] = "customer";
                    header("location: index.php");
                }
            } else if ($_POST["option"] == "Seller") {
                
                ///Added by Mostakim
                $s = new SellerRepo();
                $result = $s->verifySeller($username, $password);
                if ($result){
                    $_SESSION["SellerID"] = mysqli_fetch_assoc($result)["SellerID"];
                    $_SESSION["SellerUsername"] = $username;
                    $_SESSION["SellerPassword"] = $password;
                    $_SESSION["UserType"] = "Seller";

                    header("location: ./sellerProfile/sellerProfile.php");
                }

                ///
            }
        }
    } else {
        echo "username or password missing";
    }
}
?>

