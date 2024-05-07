<?php
session_start();
if (isset($_SESSION["user"])) {
    header("Location: index.php");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="test.css">
    <script>
        function validateForm() {
            var x = document.forms["myform"]["fullname"].value;
            var y = document.forms["myform"]["password"].value;
            var w = document.forms["myform"]["repeat_password"].value;
            var z = document.forms["myform"]["email"].value;

            if (x == null || x == "") {
                alert("Name must be filled out");
                return false;
            }
            if (y == null || y == "") {
                alert("Password must be filled out");
                return false;
            }
            if (w == null || w == "") {
                alert("Repeat passowrd must be filled out");
                return false;
            }
            if (y.length < 8) {
                alert("Password must be at least 8 charactes long.");

                return false;
            }
            if (y !== w) {
                alert("Password does not match.");
                return false;
            }

            var validRegex =
                /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
            if (z.search(validRegex) == -1) {
                alert("Please enter a valid email address.");
                return false;
            }

            return true;
        }
    </script>
</head>

<body>

    <div class="container">
        <?php
        if (isset($_POST["submit"])) {

            $fullName = $_POST["fullname"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            $passwordRepeat = $_POST["repeat_password"];
            $passwordHash = md5($password);
            $errors = array();
            require_once "database.php";
            $sql = "SELECT * FROM user WHERE email = '$email'";
            $result = mysqli_query($conn, $sql);
            $rowCount = mysqli_num_rows($result);
            if ($rowCount > 0) {
                array_push($errors, "Email already exists!");
            }
            if (count($errors) > 0) {
                foreach ($errors as  $error) {
                    echo "<div class='alert alert-danger'>$error</div>";
                }
            } else {

                $sql = "INSERT INTO user (name, email, password) VALUES ( ?, ?, ? )";
                $stmt = mysqli_stmt_init($conn);
                $prepareStmt = mysqli_stmt_prepare($stmt, $sql);
                if ($prepareStmt) {
                    mysqli_stmt_bind_param($stmt, "sss", $fullName, $email, $passwordHash);
                    mysqli_stmt_execute($stmt);
                    echo "<div class='alert alert-success'>You are registered successfully.</div>";
                    session_start();
                    $_SESSION["u"] = $user["name"];
                    $_SESSION["user"] = "yes";
                    header("Location: index.php");
                    die();
                } else {
                    die("Something went wrong");
                }
            }
        }
        ?>
        <div class="container">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <div class="form">
                <form onsubmit="return validateForm();" name="myform" action="registration.php" method="post" id="f1">
                    <div class="title">Welcome</div>
                    <div class="subtitle">Let's create your account!</div>
                    <div class="input-container ic1">
                        <div class="form-group">
                            <input class="input" type="text" class="form-control" name="fullname" placeholder="" id="fullname" />
                            <div class="cut"></div>
                            <label for="fullname" class="placeholder">Fullname</label>
                        </div>

                    </div>

                    <div class="input-container ic2">

                        <div class="form-group">
                            <input class="input" type="emamil" class="form-control" name="email" placeholder="" id="email" />
                            <div class="cut"></div>
                            <label for="email" class="placeholder">Email</label>
                        </div>
                    </div>
                    <div class="input-container ic2">
                        <div class="form-group">
                            <input class="input" type="password" class="form-control" name="password" placeholder="" id="Password" />
                            <div class="cut"></div>
                            <label for="Password" class="placeholder">Password</label>
                        </div>
                    </div>
                    <div class="input-container ic2">
                        <div class="form-group">
                            <input class="input" type="password" class="form-control" name="repeat_password" placeholder="" id="Password-repeat" />
                            <div class="cut"></div>
                            <label for="Password-repeat" class="placeholder">Repeat password</label>
                        </div>
                    </div>
                    <a href="#" id="button">
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <div class="form-btn">
                            <input type="submit" class="submit" value="Register" name="submit" />
                        </div>
                    </a>
                    <div id="sub">
                        <br />
                        <p>Already Registered <a href="login.php"> Login Here</a></p>
                    </div>
            </div>
        </div>

        </form>
    </div>

    </div>

</body>

</html>