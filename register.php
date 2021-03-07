<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<script>

  function redirectUser(json) {
	  if(json[0].user_created === "0") {
		  window.location.href = "http://barney.gonzaga.edu/~avaldez/homepage.php";
	  } else {
		  document.getElementById('wrong-password').innerHTML = 'Username already exist!';
	  }
  }

  function userAction() {
    var url = 'http://barney.gonzaga.edu/~avaldez/registerUser.php/?username=';
    url += document.getElementById('username-field').value;
	  localStorage.setItem("user", document.getElementById('username-field').value);
    url += '&birthday=';
    url += document.getElementById('birthday-field').value;
    url += '&hometown=';
    var homeTown = document.getElementById('hometown-field').value;
    var newHomeTown = homeTown.split(" ").join('-');
    url += newHomeTown;
    url += '&school=';
    var school = document.getElementById('school-field').value;
    var newSchool = school.split(" ").join('-');
    url += newSchool;
    url += '&password=';
    url += document.getElementById('password-field').value;
    console.log('url: ', url);
    var a = fetch(url)
    .then(response => response.json())
	  .then(json => redirectUser(json))
    .catch(err => console.log('Request Failed: ', err))
  }

  function gotToLogin(){
    window.location.href = "http://barney.gonzaga.edu/~avaldez/login.php";
  }
</script>

<body>
  <main id="main-holder">
    <h1 id="login-header">Register</h1>


    <div id="form-grid">
		<input type="text" name="username" id="username-field" class="login-form-field" placeholder="Username"></input>
        <input type="text" name="birhtday" id="birthday-field" class="login-form-field" placeholder="Birthday (YY-MM-DD)"></input>
        <input type="text" name="hometown" id="hometown-field" class="login-form-field" placeholder="Hometown"></input>
        <input type="text" name="school" id="school-field" class="login-form-field" placeholder="School"></input>
		    <input type="password" name="password" id="password-field" class="login-form-field" placeholder="Password"></input>
        <button type="submit" class="login-form-field" id="login-form-submit" onclick="userAction()">Register</button>
        <button type="submit" class="login-form-field" id="login-form-submit" onclick="gotToLogin()">Login</button>
	  </div>
 
	 <div id="wrong-password">
    </div>
 
  </main>
</body>
</html>


