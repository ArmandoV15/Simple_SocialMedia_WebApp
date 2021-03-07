<?php
        header('Content-type: application/json');
        echo '[';
        $config = parse_ini_file("../private/config.ini");
		$server = $config["servername"];
		$username = $config["username"];
		$password = $config["password"];
		$database = $config["database"];
	  
		  // connect
		  $conn = mysqli_connect($server, $username, $password, $database);
	  
		  // check connection
		  if (!$conn) {
		  die('Error: ' . mysqli_connect_error());
			  console.log("error"); 
		  }

			$user = $_GET["username"];

		  // the query
		  	$query = "SELECT birthday, hometown, school FROM UserInfo WHERE username = ?;";

			$stmt = $conn->stmt_init();
            $stmt->prepare($query);
            $stmt->bind_param("s", $user);
	 	
		  	$stmt->execute();
			$stmt->bind_result($DOB, $hometown, $school);
            $stmt->fetch();
            echo '{';
            echo '"username":"' . $user . '", ';
            echo '"DOB":"' . $DOB . '", ';
            echo '"hometown":"' . $hometown . '", ';
            echo '"school":"' . $school . '"';
            echo '}';
                
            $stmt->close();
            $conn->close();
            echo ']';
    ?>