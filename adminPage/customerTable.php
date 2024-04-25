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
        include("../database/db.php");
        include("../customers/customerService.php");
        include("../customers/customerRepository.php");
        include("../customers/customer.php");
        session_start();
        $result = CustomerService::getInstance()->GetAllCustomers();
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tbody>";
                echo "<tr>";
                echo "<th>" . $row['CustomerID'] . "</th>";
                echo "<td>" . $row['Username'] . "</td>";
                echo "<td>" . $row['Phone'] . "</td>";
                echo "<td>" . $row['Birthdate'] . "</td>";
                echo "<td>" . $row['Address'] . "</td>";
                echo "<td>";
                echo "<div>";
                echo "<form action='customerTable.php' method='post'>
                        <input type='hidden' name='editCustomer' value='{$row["CustomerID"]}'>
                        <button class='Button' type='submit'>Edit</button>
                    </form>";
                    echo "<form action='customerTable.php' method='post'>
                        <input type='hidden' name='deleteCustomer' value='{$row["CustomerID"]}'>
                        <button class='Button' type='submit'>Delete</button>
                    </form>";
                echo "</div>";
                echo "</td></tr>";
                echo "</tbody>";
            }
        }
        ?>
    </table>
</body>

</html>

<?php

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