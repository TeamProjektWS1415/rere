$(document).ready(function () {

    // tooltips
    $('[data-toggle="tooltip"]').tooltip();

    // delete Fach button reaktion
    $('.deletefach').click(function () {
        if (confirm("Wollen Sie das Fach mit allen zugehoerenden Noten wirklich loeschen?") === true) {
            // Hier kommt dann der aufruf zum löschen
        }
    });

    // delete Modul button reaktion
    $('.modulloeschenbutton').click(function () {
        if (confirm("Wollen Sie das Modul mit allen zugehoerenden Faechern und Noten wirklich loeschen?") === true) {
            // Hier kommt dann der aufruf zum löschen
        }
    });

});