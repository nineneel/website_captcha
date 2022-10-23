<?php
require('connection.php');

session_start();

if (!isset($_SESSION['login'])) {
    header('Location: login.php');
    exit;
}

$query = "SELECT * FROM users";
$result = mysqli_query($conn, $query);
$users = [];

while ($row = mysqli_fetch_assoc($result)) {
    $users[] = $row;
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>website captcha</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>

<body>
    <header>
        <div class="container">
            <nav class="navbar bg-light px-5">
                <div class="container-fluid">
                    <a class="navbar-brand flex-1"><span class="fw-bold"><?= $_SESSION['user_name'] ?></span> as, <span class="fw-bold"><?= $_SESSION['user_role'] ?></span></a>
                    <div class="d-flex flex-1">
                        <a class="btn btn-outline-danger" name="logout" href="logout.php">logout</a>
                    </div>
                </div>
            </nav>
        </div>
    </header>
    <main class="w-100">
        <div class="container">
            <h1 class="bg-danger text-light text-center py-3">User List</h1>
            <div class="row justify-content-center">
                <div class="col-sm-11">
                    <thead>
                        <table class="table">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Password</th>
                                <th scope="col">Role</th>
                            </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1 ?>
                        <?php foreach ($users as $user) { ?>
                            <?php if ($user['role'] == 'user') { ?>
                                <tr>
                                    <th scope="row"><?= $i++ ?></th>
                                    <td><?= $user['name'] ?></td>
                                    <td><?= $user['email'] ?></td>
                                    <td><?= $user['password'] ?></td>
                                    <td><?= $user['role'] ?></td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>