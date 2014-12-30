/*
 * Globales JS, ist für alle Seiten im RERE Modul gleich.
 *
 */

var arrayPrueflinge;

$(document).ready(function () {

    // Legt die Tooltips an.
    $(".gettooltip").attr("data-toggle", "tooltip");
    $(".gettooltip").attr("data-placement", "bottom");

    $("#suchematrikel").keyup(function () {
        for (x in arrayPrueflinge) {
            if (arrayPrueflinge[x] === $("#suchematrikel").val()) {
                //alert("Gerunden");
                $("#searchicon").removeClass("notfound");
                $("#searchicon").addClass("found");
                break;
            } else {
                $("#searchicon").removeClass("found");
                $("#searchicon").addClass("notfound");
            }
        }
    });

});

// Löschfunktion eines Elements, es wird ein Popup aufgerufen,
// hier muss dann bestätigt werden dass dieses wirklich gelöscht werden soll.
function delentry(text, link) {
    $("#popupTitle").text("Loeschen");
    $(".popuptext").text(text);
    $("#delbuttonmodal").attr("href", link);
    $('#popup').modal();
}