const FILE_INPUT = document.getElementById("file");
const RESIZE_CANVAS = document.getElementById("resizeCanvas");
const MEAL_NAME = document.getElementById("mealNameInput");
const MEAL_TYPE = document.getElementById("mealTypeInput");
const MEAL_TIME = document.getElementById("mealTimeInput");
const MEAL_DESC = document.getElementById("mealDescInput");
const MEAL_NR = document.getElementById("mealNrInput");
const INGREDIENTS_NR = document.getElementById("ingredientsNr");
const MEAL_PREP = document.getElementById("mealPrepInput");
const CREATE_BTN = document.getElementById("createBtn");
const MEAL_IMG_IMPUT_ERR = document.getElementById("mealImgInputErr");
const ERROR_TEXT = document.getElementById("error");

var imgFile = undefined;

// Create a file from an img-blob
function blobToFile(theBlob, fileName){
    theBlob.lastModifiedDate = new Date();
    theBlob.name = fileName;
    return theBlob;
}

// Add an event-listener to the submit button
CREATE_BTN.addEventListener("click", function(e){
    if(isFormDataCorrect()){
        ERROR_TEXT.hidden = true;
        sendPostRequest();
    }else{
        ERROR_TEXT.hidden = false;
    }
});

// Add an event-listener to the file-input and rezize the img-file
FILE_INPUT.addEventListener("change", function(e){
    let file = e.target.files[0];
    // Check if the file is an image
    if(file.type.match(/^image\/.*/)){
        let fileReader = new FileReader();
        fileReader.onload = function(e){
            let img = new Image();
            img.onload = function(e){
                // Rezize the image
                let ctx = RESIZE_CANVAS.getContext("2d");
                // set the resolution to 720p
                RESIZE_CANVAS.width = 1280;
                RESIZE_CANVAS.height = 720;
                // Drow the img in the middle resized
                if(img.width/(16/9) > img.height){
                    // Image width is to large
                    let newHeight = RESIZE_CANVAS.width * (img.height / img.width);
                    let space = (RESIZE_CANVAS.height-newHeight)/2;
                    let space2 = RESIZE_CANVAS.height - space - newHeight;
                    ctx.filter = "contrast(0.8) blur(10px)";
                    ctx.drawImage(img, 0, 0, img.width, 10, 0, 0, RESIZE_CANVAS.width, space);
                    ctx.drawImage(img, 0, img.height-10, img.width, 10, 0, RESIZE_CANVAS.height-space2, RESIZE_CANVAS.width, space2);
                    ctx.filter = "none";
                    ctx.drawImage(img, 0, space, RESIZE_CANVAS.width, newHeight);
                }else{
                    // Image height is to large
                    var newWidth = RESIZE_CANVAS.height * (img.width / img.height);
                    let space = (RESIZE_CANVAS.width-newWidth)/2;
                    let space2 = RESIZE_CANVAS.width - space - newWidth;
                    ctx.filter = "contrast(0.8) blur(10px)";
                    ctx.drawImage(img, 0, 0, 10, img.height, 0, 0, space, RESIZE_CANVAS.height);
                    ctx.drawImage(img, img.width-10, 0, 10, img.height, RESIZE_CANVAS.width-space2, 0, space2, RESIZE_CANVAS.height);
                    ctx.filter = "none";
                    ctx.drawImage(img, space, 0, newWidth, RESIZE_CANVAS.height);
                }
                
                // Create image-file
                reduceImgSize(1);
            };
            img.src = e.target.result;
        };
        fileReader.readAsDataURL(file);
    }else{
        RESIZE_CANVAS.hidden = true;
        MEAL_IMG_IMPUT_ERR.textContent = "Die hochgeladene Datei scheint kein Bild zu sein...";
        MEAL_IMG_IMPUT_ERR.hidden = false;
    }
});

// Reduce the image size with recursion
function reduceImgSize(value){
    if(value <= 0){
        RESIZE_CANVAS.hidden = true;
        MEAL_IMG_IMPUT_ERR.textContent = "Das hochgeladene Bild scheint zu groß zu sein...";
        MEAL_IMG_IMPUT_ERR.hidden = false;
        return;
    }
    RESIZE_CANVAS.toBlob(function(blob){
        // Set the image
        imgFile = blobToFile(blob, "img.jpg");
        // Check if the size is too large
        if(imgFile.size > 450000){
            console.log(value,"imgFile.size", imgFile.size);
            // Reduce size again
            reduceImgSize(value - 0.01);
        }else{
            // Show image
            RESIZE_CANVAS.hidden = false;
            MEAL_IMG_IMPUT_ERR.hidden = true;
        }
    }, 'image/jpeg', value);
}

