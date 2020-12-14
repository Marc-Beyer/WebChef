<?php include("./templates/basicTemplateStart.php");?>

<div id="newMeal">
    <h1>Neues Rezept erstellen</h1>
    <label for="mealNameInput">Rezept Name:</label><br>
    <input type="text" id="mealNameInput" name="mealNameInput"><br>

    <label for="mealImgInput">Bild:</label><br>
    <input type="hidden" id="hidden" name="file" onsubmit="submit();">
    <canvas id="resizeCanvas" width="200" height="100" hidden="">
    </canvas> 
    <input type="file" id="file" name="fileOrg"><br>
    
    <label for="mealTypeInput">Art des Rezepts:</label><br>
    <select id="mealTypeInput" name="mealTypeInput" required="required">
        <option value="0">Hauptgericht</option>
        <option value="1">Vorspeise</option>
        <option value="2">Dessert</option>
        <option value="3">Backen</option>
        <option value="4">Anderes</option>
    </select><br>

    <label for="mealTimeInput">Dauer (hh:mm):</label><br>
    <input type="text" id="mealTimeInput" name="mealTimeInput" min="00:01" value="00:01" required="required" pattern="[0-9]{2}:[0-9]{2}"><br>

    <label for="mealDescInput">Kurze beschreibung des Rezepts:</label><br>
    <textarea id="mealDescInput" name="mealDescInput" rows="7" required="required">...</textarea><br>

    <label for="mealNrInput">Für wie viel Protionen ist das Rezept:</label><br>
    <input type="number" step="1" value="1" min="1" id="mealNrInput" name="mealNrInput" required="required"><br>

    <label for="ingredientsNr">Zutaten:</label><br>
    <input type="number" step="1" value="1" min="1" id="ingredientsNr" name="ingredientsNr" required="required"><br>
    <div id="ingredients_0">
        <input type="number" step="0.001" id="ingredientQuantity_0" name="ingredientQuantity_0" required="required">
        <select type="number" id="ingredientUnit_0" name="ingredientUnit_0" required="required">
            <option value="0">kg</option>
            <option value="1">g</option>
            <option value="2">l</option>
            <option value="3">ml</option>
            <option value="4">tl</option>
            <option value="5">el</option>
            <option value="6">Tasse(n)</option>
            <option value="7">st</option>
            <option value="8">Etwas</option>
        </select>
        <input type="text" id="ingredientName_0" name="ingredientName_0" required="required">
    </div>

    <label for="mealPrepInput" id="mealPrepInputLable">Zubereitung:</label><br>
    <textarea id="mealPrepInput" name="mealPrepInput" rows="20" required="required">...</textarea><br>

    <button id="createBtn">Rezept Erstellen</button>
</div>

<script src='./scripts/createMeal.js'></script>
<script src='./scripts/resizeImage.js'></script>

<?php include("./templates/basicTemplateEnd.html"); ?>