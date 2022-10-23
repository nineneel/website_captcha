<?php
$server = "localhost";
$username = "sujarniel";
$password = "sG1PVFUKpjxa[AOh";
$database = "kat1_captcha";

$conn = mysqli_connect($server, $username, $password, $database);

if ($conn->connect_errno) {
    echo "Failed to connect to MySQL: " . $conn->connect_error;
    exit();
}
