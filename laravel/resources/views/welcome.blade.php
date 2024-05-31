<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SilverIron</title>
<link rel="stylesheet" href="assets/css/login.css">
<link rel="stylesheet" href="assets/css/otp.css">


<style>
  /* Additional CSS styles */
  .otp-container {
    display: none; /* Hide the OTP container initially */
  }
</style>

</head>
<body>

<div class="container">
  <h2>Login</h2>
  <form id="loginForm">
    <div class="input-group">
      <label for="email">Email</label>
      <input type="email" id="email" name="email" required>
    </div>
    <div class="input-group">
      <label for="password">Password</label>
      <input type="password" id="password" name="password" required>
    </div>
    <button type="submit" class="btn" id="loginBtn">Login</button>  
    <p id="message" class="message"></p>
    <p class="register-link">Don't have an account? <a href="register_form.html">Register here</a>.</p>
  </form>

  <!-- OTP container -->
  <div class="otp-container hidden" id="otp-container">
    <h3 id="otpmessage">Enter OTP</h3>
    <form id="otp-form">
      <div class="form-group">
        <label for="otp_code" class="form-label">OTP:</label>
        <input type="number" name="otp_code" class="form-input" id="otp_code" placeholder="Enter OTP" required>
      </div>
      <button type="submit" class="form-button">Verify OTP</button>
    </form>
</div>

<script>
  document.getElementById('loginForm').addEventListener('submit', function(event){
    event.preventDefault();
    
    var email = document.getElementById('email').value;
    var password = document.getElementById('password').value;

    var data = {
      email: email,
      password: password
    };

    fetch("/api/login", {
      method: 'POST',
      headers: {
        Accept: 'application/json',
        'Content-Type': 'application/json',
        Authorization: 'Bearer ' + localStorage.getItem('token')
      },
      body: JSON.stringify(data)
    })
    .then(response => {
      if (!response.ok) {
        throw new Error('Network response was not ok');
      }
      return response.json();
    })
    .then(data => {
      console.log(data);
      if(data.token) {
        localStorage.setItem('token', data.token);
        document.getElementById('otp-container').style.display = 'block';
        document.getElementById('loginForm').style.display = 'none';
      } else {
        document.getElementById('message').innerText = data.message || 'Unknown error';
        document.getElementById('message').style.color = 'red';
      }
    }).catch(error => {
      console.error('Error during login:', error);
      document.getElementById('message').innerText = 'An error occurred during login';
      document.getElementById('message').style.color = 'red';
    });
  });

  // Add event listener to the OTP form
  document.getElementById('otp-form').addEventListener('submit', function(event){
    event.preventDefault();

    // Add your code to verify the OTP here
    const formData = new FormData(this);
    const accessToken = localStorage.getItem('token'); // Corrected key name

    formData.append('token', accessToken); // Sending the access token along with OTP for validation

    fetch("/api/verifyOTP", {
      method: 'POST',
      body: formData,
      headers: {
        Accept: 'application/json',
      }
    }).then(response => {
      return response.json();
    }).then(data => {
      if (data.message == 'OTP Verified Successfully') {
        window.location.href = '/dashboard';
        
      } else {
        document.getElementById('otpmessage').textContent = data.message;
        document.getElementById('otpmessage').style.color = 'red';
      }
    }).catch(error => {
      console.error('Error:', error);
    });

});
</script>

<script src="assets/js/login.js"></script>

</body>
</html>
