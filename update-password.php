<?php
// rozpocznij sesję
session_start();
include('connection.php');

// zdefiniuj błędy
$missingCurrentPassword='<p><strong>Proszę wprowadzić obecne hasło!</strong></p>';
$incorrectCurrentPassword='<p><strong>Podano złe hasło!</strong></p>';
$missingPassword='<p><strong>Proszę wprowadzić nowe hasło!</strong></p>';
$invalidPassword='<p><strong>Twoje hasło powinno mieć co najmniej 6 znaków i zawierać jedną wielką literę oraz jedną cyfrę!</strong></p>';
$differentPassword='<p><strong>Podane hasła nie pasują do siebie!</strong></p>';
$missingPassword2='<p><strong>Proszę potwierdzić hasło!</strong></p>';
$errors = '';

// sprawdź czy są błędy
if(empty($_POST['currentPassword'])){
    $errors .= $missingCurrentPassword;
} else {
    $currentPassword = $_POST['currentPassword'];
    $currentPassword = filter_var($currentPassword, FILTER_SANITIZE_STRING);
    $currentPassword = mysqli_real_escape_string($link, $currentPassword);
    $currentPassword = hash('sha256', $currentPassword);
    
    //sprawdź poprawność hasła
    $user_id = intval($_SESSION['user_id']);
    $sql = "SELECT password FROM users WHERE `user_id`='$user_id'";

    try{
        $result = mysqli_query($link, $sql);
        $count = mysqli_num_rows($result);
        if($count !== 1){
            echo "<div class='alert alert-danger'>Wystąpił problem zapytania bazy danych.</div>";
            exit;
        } else {
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            if($currentPassword !== $row['password']){
                $errors .= $incorrectCurrentPassword;
            }
        }

    } catch(Exception $e){
        echo "<div class='alert alert-danger'>Wystąpił problem zapytania bazy danych!</div>";
        exit;
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

if($errors){
    $resultMessage = '<div class="alert alert-danger">' . $errors . '</div>';
    echo $resultMessage;
    exit;
}

// zaktualizuj hasło w bazie danych
$password = mysqli_real_escape_string($link, $password);
$password = hash('sha256', $password);
$sql = "UPDATE users SET `password`='$password' WHERE `user_id`='$user_id'";

try{
    $result = mysqli_query($link, $sql);
    echo '<div class="alert alert-success">Hasło zostało zaktualizowane</div>';
} catch(Exception $e){
    echo '<div class="alert alert-danger">Hasło nie może zostać zaktualizowane. Proszę spróbować ponownie.</div>';
}


?>