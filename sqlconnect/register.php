<?php

$con = mysqli_connect("localhost", "root", "root", "unityaccess");

if (mysqli_connect_errno()) {
    die("1: Connection Failed");
}

$username = $_POST["username"];
$password = $_POST["password"];

// Optimze: Use COUNT instead of select and num_rows check.

$logininfoquery = $con->prepare("SELECT username FROM players WHERE username = ?");
$logininfoquery->bind_param("s", $username);
$logininfoquery->execute() or die("2: Username check execute failed");

$result = $logininfoquery->get_result() or die("3: Name check get results failed");
if ($result->num_rows > 0) {
    die("4: Username already exists");
}

$salt = "\$5\$rounds=5000\$" . "steamedhams" . $username . "\$";
$hash = crypt($password, $salt);

$insertuserquery = $con->prepare("INSERT INTO players (username, hash, salt) VALUES (?, ?, ?)");
$insertuserquery->bind_param("sss", $username, $hash, $salt);
$insertuserquery->execute() or die("5: Username insert execute failed");

echo ("0");

?>