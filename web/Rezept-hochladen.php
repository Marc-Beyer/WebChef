<?php
    include("./templates/connectToDB.php");

    echo "SO DACHTE ICH DAS ABER NICHT ";
    //Check if an image is uploaded
    if(isset($_FILES["file"])){
        // Get the image and check if the upload was successfull
        $mealImgName = uploadImage();
        if(strlen($mealImgName) <= 2){
            echo "Fehler #10$mealImgName! Das Bild wurde nicht hochgeladen! ";
            $mealImgName = NULL;
        }
    }

    $mealName = makeStrSafe($_POST["mealNameInput"], $conn);
    $mealType = intval($_POST["mealTypeInput"]);
    $mealTime = makeStrSafe($_POST["mealTimeInput"], $conn);
    $mealDesc = makeStrSafe($_POST["mealDescInput"], $conn);
    $mealNr = intval($_POST["mealNrInput"]);
    $ingredientsNr = intval($_POST["ingredientsNr"]);
    $mealPrep = makeStrSafe($_POST["mealPrepInput"], $conn);

    $preparationTime = intval(substr($mealTime, 0, 2)) * 60 + intval(substr($mealTime, 3, 2));

    $countSql = "SELECT COUNT(*) AS 'count' FROM `tMeal`";
    $count2Sql = "SELECT COUNT(*) AS 'count' FROM `tIngredients`";
    
    //Get the id for the new mesl
    $mID = -1;
    $result = $conn->query($countSql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $mID = $row["count"];
    }
    
    //Insert new meal into table
    $sql = "INSERT INTO `tMeal`(`M_ID`, `name`, `preparation_text`, `preparation_time`, `MT_ID`, `U_ID`, `is_public`, `description`, `img`) VALUES ($mID,'$mealName','$mealPrep','$preparationTime',$mealType,0,1,'$mealDesc', '$mealImgName')";
    $result = $conn->query($sql);
    echo " $sql \n  ";
    /*
    echo "result->db->affected_rows() " . $result->db->affected_rows() ;
    echo "result->errorInfo() " . $result->errorInfo();
    echo "result->rowCount() " . $result->rowCount();
    echo "result->num_rows" .$result->num_rows;
    echo "result- " . $result;
    if ($result->db->affected_rows() == 0) {
        echo "Fehler #200 ist aufgetreten :( ";
    }
    if($result->errorInfo()){
        echo "Fehler #202 ist aufgetreten :( ";
    }
    if($result->rowCount() > 0){
        echo "Fehler #203 ist aufgetreten :( ";
    }
    if ((gettype($result) == "object" && $result->num_rows == 0) || !$result) {
        echo "Fehler #204 ist aufgetreten :( ";
    }
    if($result){
        echo "Fehler #205 ist aufgetreten :( ";
    }
    */

    //Add all ingredience
    for ($i=0; $i < $ingredientsNr; $i++) { 
        //Get post-data
        $ingredientQuantity = makeStrSafe($_POST["ingredientQuantity_$i"], $conn);
        $ingredientUnit = makeStrSafe($_POST["ingredientUnit_$i"], $conn);
        $ingredientName = makeStrSafe($_POST["ingredientName_$i"], $conn);
        $ingredientName = ucfirst($ingredientName);

        $sqlGetIID = "SELECT `I_ID` FROM `tIngredients` WHERE `name` = '$ingredientName'";
        $iID = -1;

        $result = $conn->query($sqlGetIID);

        if ($result->num_rows > 0){
            //get the i_id
            $row = $result->fetch_assoc();
            $iID = $row["I_ID"];
        }else{
            //Serach for a new id
            $result = $conn->query($count2Sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()){
                    $iID = $row["count"];
                }
            }

            //Insert new ingredience into table
            $result = $conn->query("INSERT INTO `tIngredients`(`I_ID`, `name`) VALUES ('$iID','$ingredientName')");
        }
        //Insert recipes into table
        $sqlGetIID = "INSERT INTO `tRecipes`(`M_ID`, `I_ID`, `quantity`, `UN_ID`, `meal_nr`, `name`) VALUES ('$mID','$iID','$ingredientQuantity','$ingredientUnit','$mealNr','das Rezept')";
        $result = $conn->query($sqlGetIID);
    }

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

        // Check if the image file is an actual image or a fake image
        $check = getimagesize($_FILES["file"]["tmp_name"]);
        if($check == false){
            return "1";
        }

        // Check if the file already exists
        $retrys = 0;
        while(file_exists("$target_dir$target_file.$imageFileType")) {
            $target_file = generateRandomString(20);
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

    function makeStrSafe($string, $conn){
        $string = str_replace("<", "&lt;", $string);
        $string = str_replace(">", "&gt;", $string);
        $string = str_replace("\"", "&quot;", $string);
        $string = str_replace("\'", "&apos;", $string);
        $string = str_replace("\&", "&amp;", $string);
        $string = str_replace("\$", "&#36;", $string);
        $string = $conn->real_escape_string($string);
        $string = str_replace(array("\\r\\n", "\\r", "\\n"), "<br>", $string);
        return $string;
    }

    $conn->close();
?>