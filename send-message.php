<?php

// zdefiniuj błędy
$missingName = '<p><strong>Proszę wprowadzić imię i nazwisko!</strong></p>';
$missingEmail = '<p><strong>Proszę wprowadzić adres email!</strong></p>';
$invalidEmail = '<p><strong>Proszę wprowadzić prawidłowy adres email!</strong></p>';
$missingSubject = '<p><strong>Proszę podać temat wiadomości!</strong></p>';
$missingMessage = '<p><strong>Proszę wpisać treść wiadomości!</strong></p>';
$errors = '';

if(empty($_POST["name"])){
    $errors .= $missingName;
} else {
    $name = filter_var($_POST["name"], FILTER_SANITIZE_STRING);
}

if(empty($_POST["email"])){
    $errors .= $missingEmail;
} else {
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors .= $invalidEmail;
    }
}

if(empty($_POST["subject"])){
    $errors .= $missingSubject;
} else {
    $subject = filter_var($_POST["subject"], FILTER_SANITIZE_STRING);
}

if(empty($_POST["message"])){
    $errors .= $missingMessage;
} else {
    $message = filter_var($_POST["message"], FILTER_SANITIZE_STRING);
}

if($errors){
    $resultMessage = '
        <div class="alert alert-danger">
            <button type="button" class="btn-close position-absolute top-0 end-0 m-2" data-bs-dismiss="alert"></button>
            <p>'.$errors.'</p>
        </div >';
    echo $resultMessage;
    exit;
} 

$header = "Wiadomość od: " . $name ."\n\nOdpowiedź na: " . $email . "\n\n";
$message = $header . $message;

$env = parse_ini_file('.env');
$auth_email = $env['AUTH_EMAIL'];
$headers = "From: $auth_email\r\nReply-To: $email";

if(mail($auth_email, $subject, $message, $headers)){
    echo "<div class='alert alert-success'>Dzięki za wiadomość! Postaramy się odpowiedzieć jak najszybciej. </div>";
} else {
    echo "<div class='alert alert-success'>Nie udało się ;( </div>";

}





?>