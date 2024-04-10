<?php
session_start();
include('connection.php');

// określenie user_id
$user_id = $_SESSION['user_id'];

// usuwanie pustych notatek
$sql = "DELETE FROM notes WHERE note=''";

try{
    $result = mysqli_query($link, $sql);

} catch(Exception $e){
    echo'<div class="alert alert-warning">Błąd zapytania bazy danych.</div>';
    exit;
}

// wyszukiwanie notatki użytkownika
$sql = "SELECT * FROM notes WHERE user_id='$user_id' ORDER BY time DESC";

// wyświetlenie notatkek
if($result = mysqli_query($link, $sql)){
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
            
            $note_id = $row['id'];
            $note = $row['note'];
            $time = $row['time'];
            setlocale(LC_TIME, 'pl_PL');
            $time = strftime("%d/%m/%Y, %H:%M:%S", $time);

            echo "<div class='note row'>
                <div class='col-4 delete '>
                    <button class='btn btn-lg btn-danger' style='width:100%'>Usuń</button>
                </div>
                <div class='note-header' id='$note_id'>
                    <div class='note-text'>$note</div>
                    <div class='note-time'>$time</div>
                </div>
            </div>";
        }
    } else {
        echo'<div class="alert alert-warning">Brak notatek do wyświetlenia.</div>';
        exit;
    }


} else {
    echo'<div class="alert alert-warning">Błąd zapytania.</div>';
    exit;
}

?>