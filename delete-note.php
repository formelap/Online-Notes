<?php
session_start();
include('connection.php');

// określenie id notatki
$note_id = $_POST['id'];

// usuń notatkę z BD
$sql = "DELETE FROM notes WHERE id = '$note_id'";

try{
    $result = mysqli_query($link, $sql);
} catch(Exception $e) {
    echo 'error';
}



?>