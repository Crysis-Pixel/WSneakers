<?php
    include("./adminPage.html");
    session_start();

    if(isset($_POST["logoutBtn"]))
    {
        session_destroy();
        header("location: ../index.php");
    }
?>