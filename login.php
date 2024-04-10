<?php
// rozpoczęcie secji
session_start();
include("connection.php");

// sprawdź wprowadzone dane
$missingEmail = '<p><strong>Proszę podać adres email.</strong></p>';
$missingPassword = '<p><strong>Proszę wpisać hasło.</strong></p>';
$errors = '';

if(empty($_POST["loginEmail"])){
    $errors .= $missingEmail;
} else {
    $email = filter_var($_POST["loginEmail"], FILTER_SANITIZE_EMAIL);
}

if(empty($_POST["loginPassword"])){
    $errors .= $missingPassword;
} else {
    $password = filter_var($_POST["loginPassword"], FILTER_SANITIZE_STRING);
}

// sprawdź czy są jakieś błędy
if($errors){
    $resultMessage = '<div class="alert alert-danger">' . $errors . '</div>';
    echo $resultMessage;
} else {
    // przygotowanie zmiennych do zapytań
    $email = mysqli_real_escape_string($link, $email);
    $password = mysqli_real_escape_string($link, $password);
    $password = hash('sha256', $password);


    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password' AND activation='activated'";

    try {
        $result = mysqli_query($link, $sql);
    } catch(Exception $e){
        echo '<div class="alert alert-danger">Błąd przetwarzania zapytania</div>';
        exit;
    }



    $count = mysqli_num_rows($result);
    if($count !== 1){
        echo '<div class="alert alert-danger">Podano nieprawidłowy adres email lub hasło.</div>';

    } else {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['email'] = $row['email'];

        // sprawdź czy zaznaczono pole 'Zapamiętaj'
        if(empty($_POST['rememberme'])){
            echo "success";
        } else {
            // stwórz klucze uwierzytelniające authenticator1 i authenticator2
            
            $authenticator1 = bin2hex(openssl_random_pseudo_bytes(10));
            $authenticator2 = openssl_random_pseudo_bytes(20);

            // zapisz klucze w ciasteczku
            $cookieValue = f1($authenticator1, $authenticator2);
            setcookie('rememberme', $cookieValue, time() + 15*24*60*60);

            // zapisz zmienne w bazie danych
            $f2authenticator2 = f2($authenticator2);
            $user_id = $_SESSION['user_id'];
            $expiration = date('Y-m-H H:i:s', time() + 15*24*60*60);
            $sql = "INSERT INTO rememberme (authenticator1, f2authenticator2, user_id, expires) VALUES ('$authenticator1', '$f2authenticator2', '$user_id', '$expiration')";
            try{
                $result = mysqli_query($link, $sql);
                echo 'success';
            } catch(Exception $e){
                echo '<div class="alert alert-danger">Podczas zapisywania danych wystąpił błąd, aby zapamiętać Cię na następny raz.</div>';
                exit;
            }

        }
    }
}

function f1($key1, $key2){
    $result = $key1 . ',' . bin2hex($key2);  
    return $result;            
}

function f2($key) {
    $result = hash('sha256', $key);
    return $result;
}


?>