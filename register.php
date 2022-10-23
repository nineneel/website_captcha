<?php
require("connection.php");
session_start();

// check validation function
function checkValidation($data)
{
    global $conn;

    $query = "SELECT * FROM users";
    $result = mysqli_query($conn, $query);

    $flag = true;
    // check name & email
    while ($user = mysqli_fetch_assoc($result)) {
        if ($user['name'] == $data['name'] || $user['email'] == $data['email']) {
            $flag = false;
            break;
        }
    }

    // check pass
    if ($flag) {
        if ($data["password"] != $data["confirmPass"]) {
            $flag = false;
        }
    }

    return $flag;
}

if (isset($_POST['submit'])) {
    $data = [
        "name" => $_POST['name'],
        "email" => $_POST['email'],
        "password" => $_POST['password'],
        "confirmPass" => $_POST['confirmPassword'],
        "role" => $_POST['role']
    ];

    // check validation
    if (checkValidation($data)) {
        $name = $data['name'];
        $email = $data['email'];
        $password = $data['password'];
        $role = $data['role'];

        $enkripsi = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO users VALUES ('', '$name', '$email', '$enkripsi', '$role')";
        mysqli_query($conn, $query);
        if (isset($_SESSION['error_register'])) {
            unset($_SESSION['error_register']);
        }

        $_SESSION['login'] = true;
        $_SESSION['user_name'] = $name;
        $_SESSION['user_role'] = $role;
        if ($role == "admin") {
            header("Location: admin.php");
        } else if ($role == "user") {
            header("Location: index.php");
        }
        exit();
    } else {
        $_SESSION['error_register'] = "Registration Invalid!";
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>website captcha - login</title>
    <link rel="stylesheet" href="css/register.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>

<body>
    <main class="form-signin w-100 m-auto">
        <form class="text-center" method="POST" action="">

            <!-- Error message -->
            <?php if (isset($_SESSION['error_register'])) { ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= $_SESSION['error_register'] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php } ?>

            <!-- Title -->
            <h1 class="h3 mb-3 fw-normal">Register Here!</h1>

            <!-- Input Name -->
            <div class="form-floating">
                <input type="text" class="form-control" id="name" name="name" placeholder="name" require />
                <label for="name">Name</label>
            </div>

            <!-- Input Email -->
            <div class="form-floating">
                <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" require />
                <label for="email">Email address</label>
            </div>

            <!-- Input Password -->
            <div class="form-floating">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" require />
                <label for="password">Password</label>
            </div>

            <!-- Input Confirm Password -->
            <div class="form-floating">
                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="confirmPassword" require />
                <label for="confirmPassword">Confirm Password</label>
            </div>

            <!-- Select Role -->
            <div class="mb-3">
                <label for="role" class="form-label">Select Role</label>
                <select id="role" class="form-select" name="role" require>
                    <option value="admin">admin</option>
                    <option value="user">user</option>
                </select>
            </div>

            <!-- Button Submit -->
            <button class="w-100 btn btn-lg btn-primary" type="submit" name="submit">
                Register
            </button>
            <p class="mt-3 mb-3 text-muted">Already have an account?
                <a href="login.php">Login</a>
            </p>
        </form>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>