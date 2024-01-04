<?php
	const DBHOST = 'localhost:3306';
	const DBUSER = 'root';
	const DBPASS = '';
	const DBNAME = 'artic';

	$conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

	if ($conn->connect_error) {
	  die('Could not connect to the database!' . $conn->connect_error);
	}
?>