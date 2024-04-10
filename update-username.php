<?php

// rozpocznij sesję
session_start();
include('connection.php');

// określ user_id użytkownika
$id = $_SESSION['user_id'];

// określ username (z zapytania Ajax)
$username = $_POST['updateUsername'];

// wyślij zapytanie do bazy danych i zaktualizuj username
$sql = "UPDATE users SET `username`='$username' WHERE `user_id`='$id'";

try{
    $result = mysqli_query($link, $sql);
} catch(Exception $e) {
    echo '<div class="alert alert-danger">Nie udało się zmienić nazwy użytkowanika.</div>';
    exit;
}


?>