const fileInput = document.getElementById("file");
const canvas = document.getElementById("resizeCanvas");

const mealName = document.getElementById("mealNameInput");
const mealType = document.getElementById("mealTypeInput");
const mealTime = document.getElementById("mealTimeInput");
const mealDesc = document.getElementById("mealDescInput");
const mealNr = document.getElementById("mealNrInput");
const ingredientsNr = document.getElementById("ingredientsNr");
const mealPrep = document.getElementById("mealPrepInput");


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
                var file =  canvas.toDataURL('image/jpeg', 0.5);
                sendPostRequest(file);
            };
            img.src = e.target.result;
        };
        fileReader.readAsDataURL(file);
    }
});

// Send a POST-request
function sendPostRequest(data){
    var test = "This is a test";
    var json = JSON.stringify(
        {
            mealName : mealName.value,
            mealType : mealType.value,
            mealTime : mealTime.value,
            mealDesc : mealDesc.value,
            mealNr : mealNr.value,
            ingredientsNr : ingredientsNr.value,
            mealPrep : mealPrep.value,
            file : data
        }
    );
    console.log("json", json);

    var xhRequest = new XMLHttpRequest();
    xhRequest.open("POST", "./test.php", true);
    xhRequest.setRequestHeader('Content-Type', 'application/json');
    xhRequest.onreadystatechange = (e) => {
        console.log(xhRequest.responseText);
      }
    xhRequest.send(json);
}