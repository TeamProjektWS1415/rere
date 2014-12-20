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


// delete button reaktion
function delentry(matrikelnr, note) {
    $("#popupTitle").text("Loeschen");
    $(".popuptext").text("Wollen Sie den Pruefling mit Matrikelnummer " + matrikelnr + " wirklich aus diesem Fach loeschen?");
    $(".delbutton").setAttribute("arguments", note);
    $('#popup').modal();
}