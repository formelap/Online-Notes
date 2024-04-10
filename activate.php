<?php
// rozpoczęcie sesji
session_start();
include('connection.php');

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Account Activation</title>
        <script src="js/jquery-3.7.1.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        
        <style>
            h1{
                color:purple;   
            }
            .contactForm{
                border:1px solid #7c73f6;
                margin-top: 50px;
                border-radius: 15px;
            }
        </style> 

    </head>
        <body>
<div class="container-fluid">
    <div class="row">
        <div class="offset-sm-1 col-sm-10 contactForm">
            <h1>Aktywacja Konta</h1>



<?php

//wyświetl błąd jeśli brakuje klucza aktywacyjnego
if(!isset($_GET['email']) || !isset($_GET['key'])){
    echo '<div class="alert alert-danger">Przepraszamy. Coś poszło nie tak...</div>';
    exit;

}

// zapytanie sql
$email = $_GET['email'];
$key = $_GET['key'];
$email = mysqli_real_escape_string($link, $email);
$key = mysqli_real_escape_string($link, $key);

$sql = "UPDATE users SET activation='activated' WHERE (email='$email' AND activation='$key') LIMIT 1";
$result = mysqli_query($link, $sql);

if(mysqli_affected_rows($link) == 1){
    echo '<div class="alert alert-success">Konto zostało aktywowane</div>';
    echo '<a href="index.php" type="button" class="btn btn-lg btn-success">Zaloguj</a>';
} else {
    echo '<div class="alert alert-danger">Konto nie może zostać aktywowane. Proszę spróbować ponownie.</div>';
}

?>

</div>
    </div>
</div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        </body>
</html>