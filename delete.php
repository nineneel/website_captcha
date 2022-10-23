<?php
require("connection.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "DELETE FROM users WHERE user_id = $id";
    mysqli_query($conn, $query);

    header("Location: admin.php");
}
