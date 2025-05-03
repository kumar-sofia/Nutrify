<?php
// Including  database connection file for connecting to database
include('db_connect.php'); //contains the connection code

// this part of code handles the the request for singup
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $gender = $_POST['gender'];
    
    // Initialize error messages
    $error_message = '';

    // error handling if any cloum is empt errro message popup untill every cloum is filled as aspected
    if (empty($full_name) || empty($email) || empty($password) || empty($gender)) {
        $error_message = "Please fill in all the credentials.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Please enter a valid email address (e.g., user@example.com).";
    } elseif (strlen($password) < 6) {  //setting Password limt to be more that 5 charachters
        $error_message = "Password must be more than 5 characters.";
    } elseif (!in_array(strtolower($gender), ['male', 'female', 'other'])) {  // Gender validation for correct input
        $error_message = "Please select a valid gender: Male, Female, or Other.";
    } else {
        // code to chcek if email alredy exits if so error message email exits login
        $check_email = "SELECT * FROM users WHERE email = ?";
        $stmt = mysqli_prepare($conn, $check_email);
        mysqli_stmt_bind_param($stmt, "s", $email); // Binding the email parameter
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $error_message = "Email already exists!";
        } else {
            // this code alloews the users to Insert new user into database using prepared statements
            $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hash password for security
            $sql = "INSERT INTO users (full_name, email, password, gender) VALUES (?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ssss", $full_name, $email, $hashed_password, $gender);

            if (mysqli_stmt_execute($stmt)) {
                //  if everthing goes as expected message Success, set flag to open modal
                $registration_success = true;
            } else {
                $error_message = "Error: " . mysqli_error($conn);
            }
        }

        mysqli_stmt_close($stmt); // Close statement after use
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up</title>
  <link rel="stylesheet" href="singh.css">
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
    <!-- code for navigation bar linking pages -->
    <div class="logo">
      <img src="images/diet.png" alt="Nutrify Logo" style="height: 50px;">
    </div>
    <nav>
      <!-- toggle menu for ross platform  -->
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
      <h1>Sign Up</h1>

      <!-- Error Message  handling-->
      <?php if (isset($error_message)): ?>
        <div class="error"><?php echo $error_message; ?></div>
      <?php endif; ?>

         <!-- container code for cloums to insert data-->
      <div class="input-box">
        <label for="fullname">Full Name</label>
        <input type="text" id="fullname" name="fullname" placeholder="Enter your full name" required>
      </div>

      <div class="input-box">
        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" placeholder="Enter your email" required>
      </div>

      <div class="input-box">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Create a password" required>
      </div>

      <div class="input-box">
        <label for="gender">Gender</label>
        <input type="text" id="gender" name="gender" placeholder="Enter your gender (Male/Female/Other)" required>
      </div>

      <div class="btn-container">
        <button type="submit" class="btn">Sign Up</button>
        <button type="button" class="btn" onclick="window.location.href='login.php'">Log In</button>
      </div>
    </form>
  </div>

  <!-- Structure code  for success when registration is inserted a popup meeage bos appears -->
  <?php if (isset($registration_success) && $registration_success): ?>
    <div id="successModal" class="modal">
      <div class="modal-content">
        <h4>Registration Successful</h4>
        <p>You have been successfully registered. Please log in with your credentials.</p>
      </div>
      <div class="modal-footer">
        <!-- linking the pop up messgae box after registartion to log and linking it to login.php -->
        <a href="login.php" class="modal-close btn">Go to Login</a>
      </div>
    </div>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('.modal');
        var instances = M.Modal.init(elems);
        instances[0].open();  // Open the modal after successful registration
      });
    </script>
  <?php endif; ?>
<!-- script code for the toggle menu to be responsive -->
  <script>
    function toggleMenu() {
      const navBar = document.querySelector('.navigation_bar');
      navBar.classList.toggle('active');
    }
  </script>
</body>
</html>
