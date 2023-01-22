<?php

session_start();

if(!isset($_POST["id"])) {
    exit;
}

$template_id = $_POST["id"];

// check if cookie is set
if(!isset($_COOKIE["cart"])) {
    $cart = array();
} else {
    $cart = json_decode($_COOKIE["cart"], true);
}

// check if template is already in cart
if(!in_array($template_id, $cart)) {
    array_push($cart, $template_id);
}

// set cookie
setcookie("cart", json_encode($cart), time() + (86400 * 30), "/");