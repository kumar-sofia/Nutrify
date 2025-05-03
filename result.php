<?php
session_start();  // Start the session

// Check if the calories result is available in session
if (isset($_SESSION['calories_result'])) {
    // Get the result from the session
    $daily_calories = $_SESSION['calories_result'];  // Assign session result to $daily_calories
} else {
    // If the result is not set, redirect to the calculator page
    header('Location: calories_calculator.php');
    exit;
}

// Store the calculated daily calories in the session
$_SESSION['daily_calories'] = $daily_calories;  // Store the result for the recipe suggestion page
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Calories Calculator Result</title>
  <!-- Link to Google Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins|Roboto|Varela+Round|Open+Sans">
  <!-- Link to FontAwesome for icons -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- Link to Bootstrap for styles -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <!-- Link to Custom Stylesheet -->
  <link rel="stylesheet" href="mealrecord.css">
</head>
<body>
  <div class="container">
  <h1 class="text-center" style="color: white !important;">
    Results
</h1>





    <!-- Table for displaying results -->
    <table class="container">
      <thead>
        <tr>
          <th>Parameter</th>
          <th>Value</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Daily Calorie Requirement</td>
          <td><?php echo number_format($daily_calories, 2); ?> kcal</td>
        </tr>
        <tr>
          <td>Based On</td>
          <td>Your age, weight, height, gender, activity level, and goal.</td>
        </tr>
      </tbody>
    </table>

    <!-- "Go back to Calculator" button -->
    <div class="text-center">
      <a href="calories_calculator.php" class="btn team-generate-btn">Go back to Calculator</a>
    </div>

<!-- Redirect to Recipe Suggestions Button -->
<div class="text-center" style="margin-top: 20px;">
<a href="recipe_suggestion.php" class="btn team-generate-btn">Suggested Recipes</a>
    </div>



</body>
</html>
