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
                data: [2, 3, 1, 4, 3, 5, 2, 2, 3, 0, 2]
            }
        ]
    };

    // Chart
    var ctx = document.getElementById("gradeChart").getContext("2d");
    window.myLine = new Chart(ctx).Line(data, {
        responsive: true
    });

	

});

