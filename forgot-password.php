<?php

session_start();

include('connection.php');

// sprawdzanie wprowadzonych danych
$missingEmail='<p><strong>Proszę wprowadzić adres email!</strong></p>';
$invalidEmail='<p><strong>Proszę wprowadzić prawidłowy adres email!</strong></p>';
$errors = '';

if(empty($_POST["forgot-email"])){
    $errors .= $missingEmail;
} else {
    $email = filter_var($_POST["forgot-email"], FILTER_SANITIZE_EMAIL);
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors .= $invalidEmail;
    }
}

// jeśli są błędy, wyświetl je
if($errors){
    $resultMessage = '<div class="alert alert-danger">' . $errors . '</div>';
    echo $resultMessage;
    exit;
}

$email = mysqli_real_escape_string($link, $email);

// wyświetl błąd, jeśli email nie jest zarejestrowany
$sql = "SELECT * FROM users WHERE email = '$email'";
try {
    $result = mysqli_query($link, $sql);
} catch(Exception $e){
    echo '<div class="alert alert-danger">Błąd przetwarzania zapytania</div>';
    exit;
}

$count = mysqli_num_rows($result);
if(!$count) {
    echo '<div class="alert alert-danger">Konto o podanym adresie email nie jest zarejestrowane.</div>';
    exit;
}

// wydobądź potrzebne dane
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$user_id = intval($row['user_id']);

// stwórz kod aktywacyjny
$key = bin2hex(random_bytes(16));

// wstaw dane do bazy danych
$time = time();
$status = 'pending';
$sql = "INSERT INTO forgotpassword (`user_id`, `key`, `time`, `status`) VALUES ('$user_id', '$key', '$time', '$status')";
try{
    $result = mysqli_query($link, $sql);
} catch(Exception $e){
    echo '<div class="alert alert-danger">Błąd przetwarzania danych użytkownika</div>';
    exit;
}

// wysłanie email z linkiem aktywacyjnym
$env = parse_ini_file('.env');
$auth_email = $env['AUTH_EMAIL'];

$origin = $_SERVER['HTTP_ORIGIN'];
$message = "Zresetuj hasło:\n\n";
$message .= "$origin/reset-password.php?user_id=$user_id&key=$key";
if(mail($email, 'Resetowanie hasła', $message, "From: $auth_email")){
    echo "<div class='alert alert-success'>Email z linkiem resetującym hasło został wysłany na $email. </div>";
} else {
    echo "<div class='alert alert-success'>Nie udało się ;( </div>";

}

?>