{
    var welcomeMsg = "__  __                  ____                          \n|  \\/  | __ _ _ __ ___  | __ )  ___ _   _  ___ _ __    \n| |\\/| |/ _` | '__/ __| |  _ \\ / _ \\ | | |/ _ \\ '__|   \n| |  | | (_| | | | (__  | |_) |  __/ |_| |  __/ |      \n|_|  |_|\\__,_|_|  \\___| |____/ \\___|\\__, |\\___|_|      \n_____ _____ _____ _____ _____ _____|___/_ _____ _____ \n|_____|_____|_____|_____|_____|_____|_____|_____|_____|";
    var alreadyChanged_1;
    var isNavOpen = false;

    console.log(welcomeMsg);

    function checkIfUserScrolled() {
        if (!alreadyChanged_1 && window.scrollY > 1) {
            alreadyChanged_1 = true;
            $("#logo img").animate({ "height": "2rem" }, 111);
        }
        if (alreadyChanged_1 && window.scrollY <= 1) {
            alreadyChanged_1 = false;
            $("#logo img").animate({ "height": "5rem" }, 111);
        }
    }

    //change the logo when scrolled down
    window.addEventListener('scroll', function (e) {
        checkIfUserScrolled();
    });
    
    //add eventlistener to navMenuBtn
    $(document).ready(function () {

        //Add event to search
        $("#searchbarBtn").click(function () {
            window.open("./index.php?search=" + $("#searchInput")[0].value, "_self");
        });

        $("#searchInput").keyup(function (e) {
            if (e.keyCode == 13) {
                window.open("./index.php?search=" + $("#searchInput")[0].value, "_self");
            }
        });

        //Add event to mobileNavButton
        $("#mobileNavButton").click(function () {
            if (!isNavOpen) {
                $(".dropdown").show();
                $(".subMenu").show();
                $(".subMenu li").show();
            }else {
                $(".dropdown:not(#mobileNavBtn)").hide();
                $(".subMenu").hide();
                $(".subMenu li").hide();
                $("#mobileNavBtn").show();
            }
            isNavOpen = !isNavOpen;
        });
    
        //add listener to the logo
        $("#logo img").on("click", function () {
            window.open("./index.php", "_self");
        });
    });
}
