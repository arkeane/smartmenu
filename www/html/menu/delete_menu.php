<?php
session_start();

include '../db_config.php';

if (!isset($_SESSION["email"])) {
    header("Location: login_page.php");
}

$sql = "DELETE FROM menus WHERE id = '$_SESSION[menu_id]'";
$result = mysqli_query($conn, $sql);

unset($_SESSION['menu_id']);
header("Location: ../show_profile.php");

?>
