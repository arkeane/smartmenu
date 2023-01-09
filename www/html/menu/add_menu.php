<!DOCTYPE html>

<head>
    <title>Create Menu</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- style.css -->
    <link rel="stylesheet" href="../css/style.css">

    <!-- Bootstrap core JavaScript -->
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <script defer src="./js/main.js"></script>
</head>

<?php
session_start();

include '../db_config.php';

if (!isset($_SESSION["email"])) {
    header("Location: login_page.php");
}

if (!isset($_GET["template_id"])) {
    $template = 1;
} else if (!is_numeric($_GET["template_id"])) {
    $template = 1;
} else {
    $template = $_GET["template_id"];
}

// check if template is bought from user
$sql = "SELECT * FROM bought_templates WHERE template_id='$template' AND restaurant_id='{$_SESSION['db_id']}'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) == 0) {
    $template = 1;
}

$sql = "SELECT name FROM templates WHERE id = $template";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
if ($row == NULL) {
    $template_name = "Template not found, using default";
    $template = 1;
} else
    $template_name = $row["name"];

?>

<body>
    <header class="header">
        <nav class="navbar navbar-dark bg-dark navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <img class="mx-3" src="../img/pizza.svg" alt="logo" width="30" height="30">
                <a class="navbar-brand" href="../index.php">SmartMenu</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="../show_profile.php">Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="../logout.php">Logout</a>
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

    <div class="container-flex mt-4 mx-4">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-dark text-white" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">
                            <div class="mb-md-5 mt-md-4 pb-5">
                                <?php
                                if (isset($_GET["error"])) {
                                    if($_GET["error"] == "menu_name_exists"){
                                        echo '<p class="text-danger">Menu Already Exists</p>';
                                    }
                                }
                                ?>
                                <h2 class="fw-bold mb-2 text-uppercase">
                                    <?php
                                    echo 'Create Menu Using template: ' . $template_name . '';
                                    ?>
                                </h2>
                                <form action="create_menu.php" method="post">
                                    <div class="form-outline form-white mb-4">
                                        <input type="text" name="menu_name" id="menu_name" class="form-control form-control-lg" required placeholder="Menu Name" />
                                    </div>
                                    <?php $_SESSION["template_id"] = $template; ?>
                                    <button class="btn btn-outline-light btn-lg px-5" type="submit" name="submit" value="submit">Create</button>
                                    <a class="btn btn-outline-light btn-lg px-5" href="../show_profile.php">Cancel</a>
                                </form>
                            </div>
                        </div>
                    </div>
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