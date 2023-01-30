<!DOCTYPE html>
<html lang=en>

<head>
    <title>Edit Menu</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- style.css -->
    <link rel="stylesheet" href="../css/style.css">

    <!-- Bootstrap core JavaScript -->
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</head>

<?php
session_start();

if (!isset($_SESSION["email"])) {
    header("Location: ../login_page.php?error=notloggedin");
}

if (!isset($_SESSION["admin"])) {
    header("Location: ../login_page.php");
}
include '../db_config.php';
?>

<body class="sitewide">
    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col">
                    <div class="card bg-dark text-white" style="border-radius: 1rem;">
                        <h1 class="text-center text-light mt-5">CrowdFunding</h1>
                        <div class="card-body p-4 text-center">
                            <form action="crowdfunding.php" method="post">
                                <div class="form-outline form-white mb-4">
                                    <input type="text" name="title" id="title" class="form-control form-control-lg" required placeholder="Title" aria-label="Title" />
                                </div>
                                <div class="form-outline form-white mb-4">
                                    <input type="text" name="description" id="description" class="form-control form-control-lg" required placeholder="Description" aria-label="Description" />
                                </div>

                                <div class="form-outline form-white mb-4">
                                    <input type="number" name="goal" id="goal" class="form-control form-control-lg" required placeholder="Goal$" aria-label="Goal$" />
                                </div>
                                <div class="form-outline form-white mb-4">
                                    <input type="date" name="end_date" id="end_date" class="form-control form-control-lg" required placeholder="End date" aria-label="End date" />
                                </div>
                                <button class="btn btn-outline-light btn-lg px-5" type="submit" name="submit" value="submit">Create CF</button>
                                <a class="btn btn-outline-light btn-lg px-5" href="../admin/admin_page.php">Cancel</a>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</body>

</html>