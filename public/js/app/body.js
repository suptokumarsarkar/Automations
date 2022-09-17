$(window).resize(function(){
    hideBar();
});
$(document).ready(function(){
    hideBar();
});

function hideBar(){
    let bar = $("#sidebar");
    let windowSize = $("body").innerWidth();
    if(windowSize < 774){
        bar.addClass('responsive14401');
        $(".minimize").hide();
    }else{
        bar.removeClass('responsive14401');
        $(".minimize").show();
    }
}
