var compteurLoad = 0;

$( window ).on( "load", function() {
    loadVideoajax();
});

$( "#buttonLoadVideo" ).click(function() {
    loadVideoajax();
  });


function loadVideoajax(){
    compteurLoad++;
    $.ajax({
        url : '/loadvideo/'+compteurLoad,
        type : 'GET',
        dataType : 'html',
        success : function(code_html, statut){
            $(".container-video").html(code_html);
        },
 
        error : function(resultat, statut, erreur){
            console.log("erreur");
        }
 
     });
}