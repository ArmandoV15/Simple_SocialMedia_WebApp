<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<script>

  function redirectUser(json) {
	  if(json[0].user_exists === "1") {
		  window.location.href = "http://barney.gonzaga.edu/~avaldez/homepage.php";
	  } else {
		  document.getElementById('wrong-password').innerHTML = 'Wrong username or password';
	  }
  }

  function userAction() {
    var url = 'http://barney.gonzaga.edu/~avaldez/user.php/?username=';
    url += document.getElementById('username-field').value;
	  localStorage.setItem("user", document.getElementById('username-field').value);
    url += '&password=';
    url += document.getElementById('password-field').value;
    console.log('url: ', url);
    var a = fetch(url)
    .then(response => response.json())
	  .then(json => redirectUser(json))
    .catch(err => console.log('Request Failed: ', err))
  }


  function registerPage(){
    window.location.href = "http://barney.gonzaga.edu/~avaldez/register.php";
  }
</script>

<body>
  <main id="main-holder">
    <h1 id="login-header">Login</h1>


    <div id="form-grid">
		<input type="text" name="username" id="username-field" class="login-form-field" placeholder="Username"></input>
		<input type="password" name="password" id="password-field" class="login-form-field" placeholder="Password"></input>
		<button type="submit" class="login-form-field" id="login-form-submit" onclick="userAction()">Login</button>
    <button type="submit" class="login-form-field" id="login-form-submit" onclick="registerPage()">Register</button>
	  </div>
 
	 <div id="wrong-password">
    </div>
 
  </main>
</body>
</html>


