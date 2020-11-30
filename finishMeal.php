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
    $mealDesc = $conn->real_escape_string($_POST["mealDescInput"]);
    $mealNr = $conn->real_escape_string($_POST["mealNrInput"]);
    $ingredientsNr = $conn->real_escape_string($_POST["ingredientsNr"]);
    $mealPrep = $conn->real_escape_string($_POST["mealPrepInput"]);

    $ingredientQuantity_0 = $conn->real_escape_string($_POST["ingredientQuantity_0"]);
    $ingredientUnit_0 = $conn->real_escape_string($_POST["ingredientUnit_0"]);
    $ingredientName_0 = $conn->real_escape_string($_POST["ingredientName_0"]);

    echo $mealName. "<br>";
    echo $mealImg. "<br>";
    echo $mealPrep. "<br><br>";

    echo $mealTime. "<br><br>";
    $preparationTime = intval(substr($mealTime, 0, 2)) * 60 + intval(substr($mealTime, 3, 2));
    echo $preparationTime. "<br>";

    $sql = "INSERT INTO `tMeal`(`M_ID`, `name`, `preparation_text`, `preparation_time`, `MT_ID`, `U_ID`, `is_public`, `description`, 'img') VALUES (2,'$mealName','$mealPrep','$preparationTime',$mealType,0,0,'$mealDesc','$mealImg')";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo $row["M_ID"]. "<br>". $row["description"];
        }
    } else {
        echo "Ein Fehler ist aufgetreten :(";
    }

    $conn->close();
?>