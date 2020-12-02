var currentIngredientsNr = 1;
$(document).ready(function () {
    console.log("document ready!");
    var ingredientsNrElement = $("#ingredientsNr");
    ingredientsNrElement.change(function () {
        var newIngredientsNr = ingredientsNrElement[0].value;
        while (currentIngredientsNr < newIngredientsNr) {
            console.log(currentIngredientsNr, newIngredientsNr);
            var ingredientsElement = $("#ingredients_0")[0].cloneNode(true);
            ingredientsElement.id = ingredientsElement.id.split("_")[0] + "_" + currentIngredientsNr;
            for (var _i = 0, _a = ingredientsElement.children; _i < _a.length; _i++) {
                var ingredientsChild = _a[_i];
                ingredientsChild.id = ingredientsChild.id.split("_")[0] + "_" + currentIngredientsNr;
            }
            $("#form")[0].insertBefore(ingredientsElement, $("#mealPrepInputLable")[0]);
            currentIngredientsNr++;
        }
        while (currentIngredientsNr > newIngredientsNr) {
            $("#ingredients_" + (currentIngredientsNr - 1))[0].remove();
            currentIngredientsNr--;
        }
    });
});
