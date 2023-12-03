<?php
// Function to verify username and password
function verifyCredentials($username, $password) {
    // Check if the username and password match
    if ($username === 'hr@auphansoftware.com' && $password === 'hello') {
        return true; // Return true for successful login
    }
    return false; // Return false for incorrect credentials
}

// Check if the request is for the login endpoint
if ($_SERVER['REQUEST_URI'] === '/login') {
    // Get the username and password from POST data
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Perform the login verification
    $loginResult = verifyCredentials($username, $password);

    // Return a response based on login result
    if ($loginResult) {
        echo 'success'; // Return 'success' for successful login
    } else {
        echo 'failure'; // Return 'failure' for incorrect credentials
    }
    exit;
}

// For the root endpoint (/), serve the HTML
echo <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Fake Login Page</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .login-box {
      width: 300px;
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      padding: 20px;
      text-align: center;
    }
    .input-field {
      width: 100%;
      padding: 10px;
      margin-bottom: 20px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
    }
    .login-btn {
      width: 100%;
      padding: 10px;
      background-color: #3498db;
      color: #fff;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
    .message {
      margin-top: 10px;
      color: #e74c3c;
    }
    .success-message {
      color: #27ae60;
    }
  </style>
</head>
<body>
  <div class="login-box">
    <h2>Fake Login</h2>
    <input type="text" id="username" class="input-field" placeholder="Username">
    <input type="password" id="password" class="input-field" placeholder="Password">
    <button id="login" class="login-btn">Login</button>
    <p class="message" style="display:none;"></p>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#login').click(function() {
        var username = $('#username').val();
        var password = $('#password').val();
        
        // Check if the username is a valid email
        if (!isValidEmail(username)) {
          $('.message').text('Please enter a valid email').show();
          return;
        }

        // Ajax request for login verification
        $.ajax({
          type: 'POST',
          url: 'http://localhost:8000/login', // Replace with your server-side verification script
          data: { username: username, password: password },
          success: function(response) {
            if (response === 'success') {
              $('.message').removeClass('message').addClass('success-message').text('Login Successful').show();
            } else {
              $('.message').text('Incorrect Username/Password').show();
            }
          }
        });
      });
    });

    // Function to validate email
    function isValidEmail(email) {
      var pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return pattern.test(email);
    }
  </script>
</body>
</html>

HTML;
?>
