var currentIngredientsNr : number = 1;

$( document ).ready(function() {
    console.log( "document ready!" );
    var fd = new FormData();
    console.log("fd ", fd);
    fd.append('fname', 'test.wav');
    console.log("fd ", fd);

    var ingredientsNrElement = $("#ingredientsNr");
    ingredientsNrElement.change( function() {
        var newIngredientsNr : number = ingredientsNrElement[0].value;

        while(currentIngredientsNr < newIngredientsNr){
            console.log(currentIngredientsNr, newIngredientsNr);
            var ingredientsElement = $("#ingredients_0")[0].cloneNode(true);
            ingredientsElement.id = ingredientsElement.id.split("_")[0] + "_" + currentIngredientsNr;
            for (let ingredientsChild of ingredientsElement.children) {
                ingredientsChild.id = ingredientsChild.id.split("_")[0] + "_" + currentIngredientsNr;
                ingredientsChild.name = ingredientsChild.name.split("_")[0] + "_" + currentIngredientsNr;
            }
            $("#form")[0].insertBefore(ingredientsElement, $("#mealPrepInputLable")[0]);
            currentIngredientsNr++;
        }

        while(currentIngredientsNr > newIngredientsNr){
            $("#ingredients_" + (currentIngredientsNr - 1))[0].remove();
            currentIngredientsNr--;
        }
    });
});