<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SilverIron</title>
<link rel="stylesheet" href="assets/css/login.css">
</head>
<body>

<div class="container">
  <h2>Login</h2>
  <form id="loginForm">
    <div class="input-group">
      <label for="username">Username</label>
      <input type="text" id="username" name="username" required>
    </div>
    <div class="input-group">
      <label for="password">Password</label>
      <input type="password" id="password" name="password" required>
    </div>
    <button type="submit" class="btn">Login</button>  
    <p class="register-link">Don't have an account? <a href="register_form.html">Register here</a>.</p>
  </form>
</div>

<script>
 document.getElementById('loginform').addEventListener('submit', function(event){
        event.preventDefault();
        var email = document.getElementById('email').value;
        var password = document.getElementById('password').value;

        var datum = {
            email: email,
            password: password,
        }

        fetch("/api/login", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + localStorage.getItem('tokens') // Added space after 'Bearer'
            },
            body: JSON.stringify(datum),
        }).then((res)=> {
            return res.json();
        }).then(data => {
            console.log(data);
            if(data.access_token) {
                localStorage.setItem('tokens', data.access_token);
                window.location.href = '/home';
            } else {
                document.getElementById('message').innerText = data.message;
                document.getElementById('message').style.color = 'red';
            }
        }).catch(error => {
            console.error("Something went wrong!!", error);
        });
    });
  
</script>


<script src="assets/js/login.js"></script>


</body>
</html>



