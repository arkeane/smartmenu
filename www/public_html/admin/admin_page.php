<!DOCTYPE html>
<html lang=en>

<head>
    <title>Admin Profile</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- style.css -->
    <link rel="stylesheet" href="../css/style.css">

    <!-- Bootstrap core JavaScript -->
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</head>

<body class="sitewide">
    <?php
    session_start();
    include '../db_config.php';

    if (!isset($_SESSION["email"]) && !isset($_SESSION["admin"]) && $_SESSION["admin"] != true) {
        header("Location: ../login_page.php?error=notloggedin");
    }
    ?>
    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-dark text-white" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">
                            <div class="mb-md-5 mt-md-4 pb-5">
                                <img src="../img/default.svg" alt="logo" width="100" class="mb-4">
                                <h2 class="fw-bold mb-2 text-uppercase">Admin Area </h2>
                                <?php
                                if (isset($_GET['success'])) {
                                    if ($_GET['success'] == "addedadmin") {
                                        echo '<p class="text-success">Admin correctly created</p>';
                                    } elseif ($_GET['success'] == "addedpost") {
                                        echo '<p class="text-success">Post correctly created</p>';
                                    } elseif ($_GET['success'] == "addednewsletter") {
                                        echo '<p class="text-success">Newsletter correctly sent</p>';
                                    }
                                }
                                ?>
                                <p class="text-white-50 mb-5">Choose activity</p>
                                <div class="list-group">
                                    <a class="btn btn-outline-light btn-lg px-5" href="../newsletter/send_newsletter.php">newsletter</a>
                                    <a class="btn btn-outline-light btn-lg px-5 mt-3" href="../blog/edit_post.php">create blog post</a>
                                    <a class="btn btn-outline-light btn-lg px-5 mt-3" href="add_admin.php">add admin user</a>
                                    <a class="btn btn-outline-light btn-lg px-5 mt-3" href="../#">LULLU</a>
                                    <a class="btn btn-danger btn-lg px-5 mt-3" href="../logout.php">Logout</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</body>

</html>