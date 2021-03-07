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
	
    $currUser = $_GET["username"];
    $tempUser = $_GET["tempUser"];
    $date = $_GET["date"];
   
    //Insert into User table
    $query = "SELECT COUNT(*) FROM Friends";
	$stmt = $conn->stmt_init();
    $stmt->prepare($query);
    
    $stmt->execute();
    $stmt->bind_result($old_Friend);
    $stmt->fetch();
    $query = "INSERT INTO Friends VALUES (?,?, CAST('".$date."' AS DATE))";
    $stmt = $conn->stmt_init();
	$stmt->prepare($query);

	$stmt->bind_param("ss", $currUser, $tempUser);
	
    $stmt->execute();

    $query = "SELECT COUNT(*) FROM Friends";
	$stmt = $conn->stmt_init();
    $stmt->prepare($query);
    
    $stmt->execute();
    $stmt->bind_result($new_Friend);
    $stmt->fetch();
    if($old_Friend == $new_Friend){
    echo '{';
    echo '"friend_added":"0"';
    echo '}';
    $stmt->close();
    $conn->close();
    echo ']';
    }else{
        echo '{';
        echo '"friend_added":"1"';
        echo '}';
        $stmt->close();
        $conn->close();
        echo ']';
    }
?>