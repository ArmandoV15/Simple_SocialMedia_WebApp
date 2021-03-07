<html>
<head>
<link rel="stylesheet" href="css/style.css">
<script>

	function viewOwnProfile() {
		var url = 'http://barney.gonzaga.edu/~avaldez/profile-page/?username=';
		url += localStorage.getItem("user");
		console.log('url: ', url);
		window.location.href = url;
	}
	
	function searchProfile() {
		var url = 'http://barney.gonzaga.edu/~avaldez/profile-page/?username=';
		url += document.getElementById("search-field").value;
		console.log('url: ', url);
		window.location.href = url;
	}
	
	function logout() {
		localStorage.removeItem("user");
		window.location.href = "http://barney.gonzaga.edu/~avaldez/login.php";
	}

	function addLike(postId){
		var url = 'http://barney.gonzaga.edu/~avaldez/addLike.php/?username=';
		url += localStorage.getItem("user");
		url += '&postId=';
		url += postId;
		var a = fetch(url)
		.then(response => response.json())
	  	.then(json => relaodHome(json))
    	.catch(err => console.log('Request Failed: ', err))
	}

	function relaodHome(json){
		if(json[0].Like_Added === "1"){
			window.location.reload();
		}
	}

	function writeComment(postId){
		localStorage.setItem("postId", postId);
		window.location.href = 'http://barney.gonzaga.edu/~avaldez/comment-page.php';
	}

	function createPost(){
		window.location.href = 'http://barney.gonzaga.edu/~avaldez/post-page.php';
	}
	
</script>
</head>

<body>
	<h1>Homepage</h1>
	<h2 id="hi"><h2>
	<div id="search">
		<input id="search-field" type='text' placeholder="Find a user..."> </input>
		<button onclick="searchProfile()">Search</button> 
	<div>
	<button class='top-marg' onclick="viewOwnProfile()">View your profile</button>
	<button class='top-marg' onclick="createPost()">New Post</button>
	<button class='top-marg' onclick="logout()">Logout</button>
	
	
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
		
		$query = "SELECT p.post_id, p.content, p.username, c.content, c.username, (SELECT COUNT(*) FROM Likes l WHERE l.post_id=p.post_id) FROM Posts p LEFT OUTER JOIN Comments c USING(post_id)";
		
		$stmt = $conn->stmt_init();
		$stmt->prepare($query);

		// execute the statement and bind the result
		$stmt->execute();
		$stmt->bind_result($post_id, $content, $username, $comment_content, $comment_user, $likes);
		
		while($stmt->fetch()) {
			if($post_id == 1 && $previous_post != $post_id) {
				echo '<div class="post">';
				echo '<h3>' . $username . '</h3>';
				echo '<div class="post-inner"><p class="post-text">';
				echo $content . '</p>';
				echo "<p>Likes: " . $likes . " <button onclick='addLike(" . $post_id . ")'>Like</button></p>";
				echo '<p>Comments:</p>';
				echo "<button onclick='writeComment(" .$post_id. ", )'>Add your comment...</button>";
				$previous_post = $post_id;
			}
			else if($post_id != $previous_post) {
				echo '</div></div>';
				echo '<div class="post">';
				echo '<h3>' . $username . '</h3>';
				echo '<div class="post-inner"><p class="post-text">';
				echo $content . '</p>';
				echo "<p>Likes: " . $likes . " <button onclick='addLike(" . $post_id . ")'>Like</button></p>";
				echo '<p>Comments:</p>';
				echo "<button onclick='writeComment(" .$post_id. ", )'>Add your comment...</button>";
				$previous_post = $post_id;
			}
			echo '<p>' . $comment_user . '<br>' . $comment_content . '</p>';
		}
		$stmt->close();
		$conn->close();
	?>
	
	<div id='friend-list'>
		<p>Your friends:</p>
		<ul id="friendsss">
		</ul>
	</div>
	
</html>

<script>
	if(localStorage.getItem("user") == null)
		window.location.href = "http://barney.gonzaga.edu/~avaldez/login.php";
	
	document.getElementById("hi").innerHTML = 'Hello ' + localStorage.getItem("user");

	var url = 'http://barney.gonzaga.edu/~avaldez/friends.php/?username=';
	url += localStorage.getItem("user");
	console.log('url: ', url);
	var a = fetch(url)
	.then(response => response.json())
	.then(json => displayFriends(json))
	.catch(err => console.log('Request Failed: ', err))
			
	function displayFriends(json) {
		for (var key in json) {
			var x = document.createElement("li");
			document.getElementById("friendsss").appendChild(x);
			x.innerHTML = json[key] + "</li>";
		}
	}
	
</script>
</body>