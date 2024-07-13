<?php
$hostname = "127.0.0.1";
$database = "projectDB";
$username = "root";
$password = "";

$stateConvert = array(
    "C" => "Create",
    "A" => "Accepted",
    "R" => "Rejected",
    "T" => "In Transmit",
    "U" => "Unavailable",
    "F" => "Finished"
);

$conn = mysqli_connect(
    $hostname,
    $username,
    $password,
    $database
)
    or die(mysqli_connect_error());
