<?php
    // Get the cookie and adjust the theme
    $theme = 0;
    if(isset($_COOKIE["theme"])){
        if($_COOKIE["theme"] == "1"){
            $theme = 1;
        }
    }

    // Get the current URI
    $uri = $_SERVER['REQUEST_URI'];

    // Match the URI with regEx
    if(preg_match("/\/index.php/i", $uri)){
        $uri = 0;
    }else if(preg_match("/\/Rezept.php/i", $uri)){
        $uri = 1;
    }else if(preg_match("/\/Rezept-erstellen.php/i", $uri)){
        $uri = 2;
    }else if(preg_match("/\/Einstellungen.php/i", $uri)){
        $uri = 3;
    }
?>

<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset='utf-8'>
        <title>Leckere Rezepte für Jeden</title>
        <meta name='viewport' content='width=device-width, initial-scale=1'>

        <link rel="icon" type="image/svg+xml" href="res/imgs/favicon.svg">
        <link rel="alternate icon" href="res/imgs/favicon.ico">

        <!-- Adjust the theme -->
        <?php
            if($theme == 1){
                echo "<link rel='stylesheet' type='text/css' media='screen' href='./style/mainLight.css' id='cssLink'>";
            }else{
                echo "<link rel='stylesheet' type='text/css' media='screen' href='./style/main.css' id='cssLink'>";
            }
        ?>

        <script src='./scripts/jquery-3.5.1.min.js'></script>
        <script src='./scripts/main.js'></script>
    </head>
    <body>
        <nav>
            <div id="logo">
                <!-- Adjust the theme -->
                <?php
                    if($theme == 1){
                        echo "<img src='./res/imgs/logo2.svg' alt='WebChef'>";
                    }else{
                        echo "<img src='./res/imgs/logo.svg' alt='WebChef'>";
                    }
                ?>
            </div>
            <ul id="desktopMenu">
                <li class="dropdown" id="mobileNavBtn">
                    <button id="mobileNavButton">
                        <!-- Adjust the theme -->
                        <?php
                            if($theme == 1){
                                echo "<img src='./res/imgs/burgerMenu2.svg' alt='Menü'>";
                            }else{
                                echo "<img src='./res/imgs/burgerMenu.svg' alt='Menü'>";
                            }
                        ?>
                    </button>
                </li>
                <li class="dropdown">
                    <!-- Highlight Rezepte-Page if iz's the current -->
                    <?php
                        if($uri == 0 || $uri == 1){
                            echo "<a href='./index.php' class='active mainMenu'>Rezepte</a>";
                        }else{
                            echo "<a href='./index.php' class='mainMenu'>Rezepte</a>";
                        }
                    ?>
                    <ul class="subMenu">
                        <li>
                            <a href="./index.php?type=0">Hauptgerichte</a>
                        </li>
                        <li>
                            <a href="./index.php?type=1">Vorspeisen</a>
                        </li>
                        <li>
                            <a href="./index.php?type=2">Desserts</a>
                        </li>
                        <li>
                            <a href="./index.php?type=3">Backen</a>
                        </li>
                        <li>
                            <a href="./index.php?type=4">Anderes</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="./Was-soll-Ich-Kochen.php" class="mainMenu">Was soll ich kochen?</a>
                </li>
                <li class="dropdown">
                    <!-- Highlight Rezept erstellen-Page if iz's the current -->
                    <?php
                        if($uri == 2){
                            echo "<a href='./Rezept-erstellen.php' class='active mainMenu'>Rezept erstellen</a>";
                        }else{
                            echo "<a href='./Rezept-erstellen.php' class='mainMenu'>Rezept erstellen</a>";
                        }
                    ?>
                </li>
                <li class="dropdown">
                    <!-- Highlight Einstellungen-Page if iz's the current -->
                    <?php
                        if($uri == 3){
                            echo "<a href='./Einstellungen.php' class='active mainMenu'>Einstellungen</a>";
                        }else{
                            echo "<a href='./Einstellungen.php' class='mainMenu'>Einstellungen</a>";
                        }
                    ?>
                </li>
                <li class="dropdown" id="searchbar">
                    <input type="search" id="searchInput" name="searchInput">
                    <button id="searchbarBtn">
                        <!-- Adjust the theme -->
                        <?php
                            if($theme == 1){
                                echo "<img src='./res/imgs/search2.svg' alt='Suche'>";
                            }else{
                                echo "<img src='./res/imgs/search.svg' alt='Suche'>";
                            }
                        ?>
                    </button>
                </li>
            </ul>
        </nav>
        <div id="pageContent">
            <article id="mainArticle">