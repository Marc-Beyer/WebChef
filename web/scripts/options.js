var cookie = document.cookie; 

console.log("cookie", cookie);
if(cookie === ""){
    document.cookie = "style=0";
}