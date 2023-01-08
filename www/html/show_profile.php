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
    header("Location: error.html");
}
?>

<header class="header">
    <nav class="navbar navbar-dark bg-dark navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <img class="mx-3" src="./img/pizza.svg" alt="logo" width="30" height="30">
            <a class="navbar-brand" href="index.php">SmartMenu</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="Logout.php">Logout</a>
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

<body>

    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-4" style="width: auto;">
                <div class="card mb-3" style="width: auto;  background-color:#212529; color:white">
                    <div class="card-body">
                        <div class="card-header">
                            <h3>Profile</h3>
                        </div>

                        <?php
                        include 'db_config.php';

                        $conn = new mysqli($servername, $username, $db_password, $dbname);
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        $sql = "SELECT * FROM users WHERE email='$_SESSION[email]'";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);

                        $email_hash = md5($row["email"]);
                        $img = 'https://www.gravatar.com/avatar/' . $email_hash . '?d=retro&f=y';

                        echo "<img src=" . $img . "class='rounded-circle' alt='...'>";
                        echo "<p class='card-text'>Email: " . $row["email"] . "</p>";
                        echo "<p class='card-text'>First Name: " . $row["firstname"] . "</p>";
                        echo "<p class='card-text'>Last Name: " . $row["lastname"] . "</p>";

                        $_SESSION["firstname"] = $row["firstname"];
                        $_SESSION["lastname"] = $row["lastname"];

                        ?>
                        <a href="update_profile.php" class="btn btn-outline-light">Edit Profile</a>
                    </div>
                </div>
            </div>
            <div class="col-4" style="width: auto;">
                <div class="card" style="width: auto;  background-color:#212529; color:white">
                    <div class="card-header">
                        Menus
                    </div>
                    <ul class="list-group list-group-flush">
                        <?php

                        $sql = "SELECT * FROM menus WHERE id='$_SESSION[bd_id]'";
                        $result = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<a href='show_menu.php?menu_id=" . $row["id"] . "' class='list-group-item list-group-item btn'>" . $row["name"] . "</a>";
                        }
                        ?>
                    </ul>
                </div>
            </div>
            <div class="col-4" style="width: auto;">
                <div class="card" style="width: auto;  background-color:#212529; color:white">
                    <div class="card-header">
                        Templates
                    </div>
                    <ul class="list-group list-group-flush">
                        <?php
                        $sql = "SELECT template_id, name FROM templates, bought_templates WHERE templates.id = bought_templates.template_id AND bought_templates.restaurant_id='$_SESSION[bd_id]'";
                        $result = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<a href='/menu/add_menu.php?template_id=" . $row["template_id"] . "' class=' list-group-item-dark list-group-item btn'>" . $row["name"] . "</a>";
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</body>

</html>