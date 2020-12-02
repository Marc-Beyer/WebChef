<?php



    //login-data
    $servername = "localhost";
    $username = "minemes";
    $password = "Familie";
    $dbname = "web_chef";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $mealName = $conn->real_escape_string($_POST["mealNameInput"]);
    $mealImg = $conn->real_escape_string($_POST["mealImgInput"]);
    $mealType = intval($_POST["mealTypeInput"]);
    $mealTime = $conn->real_escape_string($_POST["mealTimeInput"]);
    $mealDesc = nl2br2($conn->real_escape_string($_POST["mealDescInput"]));
    $mealNr = $conn->real_escape_string($_POST["mealNrInput"]);
    $ingredientsNr = $conn->real_escape_string($_POST["ingredientsNr"]);
    $mealPrep = nl2br2($conn->real_escape_string($_POST["mealPrepInput"]));

    echo $mealName. " <-mealName<br>";
    echo $mealImg. " <-mealImg<br>";
    echo $mealPrep. " <-mealPrep<br><br>";

    echo $mealTime. "<br><br>";
    $preparationTime = intval(substr($mealTime, 0, 2)) * 60 + intval(substr($mealTime, 3, 2));
    echo $preparationTime. " <-preparationTime<br>";

    $countSql = "SELECT COUNT(*) AS 'count' FROM `tMeal`";
    $count2Sql = "SELECT COUNT(*) AS 'count' FROM `tIngredients`";
    
    //Get the id for the new mesl
    $mID = -1;
    $result = $conn->query($countSql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $mID = $row["count"];
        echo $mID. " <-mealID<br><br>";
    }
    
    //Insert new meal into table
    $sql = "INSERT INTO `tMeal`(`M_ID`, `name`, `preparation_text`, `preparation_time`, `MT_ID`, `U_ID`, `is_public`, `description`) VALUES ($mID,'$mealName','$mealPrep','$preparationTime',$mealType,0,0,'$mealDesc')";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "Ein Fehler ist aufgetreten :(";
    }


    echo $ingredientsNr. "<br>";

    //Add all ingredience
    for ($i=0; $i < $ingredientsNr; $i++) { 
        //Get post-data
        $ingredientQuantity = $conn->real_escape_string($_POST["ingredientQuantity_$i"]);
        $ingredientUnit = $conn->real_escape_string($_POST["ingredientUnit_$i"]);
        $ingredientName = $conn->real_escape_string($_POST["ingredientName_$i"]);
        $ingredientName = ucfirst($ingredientName);

        echo $ingredientsNr. "$ingredientQuantity  $ingredientUnit $ingredientName<br>";

        $sqlGetIID = "SELECT `I_ID` FROM `tIngredients` WHERE `name` = '$ingredientName'";
        $iID = -1;

        $result = $conn->query($sqlGetIID);
        echo "Sresult<br>";

        if ($result->num_rows > 0){
            echo "get the i_id<br>";
            //get the i_id
            $row = $result->fetch_assoc();
            $iID = $row["I_ID"];
            echo "id: $iID<br>";
        }else{
            echo "Serach for a new id<br>";
            //Serach for a new id
            $result = $conn->query($count2Sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()){
                    $iID = $row["count"];
                    echo "id: $iID<br>";
                }
            }

            //Insert new ingredience into table
            $result = $conn->query("INSERT INTO `tIngredients`(`I_ID`, `name`) VALUES ('$iID','$ingredientName')");
        }
        //Insert recipes into table
        $sqlGetIID = "INSERT INTO `tRecipes`(`M_ID`, `I_ID`, `quantity`, `UN_ID`, `meal_nr`, `name`) VALUES ('$mID','$iID','$ingredientQuantity','$ingredientUnit','$mealNr','das Rezept')";
        $result = $conn->query($sqlGetIID);
    }

    $conn->close();
    //header('Location: ./index.php');

    function nl2br2($string) {
        $string = str_replace(array("\r\n", "\r", "\n"), "<br />", $string);
        return $string;
    } 
?>