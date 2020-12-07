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

function blobToFile(theBlob, fileName){
    //A Blob() is almost a File() - it's just missing the two properties below which we will add
    theBlob.lastModifiedDate = new Date();
    theBlob.name = fileName;
    return theBlob;
}

createBtn.addEventListener("click", function(e){
    sendPostRequest();
});

fileInput.addEventListener("change", function(e){
    let file = e.target.files[0];
    console.log("file", file);

    // Check if the file is an image
    if(file.type.match(/^image\/.*/)){
        let fileReader = new FileReader();
        fileReader.onload = function(e){
            let img = new Image();
            img.onload = function(e){
                console.log("img", img);
                console.log("canvas", canvas);
                let ctx = canvas.getContext("2d");
                canvas.width = img.width;
                canvas.height = img.height;
                canvas.width = 1000;
                canvas.height = canvas.width * (img.height / img.width);
                ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
                //imgFile = blobToFile(canvas.toDataURL('image/jpeg', 0.5), "img.jpg");
                //console.log("imgFile", imgFile.name);
                canvas.toBlob(function(blob){
                    imgFile = blobToFile(blob, "img.jpg");
                    console.log("imgFile", imgFile);
                    console.log("imgFilename", imgFile.name);
                }, 'image/jpeg', 0.95);
            };
            img.src = e.target.result;
        };
        fileReader.readAsDataURL(file);
    }
});

// Send a POST-request
function sendPostRequest(){
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

    var json = JSON.stringify(
        {
            mealName : mealName.value,
            mealType : mealType.value,
            mealTime : mealTime.value,
            mealDesc : mealDesc.value,
            mealNr : mealNr.value,
            ingredientsNr : ingredientsNr.value,
            mealPrep : mealPrep.value,
            file : imgFile
        }
    );
    console.log("json", json);

    var xhRequest = new XMLHttpRequest();
    xhRequest.open("POST", "./finishMeal.php", true);
    //xhRequest.setRequestHeader('Content-Type', 'application/json');
    xhRequest.onreadystatechange = (e) => {
        console.log(xhRequest.responseText);
      }
    xhRequest.send(formData);
}