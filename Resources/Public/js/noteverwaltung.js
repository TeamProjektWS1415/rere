$(document).ready(function () {

    // Make table sortable
    $("#grades").tablesorter();

    // tooltips
    $('[data-toggle="tooltip"]').tooltip();


    var data = {
        labels: ["1", "1,3", "1,7", "2", "2,3", "2,7", "3", "3,3", "3,7", "4", "5"],
        datasets: [
            {
                label: "Noten",
                fillColor: "rgba(220,220,220,0.2)",
                strokeColor: "#5bc0de",
                pointColor: "#00a2d2",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(220,220,220,1)",
                data: [1, 13, 5, 4, 5, 1, 2, 2, 2, 1, 0]
            }
        ]
    };

    // Chart
    var ctx = document.getElementById("gradeChart").getContext("2d");
    window.myLine = new Chart(ctx).Line(data, {
        responsive: true
    });

    // delete button reaktion
    $('.delete').click(function () {
        var matrikelnr = $(this).parent("td").parent().first("td").find("span").first().text();
        $("#popupTitle").text("Loeschen");
        $(".popuptext").text("Wollen Sie den Pruefling mit Matrikelnummer " + matrikelnr + " wirklich aus diesem Fach loeschen?");
        $('#popup').modal();
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