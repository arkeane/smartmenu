var myInput = document.getElementById("typePasswordPass");
var myconfirmInput = document.getElementById("typePasswordConfirm");

myInput.onfocus = function () {
    document.getElementById("typePasswordPass").style.border = "2px solid red";
}

function checkpass(str) {
    if (str.length <= 8) {
        document.getElementById("charcheck").style.color = "red";
    }
    else {
        document.getElementById("charcheck").style.color = "green";
    }
    if (!str.match(/[A-Z]/g)){
        document.getElementById("uppercheck").style.color = "red";
    }
    else {
        document.getElementById("uppercheck").style.color = "green";
    }
    if (!str.match(/[a-z]/g)){
        document.getElementById("lowercheck").style.color = "red";
    }
    else {
        document.getElementById("lowercheck").style.color = "green";
    }
    if (!str.match(/[0-9]/g)){
        document.getElementById("numcheck").style.color = "red";
    }
    else {
        document.getElementById("numcheck").style.color = "green";
    }

    if (str.match(/[A-Z]/g) && str.match(/[a-z]/g) && str.match(/[0-9]/g) && str.length > 8) {
        return true;
    }
    else {
        return false;
    }
}

myInput.onkeyup = function () {
    if (checkpass(myInput.value)) {
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
