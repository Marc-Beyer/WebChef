<h1>Rezepte</h1>
<!-- recipePreviews in list -->
<ul id="mealList">
    <!-- add meals -->
    <?php
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

        $sql = "SELECT * FROM `tMeal` WHERE `is_public`=1";

        $result = $conn->query($sql);

        $template = file_get_contents('./templates/mealPreviewTemplate.html');

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $echoString = preg_replace("~mealID~", $row["M_ID"], $template);
                $echoString = preg_replace("~mealNamePlaceholder~", $row["name"], $echoString);
                $preparation_time = intval($row["preparation_time"]);
                $preparation_time_h = intval($preparation_time / 60);
                $preparation_time_min = $preparation_time % 60;
                $echoString = preg_replace("~mealPrepTimePlaceholder~", " Dauer: ". $preparation_time_h. ":". $preparation_time_min. "h", $echoString);
                $echoString = preg_replace("~mealPrepTextPlaceholder~", $row["description"], $echoString);
                $imgBlob = $row["img"];
                if(is_null ($imgBlob)){
                    $echoString = preg_replace("~mealPlaceholderImg~", "./res/imgs/logo.svg" , $echoString);
                }else{
                    $echoString = preg_replace("~mealPlaceholderImg~", "data:image/jpeg;base64,". base64_encode($imgBlob) , $echoString);
                }
                echo($echoString);
            }
        } else {
            echo "Keine Treffer :(";
        }
        $conn->close();
    ?>
</ul>   