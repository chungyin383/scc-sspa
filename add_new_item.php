<?php
include('define_const.php');

if (isset($_POST['table'])) {
	
	// Create connection
	$conn = new mysqli(DB_HOST, DB_USER, DB_PW, DB_NAME);
	
	if (mysqli_connect_error()) {
		die("Database connection failed: " . mysqli_connect_error());
	}
	mysqli_set_charset($conn, "utf8");

	$sql = "INSERT INTO sspa_" . $_POST["table"] . "_list (sspa_" . $_POST["table"] . ") VALUES ";
	for ($i=0; $i<count($_POST)-2; $i++){
		$sql .= "('" . $conn->real_escape_string($_POST[$i]) . "'),";
	}
	$sql .= "('" . $conn->real_escape_string($_POST[$i]) . "')";

	if ($conn->query($sql) !== TRUE ){
		echo "Error: " . $conn->error;
	}

	$conn->close();
}
?>