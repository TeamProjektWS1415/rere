/*
 * Globales JS, ist für alle Seiten im RERE Modul gleich.
 *
 */

var arrayPrueflinge;
var arrayFachPrueflinge;

$(document).ready(function () {
    // Make table sortable
    $("#prueflinge").tablesorter({
	headers: {
	    3: {
		sorter: false
	    }
	}
    });

    // Legt die Tooltips an.
    $(".gettooltip").attr("data-toggle", "tooltip");
    $(".gettooltip").attr("data-placement", "bottom");

    // Prüft ob die Matrikelnummer gültig ist.
    $("#suchematrikel").keyup(function () {
	for (x in arrayPrueflinge) {
	    if (arrayPrueflinge[x] === $("#suchematrikel").val()) {
		$("#searchicon").removeClass("notfound");
		$("#searchicon").addClass("found");
		break;
	    } else {
		$("#searchicon").removeClass("found");
		$("#searchicon").addClass("notfound");
	    }
	}
    });

    // Ajax Call für neue Note
    $(".setMasterstudiengang").change(function () {
	$(".waitingpanel").fadeIn("slow");
	$(".spinningicon").fadeIn("slow");
	$('#masterstudiengangchange').submit();
    });

});

// Löschfunktion eines Elements, es wird ein Popup aufgerufen,
// hier muss dann bestätigt werden dass dieses wirklich gelöscht werden soll.
function delentry(text, link) {
    $("#popupTitle").text("Löschen");
    $(".popuptext").text(text);
    $("#delbuttonmodal").attr("href", link);
    $('#popup').modal();
}


// Prüft ob ein Student bereits zugewiesen wurde, falls ja, wird abgebrochen.
function diffInput() {
    for (z in arrayFachPrueflinge) {
	if (arrayFachPrueflinge[z] === $("#suchematrikel").val()) {
	    $("#infopopupTitle").text("Info");
	    $(".popuptext").text("Dieser Student wurde dem Fach bereits zugewiesen");
	    $('#infopopup').modal();
	    return false;
	}
    }
    return true;
}