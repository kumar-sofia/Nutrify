<?php
// mealrecord.php
//Starts a session to access user-specific data like user_id
session_start();

// Database connection
$servername = "localhost";
$username = "root"; // DB username
$password = ""; // DB password
$dbname = "sofia"; // database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Verifies whether the user is logged in by checking if user_id exists in the session.
//Redirects unauthenticated users to the login page (login.php).
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

//Fetches the user_id from the session to identify the logged-in user.
$user_id = $_SESSION['user_id'];

// Fetches all meal plans for the logged-in user
$sql = "SELECT * FROM meal_planning WHERE user_id = '$user_id' ORDER BY created_at DESC";
$result = $conn->query($sql);

// Handle delete action for deleting meals if user wants to
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_sql = "DELETE FROM meal_planning WHERE id = '$delete_id' AND user_id = '$user_id'";
    if ($conn->query($delete_sql) === TRUE) {
        header("Location: mealrecord.php"); // Redirect to refresh the table after deletion
    } else {
        echo "Error deleting meal plan: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Meal Plan Table</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round|Open+Sans">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <!--- linking style sheet of css ----->
  <link rel="stylesheet" href="mealrecord.css">
</head>
<body>
  <h1>Personalised Meals</h1>
  <table class="container">
    <thead>
      <tr>
        <th><h1>Meal Type</h1></th>
        <th><h1>Diet Type</h1></th>
        <th><h1>Calories</h1></th>
        <th><h1>Meal Time</h1></th>
        <th><h1>Created At</h1></th>
        <th><h1>Actions</h1></th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = $result->fetch_assoc()): ?>
      <tr>
        <td><?php echo htmlspecialchars($row['meal_type']); ?></td>
        <td><?php echo htmlspecialchars($row['diet_type']); ?></td>
        <td><?php echo htmlspecialchars($row['calories']); ?></td>
        <td><?php echo htmlspecialchars($row['meal_time']); ?></td>
        <td><?php echo htmlspecialchars($row['created_at']); ?></td>
        <td>
          <a href="?delete_id=<?php echo $row['id']; ?>" class="delete" title="Delete"><i class="fa fa-trash"></i></a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>

  <div class="container text-center">
    <!-- linking the button back to the meal_planning page for genrating new meals -->
    <a href="meal_planning.php" class="btn btn-primary team-generate-btn">Generate Meal Plan</a>
  </div>
</body>
</html>
