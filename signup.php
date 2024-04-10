<?php

// rozpoczęcie sesji
session_start();
include('connection.php');

// sprawdzenie wprowadzonych danych
$missingUsername='<p><strong>Proszę wprowadzić nazwę użytkownika!</strong></p>';
$missingEmail='<p><strong>Proszę wprowadzić adres email!</strong></p>';
$invalidEmail='<p><strong>Proszę wprowadzić prawidłowy adres email!</strong></p>';
$missingPassword='<p><strong>Proszę wprowadzić hasło!</strong></p>';
$invalidPassword='<p><strong>Twoje hasło powinno mieć co najmniej 6 znaków i zawierać jedną wielką literę oraz jedną cyfrę!</strong></p>';
$differentPassword='<p><strong>Podane hasła nie pasują do siebie!</strong></p>';
$missingPassword2='<p><strong>Proszę potwierdzić hasło!</strong></p>';
$errors = '';

if(empty($_POST["username"])){
    $errors .= $missingUsername;
} else {
    $username = filter_var($_POST["username"], FILTER_SANITIZE_STRING);
}

if(empty($_POST["email"])){
    $errors .= $missingEmail;
} else {
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors .= $invalidEmail;
    }
}

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

// przygotowanie zmiennych do zapytań
$username = mysqli_real_escape_string($link, $username);
$email = mysqli_real_escape_string($link, $email);
$password = mysqli_real_escape_string($link, $password);
// $password = md5($password);
$password = hash('sha256', $password);




// wyświetl błąd, jeśli użytkownik już istnieje
$sql = "SELECT * FROM users WHERE username = '$username'";
try {
    $result = mysqli_query($link, $sql);
} catch(Exception $e){
    echo '<div class="alert alert-danger">Błąd przetwarzania zapytania</div>';
    // echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
    exit;
}


$results = mysqli_num_rows($result);
if($results) {
    echo '<div class="alert alert-danger">Nazwa użytkownika jest już zajęta.</div>';
    exit;
}

// wyświetl błąd, jeśli email już zarejestrowany
$sql = "SELECT * FROM users WHERE email = '$email'";
try {
    $result = mysqli_query($link, $sql);
} catch(Exception $e){
    echo '<div class="alert alert-danger">Błąd przetwarzania zapytania</div>';
    // echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
    exit;
}

$results = mysqli_num_rows($result);
if($results) {
    echo '<div class="alert alert-danger">Konto na podany adres email jest już zarejestrowane. notati</div>';
    exit;
}

// stwórz kod aktywacyjny
$activationKey = bin2hex(random_bytes(16));

// wstawienie danych użytkownika i kodu aktywacyjnego do bazy
$sql = "INSERT INTO users (username, email, password, activation) VALUES ('$username', '$email', '$password', '$activationKey')";
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
$message = "Link aktywacyjny:\n\n";
$message .= "$origin/activate.php?email=" . urlencode($email) . "&key=$activationKey";
if(mail($email, 'Potwierdzenie rejestracji', $message, "From: $auth_email")){
    echo "<div class='alert alert-success'>Dzięki za rejestrację! Email z linkiem aktywacyjnym został wysłany na Twój adres email. </div>";
} else {
    echo "<div class='alert alert-success'>Nie udało się ;( </div>";

}

?>