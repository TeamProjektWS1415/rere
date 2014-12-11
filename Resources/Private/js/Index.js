$(document).ready(function () {

    // tooltips
    $('[data-toggle="tooltip"]').tooltip();

    // delete Fach button reaktion
    $('.deletefach').click(function () {
        var fach = $(this).parent().siblings().text();
        $("#popupTitle").text("Loeschen");
        $(".popuptext").text("Wollen Sie das Fach " + fach + " mit allen zugehoerenden Noten wirklich loeschen?");
        $('#popup').modal();
    });

    // delete Modul button reaktion
    $('.modulloeschenbutton').click(function () {
        var modul = $(this).siblings("a").first().text();
        $("#popupTitle").text("Loeschen");
        $(".popuptext").text("Wollen Sie das Modul " + modul + " mit allen zugehoerenden Faechern und Noten wirklich loeschen?");
        $('#popup').modal();
    });
});