<?php
include('define_const.php');
header('Content-Type: charset=UTF-8');

$conn = new mysqli(DB_HOST, DB_USER, DB_PW, DB_NAME);
mysqli_set_charset($conn, "utf8");
if (mysqli_connect_error()) {
	die("Database connection failed: " . mysqli_connect_error());
}

$sql = "SELECT chi_name FROM sspa_basic WHERE id = " . $_POST['id'];
$result = $conn->query($sql)->fetch_assoc();
echo $result['chi_name'];
$conn->close();
?>