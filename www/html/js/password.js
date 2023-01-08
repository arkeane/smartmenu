var myInput = document.getElementById("typePasswordPass");
var myconfirmInput = document.getElementById("typePasswordConfirm");

// When the user clicks on the password field, show the message box
myInput.onfocus = function () {
    document.getElementById("typePasswordPass").style.border = "2px solid red";
}

// each time the user types a key, check if the password is valid
myInput.onkeyup = function () {
    // check if the written password is valid
    if (myInput.value.match(/[a-z]/g) && myInput.value.match(/[A-Z]/g) && myInput.value.match(/[0-9]/g) && myInput.value.match(/[^a-zA-Z\d]/g) && myInput.value.length >= 8) {
        // if the password is valid, remove the message box
        document.getElementById("typePasswordPass").style.border = "2px solid #00FF00";
    }
    else {
        // if the password is not valid, show the message box
        document.getElementById("typePasswordPass").style.border = "2px solid red";
    }
}

// when the user clicks on the confirm password field check if the two passwords match
myconfirmInput.onkeyup = function () {
    if (myconfirmInput.value == myInput.value) {
        // if the two passwords match, remove the message box
        document.getElementById("typePasswordConfirm").style.border = "2px solid #00FF00";
    }
    else {
        // if the two passwords don't match, show the message box
        document.getElementById("typePasswordConfirm").style.border = "2px solid red";
    }
}
