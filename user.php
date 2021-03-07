<?php
	header('Content-type: application/json');
	echo '[';
	// get credentials (put your ini file somewhere private
	$config = parse_ini_file("../private/config.ini");
	$server = $config["servername"];
	$username = $config["username"];
	$password = $config["password"];
	$database = $config["database"];

	// connect
	$conn = mysqli_connect($server, $username, $password, $database);

	// check connection
	if (!$conn) {
	  die("Connection failed: " . mysqli_connect_error()); 
	}
	
	$username = $_GET["username"];
	$password = $_GET["password"];
	$query = "SELECT COUNT(*) FROM User WHERE username=? AND password=?";
	
	$stmt = $conn->stmt_init();
	$stmt->prepare($query);

	// bind the parameter to the query (s=string)
	$stmt->bind_param("ss", $username, $password);

	// execute the statement and bind the result
	$stmt->execute();
	$stmt->bind_result($user_exists);
	$stmt->fetch();
	
	echo '{';
	echo '"user_exists":"' . $user_exists . '"';
	echo '}';
	
	$stmt->close();
	$conn->close();
	echo ']';
?>