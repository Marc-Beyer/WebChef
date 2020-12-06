<?php
    echo "<pre>"; 

    print_r($_FILES); 

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

    // Get the image and check if the upload was successfull
    $mealImgName = uploadImage();
    if(strlen($mealImgName) <= 5){
        echo "error #$mealImgName occurred!";
    }else{
        echo "the image has been uploaded as $mealImgName<br>";
    }

    $mealName = $conn->real_escape_string($_POST["mealNameInput"]);
    $mealType = intval($_POST["mealTypeInput"]);
    $mealTime = $conn->real_escape_string($_POST["mealTimeInput"]);
    $mealDesc = nl2br2($conn->real_escape_string($_POST["mealDescInput"]));
    $mealNr = $conn->real_escape_string($_POST["mealNrInput"]);
    $ingredientsNr = $conn->real_escape_string($_POST["ingredientsNr"]);
    $mealPrep = nl2br2($conn->real_escape_string($_POST["mealPrepInput"]));

    echo "<br><br>";
    echo "mealName: $mealName<br>";
    echo "mealPrep: $mealPrep<br><br>";
    echo "mealTime: $mealTime<br><br>";

    $preparationTime = intval(substr($mealTime, 0, 2)) * 60 + intval(substr($mealTime, 3, 2));
    echo "preparationTime: $preparationTime<br>";

    $countSql = "SELECT COUNT(*) AS 'count' FROM `tMeal`";
    $count2Sql = "SELECT COUNT(*) AS 'count' FROM `tIngredients`";
    
    //Get the id for the new mesl
    $mID = -1;
    $result = $conn->query($countSql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $mID = $row["count"];
        echo "mealID: $mID<br><br>";
    }
    
    //Insert new meal into table
    $sql = "INSERT INTO `tMeal`(`M_ID`, `name`, `preparation_text`, `preparation_time`, `MT_ID`, `U_ID`, `is_public`, `description`, `img`) VALUES ($mID,'$mealName','$mealPrep','$preparationTime',$mealType,0,1,'$mealDesc', '$mealImgName')";
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

        echo "$ingredientsNr $ingredientQuantity  $ingredientUnit $ingredientName<br>";

        $sqlGetIID = "SELECT `I_ID` FROM `tIngredients` WHERE `name` = '$ingredientName'";
        $iID = -1;

        $result = $conn->query($sqlGetIID);

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
    
   echo "</pre>"; 

   // Get a random string with length '$length'
    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    // Upload the image
    function uploadImage(){
        $target_dir = "res/uploads/";
        $target_file = generateRandomString(20);
        //$imageFileType = strtolower(pathinfo($_FILES["file"]["name"],PATHINFO_EXTENSION));
        $imageFileType = $_FILES["file"]["type"];
        $imageFileType = str_replace("image/", "", $imageFileType);
        echo "imageFileType $imageFileType<br>";

        // Check if image file is a actual image or fake image
        if(isset($_POST["submit"])) {
            $check = getimagesize($_FILES["file"]["tmp_name"]);
            if($check == false){
                return "1";
            }
        }

        // Check if file already exists
        $retrys = 0;
        while(file_exists("$target_dir$target_file.$imageFileType")) {
            $retrys++;
            if($retrys > 100){
                return "2";
            }
        }

        // Check file size
        if ($_FILES["file"]["size"] > 500000) {
            return "3";
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
            return "4";
        }

        // Try to upload the file
        if (move_uploaded_file($_FILES["file"]["tmp_name"],  "$target_dir$target_file.$imageFileType")) {
            return "$target_dir$target_file.$imageFileType";
        } else {
            return "5";
        }
    }
?>