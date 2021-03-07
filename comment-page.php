

<html>
<head>
<link rel="stylesheet" href="css/style.css">
</head>
<script>
    console.log(localStorage.getItem("postId"));

    function addComment(){
        var url = 'http://barney.gonzaga.edu/~avaldez/addComment.php/?username=';
        url += localStorage.getItem("user");
        url += "&postId=";
        url += localStorage.getItem("postId");
        var comment = document.getElementById("post_comment").value;
        var replaced = comment.split(' ').join('-');
        url += "&comment=";
        url += replaced;
        url += "&date=";
        let today = new Date().toISOString().slice(0, 10);
        url += today;
        console.log(url);
        var a = fetch(url)
		.then(response => response.json())
	  	.then(json => loadComment(json))
    	.catch(err => console.log('Request Failed: ', err))
    }

    function loadComment(json){
        if(json[0].comment_added === "1"){
            localStorage.removeItem("postId");
			window.location.href = 'http://barney.gonzaga.edu/~avaldez/homepage.php';
		}
    }
</script>

<body>
	<h1>Write Comment</h1>
	<label for="post_comment">Comment for post:</label>
    <br>
    <textarea id="post_comment" name="post_comment" rows="4" cols="50"></textarea>
    <br>
    <button onclick='addComment()'>Post</button>
</html>
</body>