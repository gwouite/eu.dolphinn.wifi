
function validCGU() {

    var _cgu = document.getElementById("CGU");

    if (!_cgu.checked) {
        alert("Merci de valider les conditions générales.\nPlease accept the legal terms.");
        return false;
    }
    return true;
}