$(document).ready(function () {
  function loadRecipes() {
    $.ajax({
      url: "http://localhost:3000/recipes",
      method: "GET",
      success: function (recipes) {
        recipes.forEach(function (recipe) {
          // For each recipe, map over the ingredients and format them as list items
          let ingredientHtml = recipe.ingredients
            .map(function (ingredient) {
              return `<li>${ingredient.quantity} ${ingredient.name} (${ingredient.type}) </li>`;
            })
            .join("");

          // Create an HTML block for each recipe, inserting the ingredients
          let recipeHtml = `
      <div>
      <h2>${recipe.name}</h2>
      <p><strong>Ingredients: </strong></p>
      <p> ${ingredientHtml} </p>
        </div>
      `;
          // Append the HTML block to the #recipes div on the page
          $("#recipes").append(recipeHtml);
        });
      },
    });
  }

  //Loads the recipes when the page loads
  loadRecipes();
  $("#addIngredient").click(function () {
    $("#ingredientFields").append(`
      <div class="ingredient">
        <label>Quantity:</label>
        <input type="text" class="ingredient-quantity" required>
        <label>Name:</label>
        <input type="text" class="ingredient-name" required>
        <label>Type:</label>
        <input type="text" class="ingredient-type" required><br><br>
      </div>
      `);
  });

  //This is what happens when you submit the form with all the ingredients
  $("#recipeForm").on("submit", function (e) {
    e.preventDefault();

    // Collect the ingredients from the form
    let ingredients = [];
    $(".ingredient").each(function () {
      let quantity = $(this).find(".ingredient-quantity").val();
      let name = $(this).find(".ingredient-name").val();
      let type = $(this).find(".ingredient-type").val();
      ingredients.push({ quantity, name, type });
    });

    // Collect form data for the new recipe
    let newRecipe = {
      name: $("#name").val(),
      ingredients: ingredients, // Use the collected ingredients array
      steps: $("#steps")
        .val()
        .split(",")
        .map((step) => step.trim()),
    };

    // Send POST request to the JSON server
    $.ajax({
      url: "http://localhost:3000/recipes", // The JSON server URL
      method: "POST",
      contentType: "application/json",
      data: JSON.stringify(newRecipe), // Stringify the new recipe data
      success: function () {
        // Reload the recipes after the new one is added
        loadRecipes();

        // Clear the form after submission
        $("#recipeForm")[0].reset();
      },
      error: function () {
        alert("Failed to add recipe.");
      },
    });
  });
});
