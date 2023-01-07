<!DOCTYPE html>

<head>
    <title>Profile</title>

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- style.css -->
    <link rel="stylesheet" href="./css/style.css">

    <!-- Bootstrap core JavaScript -->
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <script defer src="./js/main.js"></script>
</head>

<body>
    <?php
    session_start();

    if (!isset($_SESSION["email"])) {
        header("Location: error.html");
    }
    ?>

    <div class="container">
        <div class="row">
            <div class="col-4" style="width: auto;">
                <div class="card mb-3" style="width: auto;">
                    <div class="card-body">
                        <?php
                        include 'db.php';

                        $conn = new mysqli($servername, $username, $db_password, $dbname);
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        $sql = "SELECT * FROM users WHERE email='$_SESSION[email]'";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);

                        $email_hash = md5($row["email"]);
                        $img = 'https://www.gravatar.com/avatar/' . $email_hash . '?d=retro&f=y';

                        echo "<h5 class='card-title'>My Profile</h5>";
                        echo "<img src=" . $img . "class='rounded-circle' alt='...'>";
                        echo "<p class='card-text'>Email: " . $row["email"] . "</p>";
                        echo "<p class='card-text'>First Name: " . $row["firstname"] . "</p>";
                        echo "<p class='card-text'>Last Name: " . $row["lastname"] . "</p>";

                        $_SESSION["firstname"] = $row["firstname"];
                        $_SESSION["lastname"] = $row["lastname"];

                        ?>
                        <a href="update_profile.php" class="btn btn-primary">Edit Profile</a>
                        <a href="logout.php" class="btn btn-primary">Logout</a>
                    </div>
                </div>
            </div>
            <div class="col-4" style="width: auto;">
                <div class="card" style="width: auto;">
                    <div class="card-header">
                        Menus
                    </div>
                    <ul class="list-group list-group-flush">
                        <?php

                        $sql = "SELECT * FROM menus WHERE id='$_SESSION[bd_id]'";
                        $result = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<a href='show_menu.php?menu_id=" . $row["id"] . "' class='list-group-item list-group-item-action'>" . $row["name"] . "</a>";
                        }
                        ?>
                    </ul>
                </div>
            </div>
            <div class="col-4" style="width: auto;">
                <div class="card" style="width: auto;">
                    <div class="card-header">
                        Templates
                    </div>
                    <ul class="list-group list-group-flush">
                    <?php
                        $sql = "SELECT template_id, name FROM templates, bought_templates WHERE templates.id = bought_templates.template_id AND bought_templates.restaurant_id='$_SESSION[bd_id]'";
                        $result = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<a href='add_menu.php?template_id=" . $row["template_id"] . "' class='list-group-item list-group-item-action'>" . $row["name"] . "</a>";
                        }
                        ?>
                    </ul>
                    <a href="market.php" class="btn btn-primary">Buy Templates</a>
                </div>
            </div>
        </div>
    </div>

</body>

</html>