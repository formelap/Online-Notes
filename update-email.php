<?php

// rozpocznij sesję
session_start();
include('connection.php');

// określ user_id i nowy adres email
$user_id = $_SESSION['user_id'];
$newEmail = $_POST['email'];

// sprawdź czy nowy email istnieje w bazie danych
$sql = "SELECT * FROM users WHERE `email`='$email'";
try{
    $result = mysqli_query($link, $sql);
} catch(Exception $e){
    echo "<div class='alert alert-danger'>Błąd zapytania bazy danych.</div>";
}

$count = mysqli_num_rows($result);
if($count > 0){
    echo "<div class='alert alert-danger'>Konto na podany adres email zostało już zarejestrowane. Proszę wybrać inny adres email.</div>";
    exit;
}

// określ obecny adres email
$sql = "SELECT * FROM users WHERE user_id='$user_id'";
try{
    $result = mysqli_query($link, $sql);
} catch(Exception $e){
    echo "Problem";
}

$count = mysqli_num_rows($result);

if($count == 1){
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $email = $row['email'];

} else {
    echo "<div class='alert alert-danger'>Wystąpił błąd pozyskania adresu email z bazy danych</div>";
    exit;
}

// stwórz kod aktywacyjny
$activationKey = bin2hex(random_bytes(16));

// wyślij maila z linkiem aktywacyjnym do activate-new-email.php
$message = "Link aktywacyjny nowego adresu email:\n\n";
$message .= "http://localhost:4000/activate-new-email.php?email=" . urlencode($email) . "&newEmail=". urlencode($newEmail) . "&key=$activationKey";
if(mail($newEmail, 'Potwierdzenie zmiany adresu email', $message, 'From: notatki_online@wp.pl')){
    // zaktualizuj kod aktywacyjny w bazie danych
    $sql = "UPDATE users SET `activation2`='$activationKey' WHERE `user_id`='$user_id'";

    try{
        $result = mysqli_query($link, $sql);
    } catch(Exception $e){
        echo "<div class='alert alert-danger'>Wystąpił błąd aktualizacji adresu email</div>";
        exit;
    }
    echo "<div class='alert alert-success'>Email z linkiem aktywacyjnym dla nowego adresu został wysłany na nowy adres email. </div>";
} else {
    echo "<div class='alert alert-success'>Nie udało się ;( </div>";

}


?>