<?php

// check if cookie is set
if(!isset($_COOKIE["cart"])) {
    exit;
}

$cart = json_decode($_COOKIE["cart"], true);

// check if template is in cart
if(!in_array($_GET["template_id"], $cart)) {
    exit;
}

// remove template from cart
$cart = array_diff($cart, array($_GET["template_id"]));

// if cart is empty, delete cookie
if(empty($cart)) {
    setcookie("cart", "", time() - 3600, "/");
    header("Location: cart.php");
    exit;
}
else {
    // update cookie
    setcookie("cart", json_encode($cart), time() + (86400 * 30), "/");
    header("Location: cart.php");
    exit;
}

header("Location: cart.php");