// Check if user-iput is correct
function isFormDataCorrect(){
    let formIsCorrect = true;
    ERROR_TEXT.innerHTML = "<strong>Fehler:</strong>";
    if(MEAL_NAME.value.length < 4 || MEAL_NAME.value.length > 25){
       ERROR_TEXT.innerHTML += "<br>Der Name ist zu lang!";
        formIsCorrect = false;
    }
    if(!Number.isInteger(parseInt(MEAL_TYPE.value)) || parseInt(MEAL_TYPE.value) < 0){
       ERROR_TEXT.innerHTML += "<br>MEAL_TYPE ist falsch!";
        formIsCorrect = false;
    }
    if(!MEAL_TIME.value.match(/^[0-9][0-9]:[0-9][0-9]$/)){
       ERROR_TEXT.innerHTML += "<br>Die Dauer ist im falschen Format! Bitte nutze HH:MM z.B. 01:25";
        formIsCorrect = false;
    }
    if(MEAL_DESC.value.length < 5 || MEAL_DESC.value.length > 200){
       ERROR_TEXT.innerHTML += "<br>Die Beschreibung ist ist zu lang!";
        formIsCorrect = false;
    }
    if(MEAL_PREP.value.length < 5 || MEAL_PREP.value.length > 1000){
       ERROR_TEXT.innerHTML += "<br>Die Zubereitung ist ist zu lang!";
        formIsCorrect = false;
    }
    if(!Number.isInteger(MEAL_NR.value) || MEAL_NR.value <= 0){
    console.log("type", typeof(MEAL_NR.value))
       ERROR_TEXT.innerHTML += "<br>Die Anzahl ist keine gültige Zahl! Bitte nur ganze Zahlen größer als 0.";
        formIsCorrect = false;
    }
    if(!Number.isInteger(INGREDIENTS_NR.value) || INGREDIENTS_NR.value < 0){
       ERROR_TEXT.innerHTML += "<br>Die Zutatenanzahl ist keine gültige Zahl! Bitte nur ganze Zahlen größer gleich 0.";
        formIsCorrect = false;
    }
    for (let index = 0; index < INGREDIENTS_NR.value; index++) {
        let ingredientQuantity = document.getElementById("ingredientQuantity_" + index).value;
        let ingredientUnit = document.getElementById("ingredientUnit_" + index).value;
        let ingredientName = document.getElementById("ingredientName_" + index).value;  
        if(!Number.isInteger(MEAL_NR.value) || MEAL_NR.value <= 0){
           ERROR_TEXT.innerHTML += "<br>Zutat nr " + (index+1) + " ist falsch!";
            formIsCorrect = false;
            break;
        }
        if(!Number.isInteger(MEAL_NR.value) || MEAL_NR.value <= 0){
           ERROR_TEXT.innerHTML += "<br>Zutat nr " + (index+1) + " ist falsch!";
            formIsCorrect = false;
            break;
        }
        if(ingredientName.length < 4 || ingredientName.length > 25){
           ERROR_TEXT.innerHTML += "<br>Zutat nr " + (index+1) + " ist falsch!";
            formIsCorrect = false;
            break;
        }
    }

    return formIsCorrect;
}

// Send a POST-request
function sendPostRequest(){
    // Get FormData
    var formData = new FormData();
    formData.append('mealNameInput', MEAL_NAME.value);
    formData.append('mealTypeInput', MEAL_TYPE.value);
    formData.append('mealTimeInput', MEAL_TIME.value);
    formData.append('mealDescInput', MEAL_DESC.value);
    formData.append('mealNrInput', MEAL_NR.value);   
    formData.append('ingredientsNr', INGREDIENTS_NR.value);
    formData.append('mealPrepInput', MEAL_PREP.value);
    formData.append('file', imgFile);
    for (let index = 0; index < INGREDIENTS_NR.value; index++) {
        formData.append("ingredientQuantity_" + index, document.getElementById("ingredientQuantity_" + index).value);
        formData.append("ingredientUnit_" + index, document.getElementById("ingredientUnit_" + index).value);
        formData.append("ingredientName_" + index, document.getElementById("ingredientName_" + index).value);
    }

    // Send POST-request 
    var xhRequest = new XMLHttpRequest();
    xhRequest.open("POST", "./Rezept-hochladen.php", true);
    xhRequest.onreadystatechange = (e) => {
        console.log("response:", xhRequest.responseText);
        if(xhRequest.responseText.length > 1){
            ERROR_TEXT.textContent = xhRequest.responseText;
            ERROR_TEXT.hidden = false;
            ERROR_TEXT.scrollIntoView();
        }else{
            ERROR_TEXT.hidden = false;
            ERROR_TEXT.scrollIntoView();
            //window.open("./index.php", "_self");
        }
    }
    xhRequest.send(formData);
}