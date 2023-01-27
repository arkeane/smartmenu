<!DOCTYPE html>
<html lang=en>

<head>
    <title>Add New Admin</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- style.css -->
    <link rel="stylesheet" href="../css/style.css">

    <!-- Bootstrap core JavaScript -->
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>


    <script defer src="../js/password.js"></script>
</head>

<?php
session_start();

if (!isset($_SESSION["email"]) && !isset($_SESSION["admin"]) && $_SESSION["admin"] != true) {
    header("Location: ../login_page.php?error=notloggedin");
}
?>

<body class="sitewide">

    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-dark text-white" style="border-radius: 1rem;">
                        <div class="card-body p-4 text-center">
                            <div class="mb-md-1 mt-md-1 pb-1">
                                <img src="../img/default.svg" alt="logo" width="100" class="mb-1">
                                <h1 class="fw-bold mb-1 text-uppercase">Add New Admin</h1>
                                <?php
                                if (isset($_GET['error'])) {
                                    if ($_GET['error'] == "invalidpassword") {
                                        echo '<p class="text-danger">Password is not secure enough!</p>
                                            <p class="text-danger">Password must contain at least 8 characters, 1 uppercase letter, 1 lowercase letter, 1 number.</p>';
                                    } else if ($_GET['error'] == "passwordcheck") {
                                        echo '<p class="text-danger">Your passwords do not match!</p>';
                                    } else if ($_GET['error'] == "emailtaken") {
                                        echo '<p class="text-danger">This email is already taken!</p>';
                                    }
                                }
                                ?>
                                <p class="text-white-50 mb-3">Please Insert all the needed informations</p>
                                <form action="register_admin.php" method="post">

                                    <div class="form-outline form-white mb-4">
                                        <input type="email" name="email" id="typeEmailX" class="form-control form-control-lg" required placeholder="Email" aria-label="Email" />
                                    </div>

                                    <div class="form-outline form-white mb-4">
                                        <ul>
                                            <li id="charcheck">At least 8 characters</li>
                                            <li id="uppercheck">At least 1 uppercase letter</li>
                                            <li id="lowercheck">At least 1 lowercase letter</li>
                                            <li id="numcheck">At least 1 number</li>
                                        </ul>
                                        <input type="password" name="pass" id="typePasswordPass" class="form-control form-control-lg" required placeholder="Password" aria-label="Password" />
                                    </div>

                                    <div class="form-outline form-white mb-4">
                                        <input type="password" name="confirm" id="typePasswordConfirm" class="form-control form-control-lg" required placeholder="Confirm Password" aria-label="Confirm Password" />
                                    </div>

                                    <input type="checkbox" onclick="showPass()" aria-label="Show Password Checkbox">Show Password</input><br><br>

                                    <button class="btn btn-outline-light btn-lg px-5" type="submit" name="submit" value="submit">Register</button>
                                    <a class="btn btn-outline-light btn-lg px-5" href="admin_page.php">Cancel</a>
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