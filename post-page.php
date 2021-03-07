<html>
<head>
<link rel="stylesheet" href="css/style.css">
</head>
<script>
    function addPost(){
        var url = 'http://barney.gonzaga.edu/~avaldez/addPost.php/?username=';
        url += localStorage.getItem("user");
        var comment = document.getElementById("post_content").value;
        var replaced = comment.split(' ').join('-');
        url += "&content=";
        url += replaced;
        url += "&date=";
        let today = new Date().toISOString().slice(0, 10);
        url += today;
        console.log(url);
        var a = fetch(url)
		.then(response => response.json())
	  	.then(json => loadPost(json))
    	.catch(err => console.log('Request Failed: ', err))
    }

    function loadPost(json){
        if(json[0].post_added === "1"){
			window.location.href = 'http://barney.gonzaga.edu/~avaldez/homepage.php';
		}
    }
</script>

<body>
	<h1>Create Post</h1>
	<label for="post_comment">New Post:</label>
    <br>
    <textarea id="post_content" name="post_content" rows="4" cols="50"></textarea>
    <br>
    <button onclick='addPost()'>Post</button>
</html>
</body>