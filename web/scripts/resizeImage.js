const fileInput = document.getElementById("file");
const canvas = document.getElementById("resizeCanvas");

const mealName = document.getElementById("mealNameInput");
const mealType = document.getElementById("mealTypeInput");
const mealTime = document.getElementById("mealTimeInput");
const mealDesc = document.getElementById("mealDescInput");
const mealNr = document.getElementById("mealNrInput");
const ingredientsNr = document.getElementById("ingredientsNr");
const mealPrep = document.getElementById("mealPrepInput");
const createBtn = document.getElementById("createBtn");

var imgFile = undefined;

// Create a file from an img-blob
function blobToFile(theBlob, fileName){
    theBlob.lastModifiedDate = new Date();
    theBlob.name = fileName;
    return theBlob;
}

// Add an event-listener to the submit button
createBtn.addEventListener("click", function(e){
    sendPostRequest();
});

// Add an event-listener to the file-input and rezize the img-file
fileInput.addEventListener("change", function(e){
    let file = e.target.files[0];
    // Check if the file is an image
    if(file.type.match(/^image\/.*/)){
        let fileReader = new FileReader();
        fileReader.onload = function(e){
            let img = new Image();
            img.onload = function(e){
                // Rezize the image
                let ctx = canvas.getContext("2d");
                canvas.width = img.width;
                canvas.height = img.height;
                canvas.width = 1000;
                canvas.height = canvas.width * (img.height / img.width);
                ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
                canvas.toBlob(function(blob){
                    // Set the image
                    imgFile = blobToFile(blob, "img.jpg");
                }, 'image/jpeg', 0.95);
            };
            img.src = e.target.result;
        };
        fileReader.readAsDataURL(file);
    }
});

// Send a POST-request
function sendPostRequest(){
    // Get FormData
    var formData = new FormData();
    formData.append('mealNameInput', mealName.value);
    formData.append('mealTypeInput', mealType.value);
    formData.append('mealTimeInput', mealTime.value);
    formData.append('mealDescInput', mealDesc.value);
    formData.append('mealNrInput', mealNr.value);   
    formData.append('ingredientsNr', ingredientsNr.value);
    formData.append('mealPrepInput', mealPrep.value);
    formData.append('file', imgFile);
    for (let index = 0; index < ingredientsNr.value; index++) {
        formData.append("ingredientQuantity_" + index, document.getElementById("ingredientQuantity_" + index).value);
        formData.append("ingredientUnit_" + index, document.getElementById("ingredientUnit_" + index).value);
        formData.append("ingredientName_" + index, document.getElementById("ingredientName_" + index).value);
    }

    // Send POST-request 
    var xhRequest = new XMLHttpRequest();
    xhRequest.open("POST", "./Rezept-hochladen.php", true);
    xhRequest.onreadystatechange = (e) => {
        console.log(xhRequest.responseText);
        if(xhRequest.responseText.length > 1){
            alert(xhRequest.responseText);
        }else{
            window.open("./index.php", "_self");
        }
    }
    xhRequest.send(formData);
}