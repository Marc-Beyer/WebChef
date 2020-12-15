<?php
    // Login data change this info
    $servername = "localhost";
    $username = "minemes";
    $password = "Familie";
    $dbname = "web_chef";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>