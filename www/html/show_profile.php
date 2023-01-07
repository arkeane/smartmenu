<?php
    session_start();

    if (!isset($_SESSION["email"])) {
        header("Location: error.html");
    }

    echo "Hello, " . $_SESSION["email"];
?>