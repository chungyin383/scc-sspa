<?php

header('Content-Type: charset=UTF-8');

$servername = "mysql4.000webhost.com";
$username = "a4045753_pingu";
$password = "pingu123";
$db = "a4045753_pingu";

$conn = new mysqli($servername, $username, $password, $db);

mysqli_set_charset($conn, "utf8");

if (mysqli_connect_error()) {
	die("Database connection failed: " . mysqli_connect_error());
}

$result = $conn->query('SELECT * FROM sspa_basic');
if (!$result) die('Couldn\'t fetch records');
$num_fields = mysqli_num_fields($result);
$headers = array();
while ($fieldinfo = mysqli_fetch_field($result)) {
    $headers[] = $fieldinfo->name;
}

$fp = fopen('php://output', 'w');
if ($fp && $result) {
    header('Content-Type: text/csv');
	date_default_timezone_set("Asia/Hong_Kong");
    header('Content-Disposition: attachment; filename="2017_SSPA_results' . date("Y.m.d h:i:sa") . '.csv"');
    header('Pragma: no-cache');
    header('Expires: 0');
    fputcsv($fp, $headers);
    while ($row = $result->fetch_array(MYSQLI_NUM)) {
        fputcsv($fp, array_values($row));
    }
}

$conn->close();
?>