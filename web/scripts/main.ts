{
    let welcomeMsg : string = "__  __                  ____                          \n|  \\/  | __ _ _ __ ___  | __ )  ___ _   _  ___ _ __    \n| |\\/| |/ _` | '__/ __| |  _ \\ / _ \\ | | |/ _ \\ '__|   \n| |  | | (_| | | | (__  | |_) |  __/ |_| |  __/ |      \n|_|  |_|\\__,_|_|  \\___| |____/ \\___|\\__, |\\___|_|      \n_____ _____ _____ _____ _____ _____|___/_ _____ _____ \n|_____|_____|_____|_____|_____|_____|_____|_____|_____|";
    let alreadyChanged : boolean;

    console.log(welcomeMsg);

    function checkIfUserScrolled() : void {
        if (!alreadyChanged && window.scrollY > 1) {
            alreadyChanged = true;
            $("#logo img").animate({"height":"2rem"},111);
        }
        if (alreadyChanged && window.scrollY <= 1) {
            alreadyChanged = false;
            $("#logo img").animate({"height":"5rem"},111);
        }
    }

    //change the logo when scrolled down
    window.addEventListener('scroll', function (e) {
        checkIfUserScrolled();
    });

    //add listener to the moblieNavBtn
    $("#logo img").on( "click", function() {
        console.log( $( this ).text() );
    });

    var isNavOpen = false;
    
    //add eventlistener to navMenuBtn
    $( document ).ready(function() {
        $("#mobileNavButton").click(function(){
            if(!isNavOpen){
                $(".dropdown").show();
                $(".subMenu").show();
                $(".subMenu li").show();
            }else{
                $(".dropdown:not(#mobileNavBtn)").hide();
                $(".subMenu").hide();
                $(".subMenu li").hide();
                $("#mobileNavBtn").show();
            }
            isNavOpen = !isNavOpen;
        });

        console.log( $("#searchbarBtn"));
        $("#searchbarBtn").click(function(){
            console.log( $("#searchbarBtn")[0]);
        });
    });
}