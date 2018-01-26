<?php

header('Content-Type: charset=UTF-8');

$servername = "mysql4.000webhost.com";
$username = "a4045753_pingu";
$password = "pingu123";
$db = "a4045753_pingu";

// Create connection
$conn = new mysqli($servername, $username, $password, $db);
//change character set
mysqli_set_charset($conn, "utf8");
// Check connection
if (mysqli_connect_error()) {
	die("Database connection failed: " . mysqli_connect_error());
}
$sql = "SELECT chi_name FROM sspa_basic WHERE id = " . $_POST['id'];
$result = $conn->query($sql)->fetch_assoc();
echo $result['chi_name'];
$conn->close();
?>