<?php
session_start();
include('connection.php');

//wyświetl błąd jeśli brakuje klucza aktywacyjnego
if(!isset($_POST['user_id']) || !isset($_POST['key'])){
    echo '<div class="alert alert-danger">Przepraszamy. Coś poszło nie tak...</div>';
    exit;
}

// zapytanie sql
$user_id = intval($_POST['user_id']);
$key = $_POST['key'];
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

// sprawdzenie wprowadzonych danych
$missingPassword='<p><strong>Proszę wprowadzić hasło!</strong></p>';
$invalidPassword='<p><strong>Twoje hasło powinno mieć co najmniej 6 znaków i zawierać jedną wielką literę oraz jedną cyfrę!</strong></p>';
$differentPassword='<p><strong>Podane hasła nie pasują do siebie!</strong></p>';
$missingPassword2='<p><strong>Proszę potwierdzić hasło!</strong></p>';
$errors = '';

if(empty($_POST["password"])){
    $errors .= $missingPassword;
} elseif(!(strlen($_POST["password"]) >= 6 and preg_match('/[A-Z]/',$_POST["password"]) and preg_match('/[0-9]/',$_POST["password"]))) {
    $errors .= $invalidPassword;

} else {
    $password = filter_var($_POST["password"], FILTER_SANITIZE_STRING);

    if(empty($_POST["password2"])){
        $errors .= $missingPassword2;
    } else {
        $password2 = filter_var($_POST["password2"], FILTER_SANITIZE_STRING);
        if($password !== $password2){
            $errors .= $differentPassword;
        }
    }
}

// jeśli są błędy, wyświetl je
if($errors){
    $resultMessage = '<div class="alert alert-danger">' . $errors . '</div>';
    echo $resultMessage;
    exit;
}

// przygotuj dane do zapytania sql i zmień dane w bazie danych
$password = mysqli_real_escape_string($link, $password);
$password = hash('sha256', $password);
$user_id = mysqli_real_escape_string($link, $user_id);

$sql = "UPDATE users SET `password`='$password' WHERE `user_id`='$user_id'";

try {
    $result = mysqli_query($link, $sql);
} catch(Exception $e){
    echo '<div class="alert alert-danger">Przepraszamy. Wystąpił problem ze zmianą twojego hasła. Proszę spróbować ponownie.</div>';
    exit;
}

// zmień status klucza zmiany hasła na 'used', żeby nie można go było podownie wykorzystać
$sql = "UPDATE forgotpassword SET `status`='used' WHERE `key`='$key' AND `user_id`='$user_id'";
try {
    $result = mysqli_query($link, $sql);
    echo '<div class="alert alert-success">Twoje hasło zostało zaktualizowane! <a href="index.php">Zaloguj się</a></div>';
} catch(Exception $e){
    echo '<div class="alert alert-danger">Błąd przetwarzania zapytania</div>';
    exit;
}


?>