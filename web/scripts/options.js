const cookieBtn = document.getElementById("cookieBtn");
const clearCookieBtn = document.getElementById("clearCookieBtn");
const themeInput = document.getElementById("themeInput");
const cssLink = document.getElementById("cssLink");

var cookie = document.cookie; 

cookieBtn.addEventListener("click", function(e){
    document.cookie = "theme=" + themeInput.value + "; SameSite=Strict";
    console.log("new cookie", document.cookie);
    window.open("./Einstellungen.php", "_self");
});
clearCookieBtn.addEventListener("click", function(e){
    document.cookie = "theme=1; expires=Thu, 01 Jan 1970 00:00:00 UTC";
    console.log("new cookie", document.cookie);
    window.open("./Einstellungen.php", "_self");
});

if(cookie === ""){
    cookieBtn.textContent = "Cookie setzen";
}else{
    clearCookieBtn.hidden = false;
    if(cookie.split("=")[1] === "1"){
        cssLink.href="./style/mainLight.css";
        themeInput.value = 1;
    }
}