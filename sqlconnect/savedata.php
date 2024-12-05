<?php

$con = mysqli_connect("localhost", "root", "root", "unityaccess");

if (mysqli_connect_errno()) {
    die("1: Connection Failed");
}

$username = $_POST["username"];
$score = $_POST["score"];

$logininfoquery = $con->prepare("SELECT username FROM players WHERE username = ?");
$logininfoquery->bind_param("s", $username);
$logininfoquery->execute() or die("2: Username check execute failed");

$result = $logininfoquery->get_result() or die("3: Username check get results failed");
if ($result->num_rows != 1) {
    die("6: Either no user with username, or more than one");
}

$updatescorequery = $con->prepare("UPDATE players SET score = ? WHERE username = ?");
$updatescorequery->bind_param("is", $score, $username);
$updatescorequery->execute() or die("2: Update score execute failed");


echo ("0");

?>