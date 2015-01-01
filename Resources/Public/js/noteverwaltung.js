$(document).ready(function () {
// Make table sortable
    $("#grades").tablesorter();
    // tooltips
    $('[data-toggle="tooltip"]').tooltip();

    // Ajax Call für neue Note
    $(".sendNote").focusout(function () {
        var uid = $(this).parent('td').parent('tr').find('.noteuid').val();
        $('#editnote' + uid).submit();
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

    // Blendet alle wieder ein
    $("#alle").click(function () {
        $(".notenwert").each(function () {
            $(this).parent("td").parent("tr").fadeIn();
        });
    });

    // Blendet nur die bereits eingetragenen ein
    $("#eingetragene").click(function () {
        $(".notenwert").each(function () {
            if ($(this).val() === '0') {
                $(this).parent("td").parent("tr").fadeOut();
            }
        });
    });

    // Zeigt nur die die noch einzutragen sind
    $("#nichteingetragene").click(function () {
        $(".notenwert").each(function () {
            if ($(this).val() !== '0') {
                $(this).parent("td").parent("tr").fadeOut();
            }
        });
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
        responsive: true,
        scaleBeginAtZero: true
    });
}