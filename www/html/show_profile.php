<!DOCTYPE html>

<head>
    <title>Profile</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- style.css -->
    <link rel="stylesheet" href="./css/style.css">

    <!-- Bootstrap core JavaScript -->
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <script defer src="./js/main.js"></script>
</head>

<?php
session_start();

if (!isset($_SESSION["email"])) {
    header("Location: login_page.php");
}
?>

<body>
    <header class="header">
        <nav class="navbar navbar-dark bg-dark navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <img class="mx-3" src="./img/pizza.svg" alt="logo" width="30" height="30">
                <a class="navbar-brand" href="index.php">HOME</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="Logout.php">Logout</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="market/market.php">Template Market</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="about.php">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="contact.php">Contact</a>
                        </li>
                    </ul>
                    <form class="d-flex" role="search">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-light" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </nav>
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
                        include 'db_config.php';

                        $sql = "SELECT * FROM users WHERE email='$_SESSION[email]'";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);

                        $email_hash = md5($row["email"]);
                        $img = 'https://www.gravatar.com/avatar/' . $email_hash . '?d=retro&f=y';

                        echo "<img class='img-thumbnail mx-2 mt-4' src=" . $img . " alt='Profile Pic'><br><br>";

                        ?>
                        <div class="container-fluid mt-4">
                            <ul class="list-group list-group-flush">
                                <?php
                                echo "<p class='fs-4'>Email: " . $row["email"] . "</p>";
                                echo "<p class='fs-4'>First Name: " . $row["firstname"] . "</p>";
                                echo "<p class='fs-4'>Last Name: " . $row["lastname"] . "</p>";

                                $_SESSION["firstname"] = $row["firstname"];
                                $_SESSION["lastname"] = $row["lastname"];

                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card bg-dark text-light mt-3">
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
                    </div>
                    <ul class="list-group list-group-flush">
                        <?php

                        $sql = "SELECT * FROM menus WHERE restaurant_id='$_SESSION[db_id]'";
                        $result = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<a href='/menu/edit_menu.php?menu_id=" . $row["id"] . "' class='list-group-item list-group-item-dark btn'>" . $row["name"] . "</a>";
                        }
                        ?>
                    </ul>
                </div>
            </div>
            <div class="col p-3">
                <div class="card bg-dark text-light">
                    <div class="card-header">
                        <span class=fs-2>Templates</span>
                    </div>
                    <ul class="list-group list-group-flush">
                        <?php
                        $sql = "SELECT template_id, name FROM templates, bought_templates WHERE templates.id = bought_templates.template_id AND bought_templates.restaurant_id='$_SESSION[db_id]'";
                        $result = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<a href='/menu/add_menu.php?template_id=" . $row["template_id"] . "' class=' list-group-item list-group-item-dark btn'>" . $row["name"] . "</a>";
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