const searchBtn = document.querySelector(".btn-search");  // Search button
const searchInput = document.querySelector(".search-input");  // Search input field
const dishGrid = document.querySelector("#dishGrid");  // Grid where recipes will be displayed
const dishPopup = document.querySelector("#dishPopup");  // Modal popup for recipe details
const popupTitle = document.querySelector(".popup-title"); 
const popupCategory = document.querySelector(".popup-category");  // Category of the dish in the modal
const popupImage = document.querySelector(".popup-image");  // Image of the dish in the modal
const popupInstructions = document.querySelector(".popup-instructions");  // Instructions for the recipe in the modal
const popupVideo = document.querySelector(".popup-video");  // YouTube tutorial link for the recipe
const closeBtn = document.querySelector(".close-btn");  // Close button for the modal

// Event listeners where it Listen for search button click and when 'close' button is clicked
searchBtn.addEventListener("click", handleSearch);
closeBtn.addEventListener("click", () => dishPopup.style.display = "none");

// this code have event lisntener where default recipes will be shown accrding to the ingredints written
window.addEventListener("DOMContentLoaded", () => {
  const defaultIngredients = ["chicken", "egg", "rice"];  

  dishGrid.innerHTML = "";

  defaultIngredients.forEach(ingredient => {
    fetchByIngredientName(ingredient, true);
  });
});

// this code Handles the search functionality were it Get the search query from the input field
async function handleSearch() {
  const query = searchInput.value.trim();
  if (!query) {  // error message if the input field  is empty
    alert("Please enter an ingredient.");
    return;
  }

  dishGrid.innerHTML = "";
  try {
    // Search by letter if query starts with a letter like a or A etc
    if (query.length === 1 && /^[a-z]$/i.test(query)) {
      const found = await fetchMeals("letter", query.toLowerCase());
      if (!found) showNotFound(query);  // Show message if no results found
      return;
    }

    // Try fetching meals based on different types of ingredients category and area
    const byIngredient = await fetchMeals("ingredient", query);
    if (byIngredient) return;

    const byCategory = await fetchMeals("category", capitalize(query));
    if (byCategory) return;

    const byArea = await fetchMeals("area", capitalize(query));
    if (byArea) return;

    showNotFound(query);  // Show message if no results found
  } catch (error) {
    console.error("Error during search:", error);  // Log error to the console
    showError("An error occurred while fetching the recipes. Please try again.");
  }
}

// Show a message if no recipes were found
function showNotFound(query) {
  dishGrid.innerHTML = `<p style='grid-column: span 3;'>No recipes found for "${query}".</p>`;
}

// Capitalize the first letter of the string
function capitalize(str) {
  return str.charAt(0).toUpperCase() + str.slice(1).toLowerCase();
}

// Fetch meals from the API based on the search type
async function fetchMeals(type, value) {
  let url = "";
  
  // here api is user form the website themealdb to fetch the data of receipes
  if (type === "ingredient") url = `https://www.themealdb.com/api/json/v1/1/filter.php?i=${value}`;
  else if (type === "category") url = `https://www.themealdb.com/api/json/v1/1/filter.php?c=${value}`;
  else if (type === "area") url = `https://www.themealdb.com/api/json/v1/1/filter.php?a=${value}`;
  else if (type === "letter") url = `https://www.themealdb.com/api/json/v1/1/search.php?f=${value}`;
  else return Promise.resolve(false);  

  try {
    const response = await fetch(url);  // Fetch data from the API
    
    if (!response.ok) {  // Check for response errors
      throw new Error("Failed to fetch data from the API");
    }
    
    const data = await response.json();

    if (!data.meals) return false;  // No meals found, return false

    // Create a heading for the fetched meals (unless searching by letter)
    if (type !== "letter") {
      const heading = document.createElement("h2");
      heading.textContent = `${capitalize(value)} Recipes`;
      heading.style.gridColumn = "span 3";
      dishGrid.appendChild(heading);
    }

    const meals = data.meals;
    meals.forEach(meal => {
      // Create card for each meal
      const card = document.createElement("div");
      card.classList.add("dish-card");
      card.innerHTML = `
        <img src="${meal.strMealThumb}" alt="${meal.strMeal}">
        <div class="dish-details">
          <h3>${meal.strMeal}</h3>
          <a href="#" class="view-btn" data-id="${meal.idMeal}">View Recipe</a>
        </div>
      `;
      dishGrid.appendChild(card);
    });

    // Added event listeners for each 'View Recipe' button
    document.querySelectorAll(".view-btn").forEach(btn =>
      btn.addEventListener("click", showDishDetails)
    );

    return true;

  } catch (error) {
    console.error("Error fetching meals:", error);  // Log error handling
    showError("An error occurred while fetching the recipes. Please try again.");
    return false;
  }
}

// Fetch meals based on a single ingredient name
function fetchByIngredientName(ingredient, isDefault = false) {
  fetch(`https://www.themealdb.com/api/json/v1/1/filter.php?i=${ingredient}`)
    .then(res => res.json())
    .then(data => {
      if (!data.meals) {
        // No recipes found for the ingredient
        dishGrid.innerHTML += `<p style='grid-column: span 3;'>No recipes found for "${ingredient}".</p>`;
        return;
      }

      if (isDefault) {
        const heading = document.createElement("h2");
        heading.textContent = `${capitalize(ingredient)} Recipes`;
        heading.style.gridColumn = "span 3";
        dishGrid.appendChild(heading);
      }

      data.meals.forEach(meal => {
        const card = document.createElement("div");
        card.classList.add("dish-card");
        card.innerHTML = `
          <img src="${meal.strMealThumb}" alt="${meal.strMeal}">
          <div class="dish-details">
            <h3>${meal.strMeal}</h3>
            <a href="#" class="view-btn" data-id="${meal.idMeal}">View Recipe</a>
          </div>
        `;
        dishGrid.appendChild(card);
      });

      // Add event listeners for each 'View Recipe' button
      document.querySelectorAll(".view-btn").forEach(btn =>
        btn.addEventListener("click", showDishDetails)
      );
    })
    .catch(error => {
      console.error("Error fetching meals by ingredient:", error);  // Log error to the console
      showError("An error occurred while fetching the recipes. Please try again.");
    });
}

// Show detailed information of a specific dish when "View Recipe" is clicked
function showDishDetails(e) {
  e.preventDefault();  // Prevent the default link behavior
  const id = e.target.getAttribute("data-id");

  // Fetch detailed information for the selected dish
  fetch(`https://www.themealdb.com/api/json/v1/1/lookup.php?i=${id}`)
    .then(res => res.json())
    .then(data => {
      const meal = data.meals[0];  // Get the meal data from the response
      popupTitle.textContent = meal.strMeal;  // Set popup title
      popupCategory.textContent = `${meal.strCategory} | ${meal.strArea}`;  // Set category and area
      popupImage.src = meal.strMealThumb;
      popupInstructions.textContent = meal.strInstructions;
      popupVideo.href = meal.strYoutube;  // Set YouTube tutorial link
      dishPopup.style.display = "block";
    })
    .catch(error => {
      console.error("Error fetching dish details:", error);
      showError("An error occurred while fetching the recipe details. Please try again.");
    });
}
function showError(message) {
  dishGrid.innerHTML = `<p style='grid-column: span 3;'>${message}</p>`;  // Display error message
}
