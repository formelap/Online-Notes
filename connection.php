<?php
$env = parse_ini_file('.env');
$hostname = $env["DB_HOSTNAME"];
$username = $env["DB_USERNAME"];
$password = $env["DB_PASSWORD"];
$database = $env["DB_NAME"];

$link = mysqli_connect($hostname, $username, $password, $database);

if(mysqli_connect_error()){
    die("ERROR. Unable to connect to DB: " . mysqli_connect_error());
    echo "<script>window.alert('Database connection error!')</script>";
}

?>