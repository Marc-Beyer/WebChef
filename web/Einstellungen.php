<?php include("./templates/basicTemplateStart.php");?>

<div id="newMeal">
    <h1>Einstellungen</h1>
    <label for"themeInput">Theme:</label>
    <select id="themeInput">
        <option value="0">Dunkel</option>
        <option value="1">Hell</option>
    </select><br>
    <button id="cookieBtn">Cookie aktualisieren</button><br>
    <button id="clearCookieBtn" hidden="true">Cookie löschen</button>
</div>

<script src='./scripts/options.js'></script>

<?php include("./templates/basicTemplateEnd.html"); ?>