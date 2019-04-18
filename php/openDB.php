<?php
	require "../config/config.php";
	$conn = mysqli_connect($host, $username, $password) or die("Could not connect.");
	mysqli_select_db($conn, $database);
?>