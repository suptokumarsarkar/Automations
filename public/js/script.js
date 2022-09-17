$(document).ready(function () {
    const g = $(".ctm_animato svg g");
    displayG(0, g);
    $(".navbar-nav .nav-item").click(function () {
        $(this).find(".dropdown-toggle").toggleClass("active");
        $(this).find(".hover_menu").slideToggle(500);
    });

});


function displayG(item, g) {
    if (item < g.length) {
        g.eq(item).show("slow");
        setTimeout(() => {
            displayG(item + 1, g);
        }, 100);
    }

}

function rjSearch(th) {
    $("#rjsearch_result").slideToggle(100);
    $(th).find("i").toggleClass("fa-search");
    $(th).find("i").toggleClass("fa-close");
    $(".navbar-brand").slideToggle();
}


function scroll_to_id(id, top) {
    let tops = $(id).offset().top;
    tops = tops - top;
    $("body,html").animate({
        scrollTop: tops
    }, 700);
}

function removeAfter(time, item) {
    setTimeout(() => {
        $(item).fadeOut("slow");
    }, time);
}

$(window).load(function () {
    $(".auto-closer").each(function (index, value) {
        removeAfter(Number($(value).attr("removeAfter")) * 1000, value)
    });

});

$(".alert-dismissible .close").click(function () {
    $(this).parent().hide("slow");
});


