<?php
    session_start();
    include("./adminSessionAccess.php");
    include("./adminPage.html");

    if(isset($_POST["logoutBtn"]))
    {
        session_destroy();
        header("location: ../index.php");
    }
?>