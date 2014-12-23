/*
 * Globales JS, ist für alle Seiten im RERE Modul gleich.
 *
 */

$(document).ready(function () {

    // Legt die Tooltips an.
    $(".gettooltip").attr("data-toggle", "tooltip");
    $(".gettooltip").attr("data-placement", "bottom");
});


// Löschfunktion eines Elements, es wird ein Popup aufgerufen,
// hier muss dann bestätigt werden dass dieses wirklich gelöscht werden soll.
function delentry(text, link) {
    $("#popupTitle").text("Loeschen");
    $(".popuptext").text(text);
    $("#delbuttonmodal").attr("href", link);
    $('#popup').modal();
}