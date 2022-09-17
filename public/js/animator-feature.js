function animation(cls, first) {
    const aClass = cls;
    const ScreenHeight = $(aClass).innerHeight();
    $(aClass + " div").hide();
    startAnimato(0, aClass, first, ScreenHeight);
}

function startAnimato(id, aClass, first, ScreenHeight) {
    const divs = $(aClass + " div");
    const currentScreen = $(aClass).innerHeight();
    $(aClass + " ." + first).animate({
        "margin-top": ScreenHeight - currentScreen
    }, 1000);
    if (id < divs.length) {
        setTimeout(() => {
            divs.eq(id).show("slow");
            startAnimato(id + 1, aClass, first, ScreenHeight);
        }, 1500);
    } else {
        setTimeout(() => {
            $(aClass + " div:not(." + first + ")").hide();
            startAnimato(1, aClass, first, ScreenHeight);
        }, 4000);

    }
}

$(document).ready(function () {
    animation('.custom-animator', 'cts-h1');
    animation('.custom-animato-2', 'cts-h1-first');
});

