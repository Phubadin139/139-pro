<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "db_it67";

$conn = new mysqli($host, $user, $pass, $dbname);

mysqli_set_charset($conn, "utf8");

if ($conn->connect_error) {
    die("เชื่อมต่อไม่สำเร็จ: " . $conn->connect_error);
}
?>
