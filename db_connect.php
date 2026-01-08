<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "hotel_guest_db"; 
$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>