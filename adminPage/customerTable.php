<?php
session_start();
include("./adminSessionAccess.php");
include("../database/db.php");
include("../customers/customerService.php");
include("../customers/customerRepository.php");
include("../customers/customer.php");       
if (isset($_POST["editCustomer"])) {
    $_SESSION["editCustomerID"] = $_POST["editCustomer"];
    header("location: ./editCustomer.php");
}
if (isset($_POST["deleteCustomer"])) {
    $customerID = $_POST["deleteCustomer"];
    $isSuccessful = CustomerService::getInstance()->Delete($_POST["deleteCustomer"]);
    if ($isSuccessful)
    {
        header("location: ./customerTable.php");
    }

}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./customerTable.css">
    <a class="admin" href="./adminPage.html">Admin</a>
    <br><br>
</head>

<body>
    <form action="customerTable.php" method="post">
        <div class="sel">

            <label>Search By: </label>
            <input type="text" name="searchUser" placeholder="username">
            <input type="text" name="phone" placeholder="phone">
            <input type="date" name="date" value="">
            <input type="text" name="address" placeholder="address">
            <label>Sort By: </label>
            <Select name="select" value = "id">
                <option value="ID ASC">ID ASC</option>
                <option value="ID DESC">ID DESC</option>
                <option value="Username ASC">Username ASC</option>
                <option value="Username DESC">Username DESC</option>
            </Select>
            <input type="submit" name="searchBtn" value="Search">
        </div>
    </form>
    
    <table>
        <caption>Customer List</caption>
        
        <thead>
            <tr>
                <th>CustomerID</th>
                <th>Username</th>
                <th>Phone</th>
                <th>Birthdate</th>
                <th>Address</th>
                <th>Action</th>
            </tr>
        </thead>
        <?php
         
        $result = CustomerService::getInstance()->GetAllCustomers(); // default full table

        if(isset($_POST["searchBtn"]))
        {
            $username = "";
            $phone = "";
            $date = "";
            $address = "";
            $username = $_POST["searchUser"];
            $phone = $_POST["phone"];            
            $address = $_POST["address"];
            $sortType = $_POST["select"];
            if(isset($_POST["date"]))
            {
                $date = $_POST["date"];
            }
            $r = CustomerService::getInstance()->searchCustomer($username, $phone, $date, $address, $sortType);
            if($r != null)
            {
                $result = $r;
            }
        
            echo "<caption style='caption-side: top; padding-bottom: 2%;;'> Sorted By $sortType" ."ENDING Order</caption>";
        
        }

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tbody>";
                echo "<tr>";
                echo "<th>" . $row['CustomerID'] . "</th>";
                echo "<td>" . $row['Username'] . "</td>";
                echo "<td>" . $row['Phone'] . "</td>";
                echo "<td>" . $row['Birthdate'] . "</td>";
                echo "<td>" . $row['Address'] . "</td>";
                echo "<td>";
                echo "<div class = 'but1'>";
                echo "<form action='customerTable.php' method='post'>
                        <input type='hidden' name='editCustomer' value='{$row["CustomerID"]}' >
                        <button class='Button' type='submit'>Edit</button>
                    </form>";
                echo "</div>";
                echo "<div class = 'but2'>";
                    echo "<form action='customerTable.php' method='post'>
                        <input type='hidden' name='deleteCustomer' value='{$row["CustomerID"]}' >
                        <button class='Button' type='submit'>Delete</button>
                    </form>";
                echo "</div>";
                echo "</td></tr>";
                echo "</tbody>";
            }
        }
        
        ?>
    </table>
    <script>
        if (typeof window?.history?.replaceState === 'function') {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</body>
</html>
