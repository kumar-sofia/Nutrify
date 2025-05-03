<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>FlavorCloud - Recipe Explorer</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <!-- Navigation Bar -->
  <header>
    <div class="logo">
      <img src="images/diet.png" alt="Nutrify Logo" style="height: 50px;">
    </div>
    <nav>
      <div class="hamburger" onclick="toggleMenu()">☰</div>
      <ul class="navigation_bar">
        <li><a href="home_login.html">Home</a></li>
        <li><a href="meal_planning.php">Meal Planner</a></li>
        <li><a href="calories_calculator.php">Calories Count</a></li>
        <li><a href="logout.php">Log out</a></li>
      </ul>
    </nav>
  </header>

  <!-- this section displays the title and seach functinality of recipes with dicribibg hoiw users can seach  -->
  <div class="cloud-header">
    <h1>Healthy Finds</h1>
    <p>Search by ingredient, category, area or first letter</p>
    <div class="search-box">
      <input type="text" class="search-input" placeholder="e.g., chicken, dessert, Canadian, a..." />
      <button class="btn-search">Search</button>
    </div>
  </div>


  <!-- this continer will display dishes (recipes) dynamically, likely using JavaScript.  -->
  <div class="dish-container" id="dishGrid"></div>

  <div class="modal-view" id="dishPopup">
    <div class="modal-content">
      <span class="close-btn">&times;</span>
      <h2 class="popup-title"></h2>
      <p class="popup-category"></p>
      <img src="" alt="Dish Image" class="popup-image" />
      <p class="popup-instructions"></p>
      <a href="#" target="_blank" class="popup-video">Watch Tutorial</a>
    </div>
  </div>
 <!--  Links an external JavaScript file (script.js) that will contain the logic for interactivity 
   on the page (e.g., handling search, displaying recipes, toggling the modal).  -->
  <script src="script.js"></script>
  <script>
    function toggleMenu() {
      document.querySelector('.navigation_bar').classList.toggle('active');
    }
  </script>
</body>
</html>
