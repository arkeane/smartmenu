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

<body>
    <?php
    session_start();
    include 'db_config.php';

    if (!isset($_SESSION["email"])) {
        header("Location: login_page.php");
    }

    if (isset($_POST['submit'])) {
        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
        $email = $_POST["email"];

        // filter email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "Invalid email";
            exit;
        }

        $firstname = mysqli_real_escape_string($conn, $firstname);
        $lastname = mysqli_real_escape_string($conn, $lastname);
        $email = mysqli_real_escape_string($conn, $email);

        if ($firstname != $_SESSION["firstname"]) {
            $sql = "UPDATE users SET firstname='$firstname' WHERE email='$_SESSION[email]'";
            mysqli_query($conn, $sql);
        }

        if ($lastname != $_SESSION["lastname"]) {
            $sql = "UPDATE users SET lastname='$lastname' WHERE email='$_SESSION[email]'";
            mysqli_query($conn, $sql);
        }

        if ($email != $_SESSION["email"]) {
            $sql = "UPDATE users SET email='$email' WHERE email='$_SESSION[email]'";
            mysqli_query($conn, $sql);
        }

        unset($_SESSION["firstname"]);
        unset($_SESSION["lastname"]);
        $_SESSION["email"] = $email;
        header("Location: show_profile.php");
    }
    ?>
    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-dark text-white" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">
                            <div class="mb-md-5 mt-md-4 pb-5">
                                <img src="./img/pizza.svg" alt="logo" width="100" class="mb-4">
                                <h2 class="fw-bold mb-2 text-uppercase">Update Profile</h2>
                                <p class="text-white-50 mb-5">Change Informations</p>
                                <form action="" method="post">
                                    <div class="form-outline form-white mb-4">
                                        <input type="text" name="firstname" id="typeFirstNameX" class="form-control form-control-lg" required value="<?php echo $_SESSION["firstname"] ?>" />
                                    </div>

                                    <div class="form-outline form-white mb-4">
                                        <input type="text" name="lastname" id="typeLastNameX" class="form-control form-control-lg" required value="<?php echo $_SESSION["lastname"] ?>" />
                                    </div>

                                    <div class="form-outline form-white mb-4">
                                        <input type="email" name="email" id="typeEmailX" class="form-control form-control-lg" required value="<?php echo $_SESSION["email"] ?>" />
                                    </div>

                                    <button class="btn btn-outline-light btn-lg px-5" type="submit" name="submit" value="submit">Update Profile</button>
                                    <button class="btn btn-outline-light btn-lg px-5" href="show_profile.php" name="submit" value="submit">Cancel</button>
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