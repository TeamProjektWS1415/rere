$(document).ready(function () {

    $('[data-toggle="tooltip"]').tooltip();


    // speichern button reaktion
    $('.speichern').click(function () {
        if (confirm("Durch OK clicken, werden die Daten gespeichert") === true) {
            //kommt was..
        }
    });

});