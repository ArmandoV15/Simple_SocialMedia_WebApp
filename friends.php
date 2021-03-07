<?php
	header('Content-type: application/json');
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
	$query = "SELECT user2 FROM Friends WHERE user1=?";
	
	$stmt = $conn->stmt_init();
	$stmt->prepare($query);

	// bind the parameter to the query (s=string)
	$stmt->bind_param("s", $username);

	// execute the statement and bind the result
	$stmt->execute();
	$stmt->bind_result($friend1);
	
	$index = 0;
	
	echo '{';
	while($stmt->fetch()) {
		echo '"friend' . $index . '":"' . $friend1 . '",';
		$index = $index + 1;
	}
	
	$query2 = "SELECT user1 FROM Friends WHERE user2=?";
	$stmt2 = $conn->stmt_init();
	$stmt2->prepare($query2);
	$stmt2->bind_param("s", $username);
	$stmt2->execute();
	$stmt2->bind_result($friend2);
	
	while($stmt2->fetch()) {
		echo '"friend' . $index . '":"' . $friend2 . '",';
		$index = $index + 1;
	}
	echo '"done":""';
	echo '}';
	
	$stmt->close();
	$stmt2->close();
	$conn->close();
?>