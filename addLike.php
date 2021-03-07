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
    $postID = $_GET["postId"];
  
    // CHeck if user exist
    $query = "INSERT INTO Likes VALUES (?,?)";
    $stmt = $conn->stmt_init();
	$stmt->prepare($query);
	// bind the parameter to the query (s=string)
	$stmt->bind_param("is", $postID, $username);
    // execute the statement and bind the result
    $stmt->execute();
    echo '{';
    echo '"Like_Added":"1"';
    echo '}';
    $stmt->close();
	$conn->close();
    echo ']';
?>