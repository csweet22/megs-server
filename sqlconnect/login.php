<?php

$con = mysqli_connect("localhost", "root", "root", "unityaccess");

if (mysqli_connect_errno()) {
    die("1: Connection Failed");
}

$username = $_POST["username"];
$password = $_POST["password"];


$logininfoquery = $con->prepare("SELECT username, salt, hash, score FROM players WHERE username = ?");
$logininfoquery->bind_param("s", $username);
$logininfoquery->execute() or die("2: Username check execute failed");

$result = $logininfoquery->get_result() or die("3: Username check get results failed");
if ($result->num_rows != 1) {
    die("6: Either no user with username, or more than one");
}

$existinginfo = $result->fetch_assoc();

$salt = $existinginfo["salt"];
$hash = $existinginfo["hash"];

$loginhash = crypt($password, $salt);

if ($hash != $loginhash) {
    die("7: Incorrect password");
}

echo "0\t" . $existinginfo["score"];

?>