
function validCGU() {

    var _cgu = document.getElementById("CGU");

    if (!_cgu.checked) {
        alert("Merci de valider les conditions générales.\nPlease accept the legal terms.");
        return false;
    }
    return true;
}


function showCGU() {

    var _cgu = document.getElementById("Conditions");

	_cgu.style.display="block";
	
    return true;

}
