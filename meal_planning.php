<?php
// meal_planning.php

session_start();

// Database connection
$servername = "localhost";
$username = "root"; // DB username
$password = ""; // DB password
$dbname = "sofia"; //database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Checks if the user is logged in by verifying the existence of user_id in the session.
//If the user is not logged in, they are redirected to the login page (login.php)

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // redirect to login page if not logged in
    exit();
}

// Retrieves the logged-in user's unique identifier (user_id) from the session
$user_id = $_SESSION['user_id'];

// Handles form submissions when the user generates a meal plan.
$meal_plan_generated = false; // To control the pop-up message
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['generate'])) {
    $meal_type = $_POST['meal_type'];
    $diet_type = $_POST['diet_type'];
    $calories = $_POST['calories'];
    $meal_time = $_POST['meal_time'];

    // Insert data into meal_planning table
    $query = "INSERT INTO meal_planning (user_id, meal_type, diet_type, calories, meal_time) 
              VALUES ('$user_id', '$meal_type', '$diet_type', '$calories', '$meal_time')";

    if ($conn->query($query) === TRUE) {
        $meal_plan_generated = true;
    } else {
        echo "Error: " . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meal Planning</title>

     <!-- adding css style sheet -->
    <link rel="stylesheet" href="meal_planning.css">
    
</head>
<body>

    <header>
        
    <!-- Navigation Bar  for linking the pages-->
<div class="navbar">
<img src="images/diet.png" alt="Nutrify Logo" style="height: 50px;">
    <div class="navbar-container">
        <a href="home.html" class="logo"></a>
        <ul class="nav-links">
        <li><a href="home_login.html">Home</a></li>
        <li><a href="meal_planning.php">Meal Planner</a></li>
        <li><a href="calories_calculator.php">Calories Count</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>


    </header>

    <div class="wrapper">
        <!-- Meal planning form for entring the desired meal-->
        <form method="POST" action="meal_planning.php">
            <h1>Meal Planning</h1>

            <div class="input-box">
                <label for="meal-type">Meal Type</label>
                <select name="meal_type" id="meal-type" required>
                    <option value="breakfast">Breakfast</option>
                    <option value="lunch">Lunch</option>
                    <option value="dinner">Dinner</option>
                </select>
            </div>

            <div class="input-box">
                <label for="diet-type">Diet Type</label>
                <select name="diet_type" id="diet-type" required>
                    <option value="vegetarian">Vegetarian</option>
                    <option value="vegan">Vegan</option>
                    <option value="keto">Keto</option>
                    <option value="paleo">Paleo</option>
                </select>
            </div>

            <div class="input-box">
                <label for="calories">Calories</label>
                <select name="calories" id="calories" required>
                    <option value="2000">2000 kcal</option>
                    <option value="2500">2500 kcal</option>
                    <option value="3000">3000 kcal</option>
                </select>
            </div>

            <div class="input-box">
                <label for="meal-time">Meal Time</label>
                <select name="meal_time" id="meal-time" required>
                    <option value="morning">Morning</option>
                    <option value="afternoon">Afternoon</option>
                    <option value="evening">Evening</option>
                </select>
            </div>
              <!-- Button for genrting meal once the files are filled-->
            <div class="meal-planning-buttons">
                <button type="submit" name="generate">Generate plan</button>
                
                <!-- Button for Generated Meals only if meal plan is generated -->
                <?php if ($meal_plan_generated): ?>
                    <a href="mealrecord.php">
                        <button type="button">Generated Meal</button>
                    </a>
                <?php endif; ?>
            </div>
        </form>

        <!-- Modal for Meal Plan Generated -->
        <?php if ($meal_plan_generated): ?>
            <div id="mealPlanModal" class="modal">
                <div class="modal-content">
                    <p>Meal Plan Generated Successfully!</p>
                    <p><a href="mealrecord.php">Click here to see your meal plans.</a></p>
                    <button id="closeModal">OK</button>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script>
        // Get the modal
        var modal = document.getElementById("mealPlanModal");
        
        // Get the button that closes the modal
        var closeBtn = document.getElementById("closeModal");

        // Show the modal when meal plan is generated
        <?php if ($meal_plan_generated): ?>
            modal.style.display = "block";
        <?php endif; ?>

        // When the user clicks the "OK" button, close the modal
        closeBtn.onclick = function() {
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>

</body>
</html>

<?php
$conn->close();
?>
