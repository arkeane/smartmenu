function addToCart(str) {
    element_id = "isadded" + str;
    button_id = "addtocart" + str;
    cart_counter = parseInt(document.getElementById("cart_counter").innerHTML);
    var xhttp;
    // make post request to add_to_cart.php
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById(element_id).innerHTML = "Added to cart";
            document.getElementById(button_id).disabled = true;
            document.getElementById(button_id).hidden = true;

            document.getElementById("cart_counter").innerHTML = cart_counter + 1 ;
        }
    }
    xhttp.open("POST", "add_to_cart.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("id=" + str);
}

function Evaluate(bool, id){
    rateform = "rateform" + id;
    evaluate = "evaluate" + id;
    if (bool == "true"){
        document.getElementById(evaluate).innerHTML = "Already evaluated";
        document.getElementById(evaluate).disabled = true;
    }
    else{
        document.getElementById(rateform).style.display = "block";
        document.getElementById(evaluate).hidden = true;
    }
}

window.onload = function() {
    var elements = document.getElementsByClassName("rating");
    for (var i = 0; i < elements.length; i++) {
        var value = elements[i].innerHTML;
        elements[i].innerHTML = "";
        value = parseInt(value);
        for (var j = 0; j < 5; j++) {
            if (j < value) {
                elements[i].innerHTML += "<span class='fa fa-star checked'></span>";
            }
            else {
                elements[i].innerHTML += "";
            }
        }   
        
    }
}
    