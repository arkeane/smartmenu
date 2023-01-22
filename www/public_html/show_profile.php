<!DOCTYPE html>

<head>
    <title>Profile</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- style.css -->
    <link rel="stylesheet" href="css/style.css">

    <!-- Bootstrap core JavaScript -->
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</head>

<?php
session_start();

if (!isset($_SESSION["email"])) {
    header("Location: login_page.php?error=notloggedin");
}
?>

<body class="sitewide">
    <header class="header">
        <?php
        include 'navbar/navbar.php';
        ?>
    </header>

    <div class="container-fluid">
        <div class="row">
            <div class="col p-3">
                <div class="card bg-dark text-light ">
                    <div class="card-header">
                        <span class=fs-2>Profile</span>
                    </div>
                    <div class="card-body">
                        <?php
                        require 'db_config.php';

                        $sql = mysqli_prepare($conn, "SELECT * FROM users WHERE email=?");
                        mysqli_stmt_bind_param($sql, "s", $_SESSION["email"]);
                        mysqli_stmt_execute($sql);
                        $result = mysqli_stmt_get_result($sql);
                        $row = mysqli_fetch_assoc($result);

                        $email_hash = md5($row["email"]);
                        $img = 'https://www.gravatar.com/avatar/' . $email_hash . '?d=retro&f=y';

                        echo "<img class='img-thumbnail mx-2 mt-2' src=" . $img . " alt='Profile Pic'><br><br>";

                        ?>
                        <div class="container-fluid mt-2">
                            <ul class="list-group list-group-flush">
                                <?php
                                echo "<p class='fs-4'>Restaurant: " . $row["restaurant_name"] . "</p>";
                                echo "<p class='fs-4'>Email: " . $row["email"] . "</p>";
                                echo "<p class='fs-4'>First Name: " . $row["firstname"] . "</p>";
                                echo "<p class='fs-4'>Last Name: " . $row["lastname"] . "</p>";

                                $_SESSION["restaurant_name"] = $row["restaurant_name"];
                                $_SESSION["firstname"] = $row["firstname"];
                                $_SESSION["lastname"] = $row["lastname"];

                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card bg-dark text-light mt-2">
                    <div class="card-header">
                        <span class=fs-2>Manage Profile</span>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <a href="update_profile.php" class="btn btn-outline-light">Edit Profile</a>
                            <a href="change_password.php" class="btn btn-outline-light mt-3">Change Password</a>
                            <a href="delete_profile.php" class="btn btn-danger mt-3">Delete Profile</a>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col p-3">
                <div class="card bg-dark text-light">
                    <div class="card-header">
                        <span class=fs-2>Menus</span>
                        <p class="text-white-50 mb-3">Click on the wanted menu to edit</p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <?php

                        $sql = mysqli_prepare($conn, "SELECT * FROM menus WHERE restaurant_id=?");
                        mysqli_stmt_bind_param($sql, "s", $_SESSION["db_id"]);
                        mysqli_stmt_execute($sql);
                        $result = mysqli_stmt_get_result($sql);
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<a href='menu/edit_menu.php?menu_id=" . $row["id"] . "' class='list-group-item list-group-item-dark btn'>" . $row["name"] . "</a>";
                        }
                        ?>
                    </ul>
                </div>
            </div>
            <div class="col p-3">
                <div class="card bg-dark text-light">
                    <div class="card-header">
                        <span class=fs-2>Templates</span>
                        <p class="text-white-50 mb-3">Click on the wanted template to create a menu</p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <?php
                        $sql = mysqli_prepare($conn, "SELECT template_id, name FROM templates, bought_templates WHERE templates.id = bought_templates.template_id AND bought_templates.restaurant_id=?");
                        mysqli_stmt_bind_param($sql, "s", $_SESSION["db_id"]);
                        mysqli_stmt_execute($sql);
                        $result = mysqli_stmt_get_result($sql);
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<a href='menu/add_menu.php?template_id=" . $row["template_id"] . "' class=' list-group-item list-group-item-dark btn'>" . $row["name"] . "</a>";
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <footer class="fixed-bottom bg-dark">
        <!-- Copyright -->
        <div class="container-fluid text-center mt-3">
            <p class="text-light">© 2023 Copyright: SmartMenu</p>
        </div>
        <!-- Copyright -->
    </footer>

</body>

</html>