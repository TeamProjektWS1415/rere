/*
 * Globales JS, ist für alle Seiten im RERE Modul gleich.
 *
 */

var arrayPrueflinge;

$(document).ready(function () {

    // Legt die Tooltips an.
    $(".gettooltip").attr("data-toggle", "tooltip");
    $(".gettooltip").attr("data-placement", "bottom");

    // Setzen des Intervalls
    $("#studienhalbjahr").click(function () {
        swapIntervall();
    });
    $("#schuljahr").click(function () {
        swapIntervall();
    });

    $("#suchematrikel").keyup(function () {
        for (x in arrayPrueflinge) {
            if (arrayPrueflinge[x] === $("#suchematrikel").val()) {
                alert("Gerunden");
                break;
            }
        }
    });


});

/**
 * Setzt den haken beim Aktiven Intervall
 * @returns {undefined}
 */
function swapIntervall() {
    if ($("#studienhalbjahr span").hasClass("aciveinterval")) {
        $("#studienhalbjahr span").removeClass("aciveinterval");
        $("#studienhalbjahr span").addClass("inactiveinterval");
        $("#schuljahr span").removeClass("inactiveinterval");
        $("#schuljahr span").addClass("aciveinterval");
    } else {
        $("#schuljahr span").removeClass("aciveinterval");
        $("#schuljahr span").addClass("inactiveinterval");
        $("#studienhalbjahr span").removeClass("inactiveinterval");
        $("#studienhalbjahr span").addClass("aciveinterval");
    }
}

// Löschfunktion eines Elements, es wird ein Popup aufgerufen,
// hier muss dann bestätigt werden dass dieses wirklich gelöscht werden soll.
function delentry(text, link) {
    $("#popupTitle").text("Loeschen");
    $(".popuptext").text(text);
    $("#delbuttonmodal").attr("href", link);
    $('#popup').modal();
}