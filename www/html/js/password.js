var myInput = document.getElementById("typePasswordPass");
var myconfirmInput = document.getElementById("typePasswordConfirm");

myInput.onfocus = function () {
    document.getElementById("typePasswordPass").style.border = "2px solid red";
}

myInput.onkeyup = function () {
    if (myInput.value.match(/[a-z]/g) && myInput.value.match(/[A-Z]/g) && myInput.value.match(/[0-9]/g) && myInput.value.match(/[^a-zA-Z\d]/g) && myInput.value.length >= 8) {
        document.getElementById("typePasswordPass").style.border = "2px solid #00FF00";
    }
    else {
        document.getElementById("typePasswordPass").style.border = "2px solid red";
    }
}

myconfirmInput.onkeyup = function () {
    if (myconfirmInput.value == myInput.value) {
        document.getElementById("typePasswordConfirm").style.border = "2px solid #00FF00";
    }
    else {
        document.getElementById("typePasswordConfirm").style.border = "2px solid red";
    }
}

function showPass() {
    if (myInput.type === "password" && myconfirmInput.type === "password") {
        myInput.type = "text";
        myconfirmInput.type = "text";
    } else {
        myInput.type = "password";
        myconfirmInput.type = "password";
    }
}
