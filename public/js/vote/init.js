$( "#vote1" ).click(function() {
    voteAjax(page , "1")
});
$( "#vote2" ).click(function() {
    voteAjax(page , "2")
});
$( "#vote3" ).click(function() {
    voteAjax(page , "3")
});
$( "#vote4" ).click(function() {
    voteAjax(page , "4")
});
$( "#vote5" ).click(function() {
    voteAjax(page , "5")
});

$( "#buttonVote" ).click(function() {
    openModal();
});

$( ".buttonClose" ).click(function() {
    closeModal();
});
$( "#closemodal" ).click(function() {
    closeModal();
});


function voteAjax(page, note){
    $.ajax({
        url : '/vote/'+page+'/'+note,
        type : 'GET',
        dataType : 'html',
        success : function(code_html, statut){
            $("#modalVote > div").html(code_html);
            setTimeout( closeModal , 3000);
        },
 
        error : function(resultat, statut, erreur){
            console.log("erreur");
        }
 
     });
}

function openModal(){
    $("#modalVote").css({"display" : "block"});
    $("#modalVote > div").css({"animation-name" : "openModal", "animation-duration" : "0.5s"});
}

function closeModal(){
    $("#modalVote").css({"display" : "none"});
}
