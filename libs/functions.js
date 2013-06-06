function showDetails(id) {
	if (document.getElementById("details" + id).style.visibility != "visible") {
		document.getElementById("details" + id).style.visibility = "visible";
	} else {
		document.getElementById("details" + id).style.visibility = "hidden";
	}
}

function checkIncValues(field, inc_min, inc_max) {
	if (field.value < inc_min || field.value > inc_max) {
		field.value = 0;		
		window.alert('Please enter a value between ' + inc_min + ' and ' + inc_max);		
    }
}