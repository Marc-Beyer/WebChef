<?php
    include("./templates/connectToDB.php");

    $sql = "SELECT `M_ID` FROM `tMeal` WHERE `is_public` = 1";

    $result = $conn->query($sql);


    $allMIDs = "";

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $allMIDs = $allMIDs. " ". $row["M_ID"];
        }
    } else {
        echo "Keine Treffer :(";
    }

    $mIdArr = explode(" ", substr($allMIDs, 1));
    
    $rmdNr = array_rand($mIdArr, 1);
    header("Location:Rezept.php?nr=". $rmdNr);
    exit();

    $conn->close();
?>