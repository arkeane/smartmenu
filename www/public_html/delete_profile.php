<!DOCTYPE html>
<html lang=en>

<head>
    <title>Change Password</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- style.css -->
    <link rel="stylesheet" href="css/style.css">

    <!-- Bootstrap core JavaScript -->
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</head>

<body class="sitewide">
    <?php
    session_start();
    include 'db_config.php';

    if (!isset($_SESSION["email"])) {
        header("Location: login_page.php?error=notloggedin");
    }

    if (isset($_POST['submit'])) {
        $email = $_SESSION["email"];
        $sql = mysqli_prepare($conn, "DELETE FROM users WHERE email=? and id=?");
        mysqli_stmt_bind_param($sql, "si", $email, $_SESSION['db_id']);
        mysqli_stmt_execute($sql);
        if (mysqli_stmt_errno($sql) != 0) {
            echo "Error deleting data: " . mysqli_stmt_error($sql);
            exit;
        }
        session_destroy();
        header("Location: index.php");
    }

    ?>
    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-dark text-white" style="border-radius: 1rem;">
                        <div class="card-body p-4 text-center">
                            <div class="mb-md-1 mt-md-1 pb-1">
                                <img src="img/default.svg" alt="logo" width="100" class="mb-1">
                                <h2 class="fw-bold mb-1 text-uppercase">Delete Profile</h2>
                                <p class="text-white-50 mb-3">Permanently delete your profile?</p>
                                <form action="" method="post">
                                    <button class="btn btn-lg px-5 btn-danger" type="submit" name="submit" value="submit">Delete</button>
                                    <a class="btn btn-outline-light btn-lg px-5" href="show_profile.php">Cancel</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</body>

</html>