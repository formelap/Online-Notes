<?php
session_start();
include('connection.php');

// określenie id notatki
$id = $_POST['id'];

// zawartość notatki
$note = $_POST['note'];

// czas
$time = time();

// aktualizacja notatki w BD
$sql = "UPDATE notes SET note='$note', time='$time' WHERE id='$id'";

try{
    $result = mysqli_query($link, $sql);
} catch(Exception $e){
    echo 'error';
}

?>