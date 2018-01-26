<?php
include('define_const.php');

$conn = new mysqli(DB_HOST, DB_USER, DB_PW, DB_NAME);
if (mysqli_connect_error()) {
	die("Database connection failed: " . mysqli_connect_error());
}
mysqli_set_charset($conn, "utf8");

/* Bind parameters. Types: s = string, i = integer, d = double,  b = blob */
$all_params = array();
 
$param_type = '';
$n = count($_POST)-1;
for($i = 0; $i < $n; $i++) {
	$param_type .= 's';
}
$param_type .= 'i';

/* with call_user_func_array, array params must be passed by reference */
$temp1 = array($param_type);
$temp2 = array_merge($temp1,$_POST);
$all_params = & $temp2;

/* Generate sql statement */
$sql = "INSERT INTO sspa_main VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

/* Prepare statement */
$stmt = $conn->prepare($sql);
if($stmt === false) {
	trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->errno . ' ' . $conn->error, E_USER_ERROR);
}

/* use call_user_func_array, as $stmt->bind_param('s', $param); does not accept params array */
call_user_func_array(array($stmt, 'bind_param'), $all_params);

if (!$stmt->execute()) {
    echo "Error occured: (" . $stmt->errno . ") " . $stmt->error;
}
$conn->close();

?>