$(document).ready(function () {
  $.ajax({
    url: "http://localhost:3000/recipes",
    method: "GET",
    success: function (recipes) {
      recipes.forEach(function (recipe) {
        let ingredientHtml = recipe.ingredients
          .map(function (ingredient) {
            return `<li>${ingredient.quantity} ${ingredient.name} (${ingredient.type}) </li>`;
          })
          .join("");

        let recipeHtml = `
      <div>
      <h2>${recipe.name}</h2>
      <p><strong>Ingredients: </strong></p>
      <p> ${ingredientHtml} </p>
        </div>
      `;
        $("#recipes").append(recipeHtml);
      });
    },
  });
});
