<?php
session_start();
include('connection.php');

// określenie user_id
$user_id = $_SESSION['user_id'];

// określenie czasu
$time = time();

// zapisanie notatek w BD
$sql = "INSERT INTO notes (user_id, note, time) VALUE ('$user_id', '', '$time')";

try{
    $result = mysqli_query($link, $sql);
    echo mysqli_insert_id($link);

} catch(Exception $e){
    echo 'error';
}

?>