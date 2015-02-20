$(document).ready(function () {
    // Make table sortable
    $("#grades").tablesorter({
        headers: {
            4: {
                sorter: false
            },
            5: {
                sorter: false
            }
        }
    });
    // tooltips
    $('[data-toggle="tooltip"]').tooltip();
    // Ajax Call für neue Note
    $(".sendNote").change(function () {
        $(".waitingpanel").fadeIn("slow");
        var uid = $(this).parent('td').parent('tr').find('.noteuid').val();
        $('#editnote' + uid).submit();
    });
    // search funktion
    // colors the searched MatrikelNR
    $("#suche").on("keyup", function () {
        var value = $(this).val();
        $("#grades tr").each(function (index) {
            if (index !== 0) {
                $row = $(this);
                var matrikel = $row.find("td:first").text();
                var nachname = $row.find("td:nth-child(3)").text();
                var vorname = $row.find("td:nth-child(4)").text();
                if ((matrikel.indexOf(value) !== 0 && nachname.indexOf(value) !== 0 && vorname.indexOf(value) !== 0) || value === "") {
                    $row.removeClass("highlight");
                } else {
                    $row.addClass("highlight");
                }
            }
        });
    });
    /* Text wird durch Textfeld ersetzt
     $("td").click(function () {
     $(this).find("input").removeClass("hidden");
     $(this).find(".value").addClass("hidden");
     });*/

    // Expand textarea -> Zum Tippen vergrößern beim Focus
    $(".kommentar").focus(function () {
        $(this).animate({'height': '185px'}, 'slow');//Expand the textarea on clicking on it
        return false;
    });

    // Blendet alle wieder ein
    $("#alle").click(function () {
        showAll();
        removeActive();
        $("#alle").addClass("active");
    });
    // Blendet nur die bereits eingetragenen ein
    $("#eingetragene").click(function () {
        showAll();
        $(".notenwert").each(function () {
            if ($(this).val() === '0') {
                $(this).parent("td").parent("tr").fadeOut();
            }
        });
        removeActive();
        $("#eingetragene").addClass("active");
    });
    // Zeigt nur die die noch einzutragen sind
    $("#nichteingetragene").click(function () {
        showAll();
        $(".notenwert").each(function () {
            if ($(this).val() !== '0') {
                $(this).parent("td").parent("tr").fadeOut();
            }
        });
        removeActive();
        $("#nichteingetragene").addClass("active");
    });
});
/**
 * Generiert das chart.
 * @param {type} array
 * @param {type} div
 * @returns {undefined}
 */
function genchart(array, div) {

//    if (div === Null) {
//        div = "gradeChart";
//    }

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
    var ctx = document.getElementById(div).getContext("2d");
    window.myLine = new Chart(ctx).Bar(data, {
        responsive: true,
        scaleBeginAtZero: true
    });
}

/**
 * Entfernt bei allen Menüelementen die active class
 * @returns {undefined}
 */
function removeActive() {
    $("#alle").removeClass("active");
    $("#nichteingetragene").removeClass("active");
    $("#eingetragene").removeClass("active");
}

/**
 * Zeigt wieder alle an
 * @returns {undefined}
 */
function showAll() {
    $(".notenwert").each(function () {
        $(this).parent("td").parent("tr").fadeIn();
    });
}