<?php

date_default_timezone_set('Asia/Kolkata');


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "societyManagement";


$conn = mysqli_connect($servername, $username, $password, $dbname);


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
