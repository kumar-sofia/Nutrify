<?php
// Including database connection file for connection to mysql
include('db_connect.php');

// this code handles the input in the login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // ensuring valid input and no colum is empty
    if (empty($email) || empty($password)) {
        $error_message = "Both fields are required.";
    } else {
        // Checking if user exists in the database using prepared statements
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);
        
        if ($user && password_verify($password, $user['password'])) {
            // Start session and after secussful login it will redirect to home_login.html
            session_start();
            $_SESSION['user_id'] = $user['id'];
            // adding secondhome page which have full acces to add services
            header("Location: home_login.html"); // Redirect to home page
            exit;
        } else {
            $error_message = "Invalid credentials. Please check your email and password.";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Log In</title>
  <link rel="stylesheet" href="singh.css"> <!-- Using signup file stylesheet for login.php-->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  <style>
    .error {
        color: red;
    }
  </style>
</head>
<body>
  <header>
    <div class="logo">
      <img src="images/diet.png" alt="Nutrify Logo" style="height: 50px;">
    </div>
    <nav>
      <!-- code for navigation bar to link the pages ------>
      <div class="hamburger" onclick="toggleMenu()">☰</div>
      <ul class="navigation_bar">
        <li><a href="index.html">Home</a></li>
        <li><a href="login.php">Log in</a></li>
        <li><a href="signup.php">Sign Up</a></li>
        <li><a href="contact.html">Contact</a></li>
      </ul>
    </nav>
  </header>

  <div class="wrapper">
    <form method="POST">
      <h1>Log In</h1>

      <!-- Error Message handling for login-->
      <?php if (isset($error_message)): ?>
        <div class="error"><?php echo $error_message; ?></div>
      <?php endif; ?>

      <div class="input-box">
        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" placeholder="Enter your email" required>
      </div>

      <div class="input-box">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Enter your password" required>
      </div>
         <!-- linking sinup button the the respected page-->
      <div class="btn-container">
        <button type="submit" class="btn">Log In</button>
        <button type="button" class="btn" onclick="window.location.href='signup.php'">Sign Up</button>
      </div>
    </form>
  </div>

  <!-- Modal Structure handling for error message pop up in a constainer for  (invalid credentials) -->
  <?php if (isset($error_message) && $error_message == "Invalid credentials. Please check your email and password."): ?>
    <div id="errorModal" class="modal">
      <div class="modal-content">
        <h4>Account Not Found</h4>
        <p>Invalid login credentials. Please check your email and password, or <a href="signup.php">sign up</a> if you don't have an account.</p>
      </div>
      <div class="modal-footer">
        <a href="#!" class="modal-close btn">Close</a>
      </div>
    </div>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('.modal');
        var instances = M.Modal.init(elems);
        instances[0].open();  // Open the modal if credentials are invalid
      });
    </script>
  <?php endif; ?>

  <script>
    function toggleMenu() {
      const navBar = document.querySelector('.navigation_bar');
      navBar.classList.toggle('active');
    }
  </script>
</body>
</html>
