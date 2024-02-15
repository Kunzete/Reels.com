<?php

    $servername = "localhost";
    $username = "root";
    $password = "";
    $db = "reels.com";

    $conn = new MySQLI($servername, $username, $password, $db);

    if (!$conn) {
        die("Error". mysqli_error($conn));
    }
