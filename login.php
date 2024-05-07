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
    <title>Login Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="test3.css">
</head>

<body>
    <div class="continer">
        <?php
        if (isset($_POST["login"])) {
            $email = $_POST["email"];
            $password = $_POST["password"];
            require_once "database.php";
            $sql = "SELECT * FROM user WHERE email = '$email'";
            $result = mysqli_query($conn, $sql);
            $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
            if ($user) {
                // if (password_verify($password, $user["password"]))
                if (md5($password) === $user["password"]) {
                    $nam = $user["name"];
                    session_start();
                    $_SESSION["u"] = $user["name"];
                    $_SESSION["user"] = "yes";
                    echo "<script> window.localStorage.setItem('name',$nam) </script>";
                    header("Location: index.php");
                    die();
                } else {
                    echo "<div class='alert alert-danger'>Password does not match</div>";
                }
            } else {
                echo "<div class='alert alert-danger'>Email does not match</div>";
            }
        }
        ?>
        <div class="container">
            <form action="login.php" method="post">
                <div class="brand-logo">L</div>
                <div class="brand-title">LOGIN</div>
                <div class="inputs">
                    <label>EMAIL</label>
                    <div class="form-group">
                        <input type="email" placeholder="example@test.com" name="email">
                    </div>
                    <label>PASSWORD</label>
                    <div class="form-group">
                        <input type="password" placeholder="Min 8 charaters long" name="password">
                    </div>
                    <!-- <button type="submit">LOGIN</button> -->
                    <div class="form-btn">
                        <input id="b" type="submit" value="LOGIN" name="login">
                    </div>
                </div>
                <div id="sub">
                    <p>Not registered yet <a href="registration.php">Register Here</a></p>
                </div>
            </form>
        </div>

    </div>
</body>

</html>