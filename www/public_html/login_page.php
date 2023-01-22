<!DOCTYPE html>
<html lang=en>

<head>
    <title>Login</title>

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

    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-dark text-white" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">
                            <div class="mb-md-5 mt-md-4 pb-5">
                                <img src="img/default.svg" alt="logo" width="100" class="mb-4">
                                <h1 class="fw-bold mb-2 text-uppercase">Login</h1>
                                <?php
                                if (isset($_GET["error"])) {
                                    if ($_GET["error"] == "wrongpassword") {
                                        echo "<p class='text-danger'>Wrong password!</p>";
                                    } elseif ($_GET["error"] == "notloggedin") {
                                        echo "<p class='text-danger'>You are not logged in</p>";
                                    }
                                }
                                if (isset($_GET["user"])) {
                                    if ($_GET["user"] == "notfound") {
                                        echo '<p class="text-danger">Wrong Email</p>
                                        <a class="btn btn-outline-light btn-lg px-5" href="registration_page.php">Register</a>';
                                    }
                                }
                                ?>
                                <p class="text-white-50 mb-5">Please enter your login and password!</p>
                                <form action="login.php" method="post">
                                    <div class="form-outline form-white mb-4">
                                        <input type="email" name="email" id="typeEmailX" class="form-control form-control-lg" required placeholder="Email" aria-label="Email"/>
                                    </div>
                                    <div class="form-outline form-white mb-4">
                                        <input type="password" name="pass" id="typePasswordX" class="form-control form-control-lg" required placeholder="Password" aria-label="Password"/>
                                    </div>
                                    <button class="btn btn-outline-light btn-lg px-5" type="submit" name="submit" value="submit">Login</button>
                                    <a class="btn btn-outline-light btn-lg px-5" href="index.php">Cancel</a>
                                </form>
                            </div>
                            <div>
                                <p class="mb-0">Don't have an account? <a href="registration_page.php" class="text-white-50 fw-bold">Register</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</body>

</html>