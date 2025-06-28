<?php
    $con = mysqli_connect("localhost", "root", "", "erasmus_db");

    if (!$con) {
        echo "Connection failed: " . mysqli_connect_error();
    }
?>