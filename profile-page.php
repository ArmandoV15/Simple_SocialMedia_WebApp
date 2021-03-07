<html>
<head>
<link rel="stylesheet" href="css/style.css">
</head>

<body>
	<h1>Profile Page</h1>
	<script>
		function displayButton(currentUser){
			if (currentUser != localStorage.getItem("user")){
				console.log("good");
			
			}else{
				console.log("bad");
			}
		}
	</script>
	<?php
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

		$user = $_GET["username"];

		$query = "SELECT birthday, hometown, school FROM UserInfo WHERE username = ?;";

		$stmt = $conn->stmt_init();
		$stmt->prepare($query);
		$stmt->bind_param("s", $user);
	
		$stmt->execute();
		$stmt->bind_result($DOB, $hometown, $school);
		$stmt->fetch();
		echo "<p>Username: ". $user . "</p>";
		echo "<p>Birthday: " . $DOB . "</p>";
		echo "<p>Hometown: " . $hometown . "</p>";
		echo "<p>School: " . $school . "</p>";
			
		$stmt->close();
		$conn->close();

		echo "<script>displayButton('" . $user . "');</script>";
		echo "<script>var secUser = '" . $user . "';</script>";
	?>

	<script>
		var tempUser = secUser;
		var currUser = localStorage.getItem("user");

		function didAdd(json){
			if(json[0].friend_added === "1"){
				document.getElementById('error').innerHTML = 'Friend Added';
			}else{
				document.getElementById('error').innerHTML = 'You are already friends';
			}
		}

		function addFriend(){
			if (currUser == tempUser){
				document.getElementById('error').innerHTML = 'You can not friend yourself!!!';
			}else{
				var url = 'http://barney.gonzaga.edu/~avaldez/addFriend.php/?username=';
				url += currUser;
				url += "&tempUser=";
				url += tempUser;
				url += "&date=";
        		let today = new Date().toISOString().slice(0, 10);
				url += today;
				console.log(url);
        		var a = fetch(url)
				.then(response => response.json())
	  			.then(json => didAdd(json))
    			.catch(err => console.log('Request Failed: ', err))
			}
		}
	</script>

	<p>Total number of friends: 
	<?php
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

		$user = $_GET["username"];

		$query = "SELECT COUNT(*) FROM Friends WHERE user1 = ? OR user2=?;";

		$stmt = $conn->stmt_init();
		$stmt->prepare($query);
		$stmt->bind_param("ss", $user, $user);
	
		$stmt->execute();
		$stmt->bind_result($num_friends);
		$stmt->fetch();
		
		echo "" . $num_friends . "";
			
		$stmt->close();
		$conn->close();
	?>
	</p>
	<button id='friend-button' onclick="addFriend()">Add Friend</button>
	<div id="error"></div>
	<h3>USER STATS</h3>
	
	<p>This user's popular post:
		<?php
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

			$user = $_GET["username"];

			$query = 'SELECT post_id, COUNT(*) FROM Likes JOIN Posts p USING(post_id) WHERE p.username = ? GROUP BY p.post_id HAVING COUNT(*) > (SELECT AVG(likes) FROM (SELECT COUNT(*) as likes FROM Likes JOIN Posts p USING(post_id) GROUP BY post_id) as t1) ORDER BY COUNT(*) DESC;';

			$stmt = $conn->stmt_init();
			$stmt->prepare($query);
			$stmt->bind_param("s", $user);
		
			$stmt->execute();
			$stmt->bind_result($post_id, $num_likes);
			$stmt->fetch();
			
			echo " post " . $post_id . " has " . $num_likes . " likes";
				
			$stmt->close();
			$conn->close();
		?>
	</p>
	
	<p>This user has 
		<?php
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

			$user = $_GET["username"];

			$query = 'SELECT ((SELECT COUNT(*) FROM Posts WHERE username=?) + (SELECT COUNT(*) FROM Comments WHERE username=?));';

			$stmt = $conn->stmt_init();
			$stmt->prepare($query);
			$stmt->bind_param("ss", $user, $user);
		
			$stmt->execute();
			$stmt->bind_result($user_posts);
			$stmt->fetch();
			
			echo "" . $user_posts . "";
				
			$stmt->close();
			$conn->close();
		?>
		 total contributions
	</p>
	<p>Average number of contributions: 
		<?php
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

			$user = $_GET["username"];

			$query = "SELECT COUNT(username)/total_users FROM ((SELECT username FROM Posts UNION ALL SELECT username FROM Comments)) t1, (SELECT COUNT(*) as total_users FROM User) t2;";

			$stmt = $conn->stmt_init();
			$stmt->prepare($query);
		
			$stmt->execute();
			$stmt->bind_result($avg_posts);
			$stmt->fetch();
			
			echo "" . $avg_posts . "";
				
			$stmt->close();
			$conn->close();
		?>
	</p>
</body>