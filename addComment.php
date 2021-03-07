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
    $postId = $_GET["postId"];
    $comment = $_GET["comment"];
    $date = $_GET["date"];
    $newComment = str_replace('-', ' ', $comment);


    //Insert into User table
    $query = "SELECT COUNT(*) FROM Comments WHERE post_id = ?";
	$stmt = $conn->stmt_init();
	$stmt->prepare($query);
	// bind the parameter to the query (s=string)
    $stmt->bind_param("i", $postId);
	// execute the statement and bind the result
    $stmt->execute();
    $stmt->bind_result($comment_id);
    $stmt->fetch();
    $comment_id += 1;
    //Insert into userInfo
    $query = "INSERT INTO Comments VALUES (?,?,?,?, CAST('".$date."' AS DATE))";
    $stmt = $conn->stmt_init();
	$stmt->prepare($query);
	// bind the parameter to the query (s=string)
	$stmt->bind_param("iiss", $postId, $comment_id, $newComment, $username);
	// execute the statement and bind the result
    $stmt->execute();
    echo '{';
    echo '"comment_added":"1"';
    echo '}';
    $stmt->close();
    $conn->close();
    echo ']';
?>