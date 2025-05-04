# Dietary Tracking Application

## Overview
The Dietary Tracking Application enables users to log their meals, track calories, and plan their diet. 
It supports user registration, meal planning, calorie counting, and has recently added a
**Recipe Suggestions** feature, offering personalized recipe recommendations based on available ingredients.

## Features
- **Meal Planning**: Plan your meals based on your dietary preferences.
- **Calorie Counting**: Track the total calorie intake for each meal.
- **Recipe Suggestions**: Suggest recipes based on the ingredients users have,
  with filters for categories (e.g., vegetarian, gluten-free) and areas (e.g., Italian, Mexican).

## Recipe Suggestions Feature
A new feature was added to fetch recipes from an external API based on the ingredients the user has. It allows users to:
- Input available ingredients (e.g., chicken, tomatoes).
- Fetch recipes filtered by category or area.
- View recipe names, images, and descriptions.

**Technologies used**:
-Frontend: HTML, CSS, JavaScript
-Backend: PHP
-Database: MySQL (via phpMyAdmin)
-Server: XAMPP or similar PHP server stack

## How to Use
#Set up a local server:
-To run the application locally, ensure you have XAMPP (or a similar PHP server stack like WAMP) installed on your machine.
Start Apache and MySQL services in XAMPP.
-Move the cloned project directory into the htdocs folder of your XAMPP installation (usually located in C:\xampp\htdocs 
for Windows or /Applications/XAMPP/htdocs for macOS).

#Configure the database:
-Open phpMyAdmin by navigating to http://localhost/phpmyadmin/ in your browser.
-Create a new MySQL database named sofia (or any name of your choice).
-Import the database schema from the SQL file located in the project directory (dietary-tracking-app/sql/database.sql) 
into your newly created database.

#Update the database connection:
-Edit the database connection details in your PHP files. Typically, this would be in a config.php or similar file.
-Make sure it contains the correct database name, username, and password to match your local setup (default credentials 
in XAMPP are usually root for username and no password).

#Run the application:
-In your browser, navigate to http://localhost/dietary-tracking-app/index.html to view the front end.
To interact with the backend features (login, meal logging, etc.), visit http://localhost/dietary-tracking-app/
and you should be able to use the full application, including the database-driven functionalities like meal planning and recipe suggestions.


## Contributing
Feel free to fork the repository, create a branch for your feature, and submit a pull request. 
Please make sure to follow the project's code structure and guidelines.

## License
This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
