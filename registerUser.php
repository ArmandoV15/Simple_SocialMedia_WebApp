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
    $birthday = $_GET["birthday"];
    $hometown = $_GET["hometown"];
    $school = $_GET["school"];
    $password = $_GET["password"];
    $newHometown = str_replace('-', ' ', $hometown);
    $newSchool = str_replace('-', ' ', $school);

    // CHeck if user exist
    $query = "SELECT COUNT(*) FROM User WHERE username = ?";
    $stmt = $conn->stmt_init();
	$stmt->prepare($query);
	// bind the parameter to the query (s=string)
	$stmt->bind_param("s", $username);
    // execute the statement and bind the result
    $stmt->execute();
    $stmt->bind_result($user_exists);
    $stmt->fetch();
    if($user_exists === 1){
        echo '{';
        echo '"user_created":"1"';
        echo '}';
        $stmt->close();
	    $conn->close();
        echo ']';
    }else{
        //Insert into User table
        $query = "INSERT INTO User VALUES (?,?)";
	    $stmt = $conn->stmt_init();
	    $stmt->prepare($query);
	    // bind the parameter to the query (s=string)
	    $stmt->bind_param("ss", $username, $password);
	    // execute the statement and bind the result
        $stmt->execute();
        //Insert into userInfo
        $query = "INSERT INTO UserInfo VALUES (?,?,?,?)";
        $stmt = $conn->stmt_init();
	    $stmt->prepare($query);
	    // bind the parameter to the query (s=string)
	    $stmt->bind_param("ssss", $username, $birthday, $newHometown, $newSchool);
	    // execute the statement and bind the result
        $stmt->execute();
        echo '{';
        echo '"user_created":"0"';
        echo '}';
        $stmt->close();
        $conn->close();
        echo ']';
    }
?>