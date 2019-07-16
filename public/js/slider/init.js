var imgActuel = 1;
init();

function init(){
    $(".slider-img1").css({
        "top" : "0",
        "left" : "0"
    });
    $(".slider-img2").css({
        "top" : "0",
        "left" : "100%",
    });
}

$( ".silde-buttonright" ).click(function() {
    slideright();
  });

$( ".slide-buttonleft" ).click(function() {
    slideleft();
  });



function slideright(){
    if(imgActuel == 1){
        $(".slider-img1").css({
            "left":"100%",
            "animation" : "AnimrightMain 1s"
        });
        $(".slider-img2").css({
            "left":"0%",
            "animation" : "AnimrightNotMain 1s"
        });
        imgActuel = 2;
    }
    else{
        $(".slider-img2").css({
            "left":"100%",
            "animation" : "AnimrightMain 1s"
        });
        $(".slider-img1").css({
            "left":"0",
            "animation" : "AnimrightNotMain 1s"
        });
        imgActuel = 1;
    }
}

function slideleft(){
    if(imgActuel == 1){
        $(".slider-img1").css({
            "left":"-100%",
            "animation" : "AnimleftMain 1s"
        });
        $(".slider-img2").css({
            "left":"0%",
            "animation" : "AnimleftNotMain 1s"
        });
        imgActuel = 2;
    }
    else{
        $(".slider-img2").css({
            "left":"-100%",
            "animation" : "AnimleftMain 1s"
        });
        $(".slider-img1").css({
            "left":"0%",
            "animation" : "AnimleftNotMain 1s"
        });
        imgActuel = 1;
    }
}