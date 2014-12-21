$(document).ready(function () {
// Make table sortable
    $("#grades").tablesorter();
    // tooltips
    $('[data-toggle="tooltip"]').tooltip();

    // Ajax Call für neue Note
    $(".save").click(function () {
        alert("Speichert die Note");
        $(".err").hide();

        var kommentar = $("#kommentar").val();

        // Post aufruf
        $.post("index.php?eID=script",
                {kommentar: "wuhu", werr: "1.0", notennr: "50"},
        function (data) {
        });

    });

    // search funktion
    // colors the searched MatrikelNR
    $("#suche").on("keyup", function () {
        var value = $(this).val();
        $("table tr").each(function (index) {
            if (index !== 0) {
                $row = $(this);
                var id = $row.find("td:first").text();
                if (id.indexOf(value) !== 0 || value === "") {
                    // Remove color
                    $row.removeClass("highlight");
                }
                else {
                    // Set the color
                    $row.addClass("highlight");
                }
            }
        });
    });
    // Text wird durch Textfeld ersetzt
    $("td").click(function () {
        $(this).find("input").removeClass("hidden");
        $(this).find(".value").addClass("hidden");
    });
});

/**
 * Generiert das chart.
 * @param {type} array
 * @returns {undefined}
 */
function genchart(array) {

    var labels = [];
    var results = [];

    // Itteriert durch das vom controller gesendete Array und erzeugt dynamisch werte für das Label des Chars und der Werte
    for (r in array) {
        labels.push(r);
        results.push(array[r]);
    }

    // Chart Data configs.
    var data = {
        labels: labels,
        datasets: [
            {
                label: "Noten",
                fillColor: "rgba(220,220,220,0.2)",
                strokeColor: "#5bc0de",
                pointColor: "#00a2d2",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(220,220,220,1)",
                data: results
            }
        ]
    };
    // Chart
    var ctx = document.getElementById("gradeChart").getContext("2d");
    window.myLine = new Chart(ctx).Line(data, {
        responsive: true
    });
}


// Löschfunktion einer Note, es wird ein Popup aufgerufen,
// hier muss dann bestätigt werden dass die Note wirklich gelöscht werden soll.
function delentry(matrikelnr, link) {
    $("#popupTitle").text("Loeschen");
    $(".popuptext").text("Wollen Sie den Pruefling mit Matrikelnummer " + matrikelnr + " wirklich aus diesem Fach loeschen?");
    $("#delbuttonmodal").attr("href", link);
    $('#popup').modal();
}