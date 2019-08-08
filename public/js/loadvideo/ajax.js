var compteurLoad = 0;
var loadBy = "date";


filtreNote

$( "#filtreNote" ).click(function() {
    compteurLoad = 0;
    $(".container-video").html("");
    if(loadBy == "date"){
        loadBy = "note";
        loadVideoajax();
    }
});

$( "#filtreDate" ).click(function() {
    compteurLoad = 0;
    $(".container-video").html("");
    if(loadBy == "note"){
        loadBy = "date";
        loadVideoajax();
    }
});

$( window ).on( "load", function() {
    reloadAll = true;
    loadVideoajax();
});

$( "#buttonLoadVideo" ).click(function() {
    reloadAll = false;
    loadVideoajax();
});


function loadVideoajax(){



    $.ajax({
        url : '/loadvideo/'+compteurLoad+'/'+loadBy,
        type : 'GET',
        dataType : 'html',
        success : function(code_html, statut){
            $(".container-video").append(code_html);
            compteurLoad++;
        },
 
        error : function(resultat, statut, erreur){
            console.log("erreur");
        }
 
     });
}