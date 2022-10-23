<?php
require('connection.php');

session_start();

function captchaConfiguration()
{
    $secret = "6Let2qAiAAAAAJfq4fpPvyOKpR5nIWo0i2Vdtje8";
    $response = $_POST["g-recaptcha-response"];
    $remoteip = $_SERVER["REMOTE_ADDR"];
    $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$response&remoteip=$remoteip";
    $data = file_get_contents($url);
    $row = json_decode($data, true);

    return $row['success'];
}

$error = false;
$captcha = true;
if (isset($_POST['login'])) {
    $captcha = captchaConfiguration();

    $email = $_POST['email'];
    $password = $_POST['password'];


    // cek username ada atau tidak
    $result = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
    if (mysqli_num_rows($result) === 1 && $captcha) {
        // lakukan decript
        $row = mysqli_fetch_assoc($result);
        $decripsi = password_verify($password, $row['password']);
        $name = $row['name'];
        $role = $row['role'];
        if ($decripsi) {
            // set session
            $_SESSION['login'] = true;
            $_SESSION['user_name'] = $name;
            $_SESSION['user_role'] = $role;
            if ($role == "admin") {
                header("Location: admin.php");
            } else {
                header("Location: index.php");
            }
            exit;
        }
    }
    $error = true;
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>website captcha - login</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="css/signin.css">
</head>

<body>
    <main class="form-signin w-100 m-auto">
        <form class="text-center" method="POST" action="">
            <!-- Error message -->
            <?php if (!$captcha) { ?>
                <!-- Captcha Error message -->
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Captcha Verification Invalid
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php } else if ($error) { ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Wrong Email or Password!!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php } ?>

            <!-- Form Title -->
            <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

            <!-- Email -->
            <div class="form-floating">
                <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" />
                <label for="email">Email address</label>
            </div>

            <!-- Password -->
            <div class="form-floating">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" />
                <label for="password">Password</label>
            </div>

            <!-- Google reCAPTCHA -->
            <div class="form-floating mt-4">
                <div class="g-recaptcha" data-sitekey="6Let2qAiAAAAAKkGPl-A94gIIw7yZ-AkzTNN0THg"></div>
            </div>

            <!-- Button -->
            <button class="w-100 btn btn-lg btn-primary mt-4" type="submit" name="login" value="false">
                Login
            </button>

            <!-- Registration Link -->
            <p class="mt-3 mb-3 text-muted">Not Registered Yet? <a href="register.php">register now!</a></p>
        </form>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>