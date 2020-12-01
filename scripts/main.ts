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

    //add eventlistener to navMenuBtn
    $("mobileNavButton").click(function(){
        console.log("clicked mobileNamButton!");
        $(".dropdown").toggle();
    });
}