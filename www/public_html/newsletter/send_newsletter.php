<!DOCTYPE html>
<html lang=en>

<head>
    <title>Send Newsletter</title>

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

include '../db_config.php';

if (!isset($_SESSION["email"])) {
    header("Location: ../login_page.php?error=notloggedin");
}

if (!isset($_SESSION["admin"])) {
    header("Location: ../login_page.php");
}
?>

<body class="sitewide">
    <section class="vh-100 gradient-custom">
        <div class="container-flex mt-4 mx-4">
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                        <div class="card bg-dark text-white" style="border-radius: 1rem;">
                            <div class="card-body p-5 text-center">
                                <div class="mb-md-5 mt-md-4 pb-5">
                                    <img src="../img/default.svg" alt="logo" width="100" class="mb-1">
                                    <?php
                                    if (isset($_GET["error"])) {
                                        if ($_GET["error"] == "emptyfields") {
                                            echo '<p class="text-danger">Empty Fields</p>';
                                        }
                                    }
                                    ?>
                                    <h2 class="fw-bold mb-2 text-uppercase">
                                        Send Newsletter
                                    </h2>
                                    <form action="newsletter.php" method="post">
                                        <div class="form-outline form-white mb-4">
                                            <input type="text" name="subject" id="subject" class="form-control form-control-lg" required placeholder="Subject" />
                                        </div>
                                        <div class="form-outline form-white mb-4">
                                            <textarea id="content" name="content" class="form-control form-control-lg" required placeholder=" Content"></textarea>
                                        </div>
                                        <button class="btn btn-outline-light btn-lg px-5" type="submit" name="submit" value="submit">Send</button>
                                        <a class="btn btn-outline-light btn-lg px-5" href="../logout.php">Exit</a>
                                    </form>
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