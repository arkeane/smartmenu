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


    <script defer src="js/password.js"></script>


</head>

<body class="sitewide">
    <?php
    session_start();
    include 'db_config.php';
    include 'password.php';

    if (!isset($_SESSION["email"])) {
        header("Location: login_page.php?error=notloggedin");
    }

    if (isset($_POST['submit'])) {
        $oldpass = $_POST["oldpass"];
        $pass = $_POST["pass"];
        $confirm = $_POST["confirm"];

        if (empty($oldpass) || empty($pass) || empty($confirm)) {
            echo "Please fill all the fields";
            exit;
        }

        if (isValidPassword($pass) == false) {
            header("Location: change_password.php?error=invalidpassword");
            exit;
        }

        if ($pass != $confirm) {
            header("Location: change_password.php?error=passwordcheck");
            exit;
        }

        $hash_pass = password_hash($pass, PASSWORD_DEFAULT);

        $sql = mysqli_prepare($conn , "SELECT password_hash FROM users WHERE id=?");
        mysqli_stmt_bind_param($sql, "i", $_SESSION["db_id"]);
        mysqli_stmt_execute($sql);
        $result = mysqli_stmt_get_result($sql);
        $row = mysqli_fetch_assoc($result);
        $old_hash = $row["password_hash"];

        if (password_verify($oldpass, $old_hash)) {
            $sql = mysqli_prepare($conn , "UPDATE users SET password_hash=? WHERE id=?");
            mysqli_stmt_bind_param($sql, "si", $hash_pass, $_SESSION["db_id"]);
            mysqli_stmt_execute($sql);
            if (mysqli_stmt_errno($sql)) {
                echo "Error: " . mysqli_stmt_error($sql);
                exit;
            }
        } else {
            header("Location: change_password.php?error=wrongpassword");
            exit;
        }


        header("Location: show_profile.php");
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
                                <h2 class="fw-bold mb-1 text-uppercase">Change Password</h2>
                                <?php
                                if (isset($_GET['error'])) {
                                    if ($_GET['error'] == "invalidpassword") {
                                        echo '<p class="text-danger">Password is not secure enough!</p>
                                            <p class="text-danger">Password must contain at least 8 characters, 1 uppercase letter, 1 lowercase letter, 1 number.</p>';
                                    } else if ($_GET['error'] == "passwordcheck") {
                                        echo '<p class="text-danger">Your passwords do not match!</p>';
                                    } else if ($_GET['error'] == "wrongpassword") {
                                        echo '<p class="text-danger">Your old password is wrong!</p>';
                                    }
                                }
                                ?>
                                <p class="text-white-50 mb-3">Insert Old Password and New Password</p>
                                <form action="" method="post">
                                    <div class="form-outline form-white mb-4">
                                        <input type="password" name="oldpass" id="typeOldPasswordPass" class="form-control form-control-lg" required placeholder="Old Password" />
                                    </div>

                                    <div class="form-outline form-white mb-4">
                                        <ul>
                                            <li id="charcheck">At least 8 characters</li>
                                            <li id="uppercheck">At least 1 uppercase letter</li>
                                            <li id="lowercheck">At least 1 lowercase letter</li>
                                            <li id="numcheck">At least 1 number</li>
                                        </ul>
                                        <input type="password" name="pass" id="typePasswordPass" class="form-control form-control-lg" required placeholder=" New Password" />
                                    </div>

                                    <div class="form-outline form-white mb-4">
                                        <input type="password" name="confirm" id="typePasswordConfirm" class="form-control form-control-lg" required placeholder="Confirm Password" />
                                    </div>

                                    <input type="checkbox" onclick="showPass()">Show Password</input><br><br>

                                    <button class="btn btn-outline-light btn-lg px-5" type="submit" name="submit" value="submit">Change Password</button>
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