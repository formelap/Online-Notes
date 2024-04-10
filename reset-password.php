<?php

session_start();
include('connection.php');

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Zmiana hasła</title>
        <script src="js/jquery-3.7.1.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        
        <style>
            h1{
                color:purple;   
            }
            .contactForm{
                margin: 20px;
                border:1px solid #7c73f6;
                /* margin-top: 50px; */
                border-radius: 15px;
            }
        </style> 

    </head>
        <body>
<div class="container-fluid">
    <div class="row">
        <div class="offset-sm-1 col-sm-10 contactForm">
            <h1>Zmiana hasła</h1>
            <div id = "resultMessage"></div>

<?php

//wyświetl błąd jeśli brakuje klucza aktywacyjnego
if(!isset($_GET['user_id']) || !isset($_GET['key'])){
    echo '<div class="alert alert-danger">Przepraszamy. Coś poszło nie tak...</div>';
    exit;
}

// zapytanie sql
$user_id = intval($_GET['user_id']);
$key = $_GET['key'];
$time = time() - 24*60*60;  // link będzie ważny przez 24h

$user_id = mysqli_real_escape_string($link, $user_id);
$key = mysqli_real_escape_string($link, $key);

$sql = "SELECT user_id FROM forgotpassword WHERE `key`='$key' AND `user_id`='$user_id' AND `time`>'$time' AND `status`='pending'";
try{
    $result = mysqli_query($link, $sql);
} catch(Exception $e){
    echo '<div class="alert alert-danger">Błąd połączenia z bazą danych</div>';
    exit;
}

if(mysqli_affected_rows($link) !== 1){
    echo '<div class="alert alert-danger">Hasło nie może zostać zresetowane. Proszę spróbować ponownie.</div>';
    exit;
}

 // formularz resetowania hasła
echo "
    <form method='post' id='passwordResetForm'>
        <input type='hidden' name='key' value='$key'/>
        <input type='hidden' name='user_id' value='$user_id'/>
        <div class='form-group'>
            <label for='password'>Wpisz nowe hasło:</label>
            <input type='password' name='password' id='password' placeholder='Nowe hasło' class='form-control mb-3'/>
            <label for='password2'>Potwierdź nowe hasło:</label>
            <input type='password' name='password2' id='password2' placeholder='Potwierdź hasło' class='form-control mb-3'/>
        </div>
        <input type='submit' name='reset-password' class='btn btn-success btn-lg mb-3' value='Zmień hasło'/>
    </form>


"

?>

        </div>
    </div>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
        // skrypt Ajax do procesowania formularza zmiany hasła
        $("#passwordResetForm").submit(function(event){
            event.preventDefault();
            var datatopost = $(this).serializeArray();

            $.ajax({
                url: "store-reset-password.php",
                type: "POST",
                data: datatopost,
                success: function(data){
                    $('#resultMessage').html(data);
                    
                },
                error: function(){
                    $("#resultMessage").html("<div class='alert alert-danger'>Błąd przetwarzania zapytania. Proszę spróbować ponownie.</div>");
                }
            });


        });

    </script>
    </body>
</html>