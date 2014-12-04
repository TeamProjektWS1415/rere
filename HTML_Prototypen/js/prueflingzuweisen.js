$(document).ready(function () {
    // tooltips
    $('[data-toggle="tooltip"]').tooltip();

    // delete button reaktion
    $('.delete').click(function () {
        var matrikelnr = $(this).parent("td").parent().first("td").find("span").first().text();
        $("#popupTitle").text("Loeschen");
        $(".popuptext").text("Wollen Sie den Pruefling mit Matrikelnummer " + matrikelnr + " wirklich loeschen? Der Pruefling selbst, sowie seine anderen Zuweisungen bleiben erhalten.");
        $('#popup').modal();
    });

});