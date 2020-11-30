<?php
    include("./templates/basicTemplateStart.html");
    
    //
    $servername = "localhost";
    $username = "minemes";
    $password = "Familie";
    $dbname = "web_chef";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $nr = intval($_GET["nr"]);
    $sql = "SELECT * FROM `tMeal` WHERE `M_ID`=". $nr;
    $sql2 = "SELECT `tIngredients`.`name`, `tRecipes`.`quantity`, `tUnit`.`name` AS 'unit' FROM `tRecipes` INNER JOIN `tIngredients` ON `tRecipes`.`I_ID` = `tIngredients`.`I_ID` INNER JOIN `tUnit` ON `tRecipes`.`UN_ID` = `tUnit`.`UN_ID` WHERE `tRecipes`.`M_ID` = ". $nr;

    $result = $conn->query($sql);

    $template = file_get_contents('./templates/mealPageTemplate.html');

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $template = preg_replace("~mealNamePlaceholder~", $row["name"], $template);
            $preparation_time = intval($row["preparation_time"]);
            $preparation_time_h = intval($preparation_time / 60);
            $preparation_time_min = $preparation_time % 60;
            $template = preg_replace("~mealPrepTimePlaceholder~", " Dauer: ". $preparation_time_h. ":". $preparation_time_min. "h", $template);
            $template = preg_replace("~mealPrepTextPlaceholder~", $row["preparation_text"], $template);
            $imgBlob = $row["img"];
            if(is_null ($imgBlob)){
                $template = preg_replace("~mealPlaceholderImg~", "./res/imgs/logo.svg" , $template);
            }else{
                $template = preg_replace("~mealPlaceholderImg~", "data:image/jpeg;base64,". base64_encode($imgBlob) , $template);
            }
        }
    } else {
        echo "Ein Fehler ist aufgetreten :(";
    }

    $result = $conn->query($sql2);
    
    if ($result->num_rows > 0) {
        $ingredients = "";
        while($row = $result->fetch_assoc()) {
            $ingredients = $ingredients. "<li>". $row["quantity"]. $row["unit"]. " ". $row["name"]. "</li>";
        }
        $template = preg_replace("~ingridiencePlaceholder~", $ingredients, $template);
    }else{
        $template = preg_replace("~ingridiencePlaceholder~", "Es scheit so als gibt es keine...", $template);
    }
    
    echo($template);

    $conn->close();

    include("./templates/basicTemplateEnd.html");
?>