<?php
// Starts a session tracks user authentication and store calculated results 
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // If not logged in, redirect to login page
    header('Location: login.php');
    exit;
}

// form for submisttion handling
$calories = null;
$errorMessage = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $age = isset($_POST['age']) ? (int)$_POST['age'] : 0;
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
    $weight = isset($_POST['weight']) ? (float)$_POST['weight'] : 0;
    $height = isset($_POST['height']) ? (float)$_POST['height'] : 0;
    $activityLevel = isset($_POST['activity-level']) ? $_POST['activity-level'] : '';
    $goal = isset($_POST['goal']) ? $_POST['goal'] : '';

    // Validate inputs Ensures all required inputs are provided and valid
    if ($age <= 0 || $weight <= 0 || $height <= 0 || empty($gender) || empty($activityLevel)) {
        $errorMessage = 'Please fill in all fields correctly.';
    } else {

        // Calculate BMI (Body Mass Index)
        $bmi = $weight / (($height / 100) * ($height / 100));

        // Calculate the daily caloric intake based on the Mifflin-St Jeor equation
        if ($gender == 'male') {
            $calories = 10 * $weight + 6.25 * $height - 5 * $age + 5;
        } elseif ($gender == 'female') {
            $calories = 10 * $weight + 6.25 * $height - 5 * $age - 161;
        } else {
            $errorMessage = 'Invalid gender provided.';
        }

        // Activity Level Adjustment
        switch (strtolower($activityLevel)) {
            case 'sedentary':
                $calories *= 1.2;
                break;
            case 'light':
                $calories *= 1.375;
                break;
            case 'moderate':
                $calories *= 1.55;
                break;
            case 'active':
                $calories *= 1.725;
                break;
            case 'very active':
                $calories *= 1.9;
                break;
            default:
                $errorMessage = 'Invalid activity level provided.';
        }

        // Adjust calories based on goal (gain, lose, or maintain)
        if ($goal == 'lose') {
            $calories -= 500; // Reduce calories for weight loss
        } elseif ($goal == 'gain') {
            $calories += 500; // Increase calories for weight gain
        }

        // Store result in session for later use
        $_SESSION['calories_result'] = $calories;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<header>
    <!-- Navigation Bar for linking the pages -->
<div class="navbar">
<img src="images/diet.png" alt="Nutrify Logo" style="height: 50px;">
    <div class="navbar-container">
        <a href="home.html" class="logo"></a>
        <ul class="nav-links">
        <li><a href="home_login.html">Home</a></li>
        <li><a href="meal_planning.php">Meal Planner</a></li>
        <li><a href="calories_calculator.php">Calories Count</a></li>
        <li><a href="recipe_suggestion.php">Recipe</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>


    </header>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calories Calculator</title>

    <!-- linking the style sheet of css -->
    <link rel="stylesheet" href="calories_calculator.css"> 
</head>
<body>
    <div class="wrapper">
        <form id="calculator-form" method="POST">
            <h1>Calories Calculator</h1>

            <div class="input-box">
                <label for="age">Age:</label>
                <input type="number" name="age" id="age" required value="<?php echo isset($age) ? $age : ''; ?>">
            </div>

            <div class="input-box">
                <label for="gender">Gender:</label>
                <select name="gender" id="gender">
                    <option value="male" <?php echo (isset($gender) && $gender == 'male') ? 'selected' : ''; ?>>Male</option>
                    <option value="female" <?php echo (isset($gender) && $gender == 'female') ? 'selected' : ''; ?>>Female</option>
                </select>
            </div>

            <div class="input-box">
                <label for="weight">Weight (kg):</label>
                <input type="number" name="weight" id="weight" required value="<?php echo isset($weight) ? $weight : ''; ?>">
            </div>

            <div class="input-box">
                <label for="height">Height (cm):</label>
                <input type="number" name="height" id="height" required value="<?php echo isset($height) ? $height : ''; ?>">
            </div>

            <div class="input-box">
                <label for="activity-level">Activity Level:</label>
                <select name="activity-level" id="activity-level">
                    <option value="sedentary" <?php echo (isset($activityLevel) && $activityLevel == 'sedentary') ? 'selected' : ''; ?>>Sedentary</option>
                    <option value="light" <?php echo (isset($activityLevel) && $activityLevel == 'light') ? 'selected' : ''; ?>>Light</option>
                    <option value="moderate" <?php echo (isset($activityLevel) && $activityLevel == 'moderate') ? 'selected' : ''; ?>>Moderate</option>
                    <option value="active" <?php echo (isset($activityLevel) && $activityLevel == 'active') ? 'selected' : ''; ?>>Active</option>
                    <option value="very-active" <?php echo (isset($activityLevel) && $activityLevel == 'very-active') ? 'selected' : ''; ?>>Very Active</option>
                </select>
            </div>

            <div class="input-box">
                <label for="goal">Goal:</label>
                <select name="goal" id="goal">
                    <option value="maintain" <?php echo (isset($goal) && $goal == 'maintain') ? 'selected' : ''; ?>>Maintain Weight</option>
                    <option value="lose" <?php echo (isset($goal) && $goal == 'lose') ? 'selected' : ''; ?>>Lose Weight</option>
                    <option value="gain" <?php echo (isset($goal) && $goal == 'gain') ? 'selected' : ''; ?>>Gain Weight</option>
                </select>
            </div>

            <div class="meal-planning-buttons">
                <button type="submit">Calculate Calories</button>
                <!-- button for Results to show the creted presonalized calories-->
                <button type="button" onclick="window.location.href='result.php'">Results</button>
            </div>
        </form>

        <!-- Message section when clouries are genreted secussfully after the after clicking of genetate buttion -->
        <div id="message" class="modal" style="display: <?php echo isset($calories) ? 'block' : 'none'; ?>">
            <div class="modal-content">
                <?php if ($calories): ?>
                    <p>Calories have successfully been calculated. To see the result, please <a href="result.php">click here</a>.</p>
                <?php else: ?>
                    <p>Please complete the form and calculate your calories.</p>
                <?php endif; ?>
                <button onclick="closeMessage()">OK</button>
            </div>
        </div>
    </div>

    <script>
        function closeMessage() {
            document.getElementById("message").style.display = "none";
        }
    </script>
</body>
</html>
