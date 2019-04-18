<?php

	//Grab the DB parameter details from the config file, which is hidden from browsers.
	require "../config/config.php";
	
	//Connect to the host. The parameters to mysqli_connect() come from config.php
	$conn = mysqli_connect($host, $username, $password) or die("Error: failed to connect to host.");
	
	//Create the database. The name of the database comes from config.php
	$dbcreate = "CREATE DATABASE ". $database;
	if($conn->query($dbcreate) === TRUE) {
		echo "Success: database created.";
	}
	else {
		echo "Error: ". $conn->error;
	}
	
	//Close the connection to the host.
	mysqli_close($conn);
	
	//Provide a link back to the index page.
	echo "<br><a href=\"index.html\"> Return to the index page. </a>";

?>