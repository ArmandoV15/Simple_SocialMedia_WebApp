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
    $content = $_GET["content"];
    $date = $_GET["date"];
    $newContent= str_replace('-', ' ', $content);


    $query = "SELECT COUNT(*) FROM Posts WHERE post_id != 0";
	$stmt = $conn->stmt_init();
	$stmt->prepare($query);

    $stmt->execute();
    $stmt->bind_result($postId);
    $stmt->fetch();
    $postId += 1;
    //Insert into userInfo
    $query = "INSERT INTO Posts VALUES (?,?,?, CAST('".$date."' AS DATE))";
    $stmt = $conn->stmt_init();
	$stmt->prepare($query);
	// bind the parameter to the query (s=string)
	$stmt->bind_param("iss", $postId, $username, $newContent);
	// execute the statement and bind the result
    $stmt->execute();
    echo '{';
    echo '"post_added":"1"';
    echo '}';
    $stmt->close();
    $conn->close();
    echo ']';
?>