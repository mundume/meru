$(function() {
    $( document ).idleTimer( 30000 );
});

$(function() {
    $( document ).on( "idle.idleTimer", function(event, elem, obj){
        window.location.href = "/"
    });  
});