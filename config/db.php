<?php 
    $host = "localhost";
    $dbName = "movies";
    $userName = "root";
    $password = "";

    $conn = mysqli_connect($host, $userName, $password, $dbName);

    if (!$conn) {
        die('Error database conn');
    }
    mysqli_set_charset($conn, 'utf8');

?>