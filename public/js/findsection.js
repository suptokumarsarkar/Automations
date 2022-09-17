$(document).ready(function(){
    $("body").click(function(event){
        if($(".dropdown-support-v3").hasClass("showAc")){
            if($( event.target ).parents().hasClass("css-wx80sp-Input__input-Dropdown__button") || $( event.target ).hasClass("css-wx80sp-Input__input-Dropdown__button")){
            }else{
                $(".dropdown-support-v3").removeClass("showAc");
            }
        }
    });
    $(".css-wx80sp-Input__input-Dropdown__button").click(function(){
        $(".dropdown-support-v3").toggleClass("showAc");
    });

});

function randIt(id,data){
    $(".css-15mnarb-Dropdown__buttonText").html($(data).html());
}
