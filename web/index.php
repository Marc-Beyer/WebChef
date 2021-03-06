<?php include("./templates/basicTemplateStart.php");?>    

<h1>Rezepte</h1>
<!-- recipePreviews in list -->
<ul id="mealList">
    <!-- add meals -->
    <?php
        include("./templates/connectToDB.php");

        //Search
        if(isset($_GET["search"])) {
            $search = $conn->real_escape_string($_GET["search"]);
        }else{
            $search = -1;
        }

        //Get the meal type
        if(isset($_GET["type"])) {
            $mealType = intval($_GET["type"]);
        }else{
            $mealType = -1;
        }

        $sql = "SELECT * FROM `tMeal` WHERE `is_public` = 1 ORDER BY `name` ASC";
        $sqlWithType = "SELECT * FROM `tMeal` WHERE `is_public` = 1 AND `MT_ID` = $mealType ORDER BY `name` ASC";
        $sqlWithSearch = "SELECT * FROM `tMeal` WHERE `is_public` = 1 AND `name` LIKE '%$search%' ORDER BY `name` ASC";
        $sqlWithTypeAndSearch = "SELECT * FROM `tMeal` WHERE `is_public` = 1 AND `MT_ID` = $mealType AND `name` LIKE '%$search%' ORDER BY `name` ASC";

        if($mealType == -1){
            if($search == -1){
                $result = $conn->query($sql);
            }else{
                $result = $conn->query($sqlWithSearch);
            }
        }else{
            if($search == -1){
                $result = $conn->query($sqlWithType);
            }else{
                $result = $conn->query($sqlWithTypeAndSearch);
            }
        }

        $template = file_get_contents('./templates/mealPreviewTemplate.html');

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $echoString = preg_replace("~mealID~", $row["M_ID"], $template);
                $echoString = preg_replace("~mealNamePlaceholder~", $row["name"], $echoString);
                $preparation_time = intval($row["preparation_time"]);
                $preparation_time_h = intval($preparation_time / 60);
                $preparation_time_min = $preparation_time % 60;
                $echoString = preg_replace("~mealPrepTimePlaceholder~", " Dauer: ". $preparation_time_h. ":". intval($preparation_time_min/10). ($preparation_time_min%10). "h", $echoString);
                $echoString = preg_replace("~mealPrepTextPlaceholder~", $row["description"], $echoString);
                $imgPath = $row["img"];
                if(is_null($imgPath) || empty($imgPath)){
                    $echoString = preg_replace("~mealPlaceholderImg~", "./res/imgs/logo.svg" , $echoString);
                }else{
                    $echoString = preg_replace("~mealPlaceholderImg~", "./$imgPath", $echoString);
                }
                echo($echoString);
            }
        } else {
            echo "Keine Treffer :(";
        }
        $conn->close();
    ?>
</ul>   

<?php include("./templates/basicTemplateEnd.html");?>