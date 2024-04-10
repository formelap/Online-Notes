<?php
// sprawdź czy użytkownik nie jest już zalogowany i czy istnieje ciasteczko 'rememberme'
if(!isset($_SESSION['user_id']) && !empty($_COOKIE['rememberme'])){
    array_key_exists('user_id', $_SESSION);
    // f1: COOKIE: $key1 . ',' . bin2hex($key2); 
    // f2: hash('sha256', $key);

    // wydobądź klucze uwierzytelniające z ciasteczka
    list($authenticator1, $authenticator2) = explode(',', $_COOKIE['rememberme']);
    $authenticator2 = hex2bin($authenticator2);
    $f2authenticator2 = hash('sha256', $authenticator2);

    // wydobądź klucze uwierzytelniające z bazy danych
    $sql = "SELECT * FROM rememberme WHERE authenticator1='$authenticator1'";
    // $result;
    try{
        $result = mysqli_query($link, $sql);
    } catch(Exception $e){
        echo '<div class="alert alert-danger">Błąd wydobycia kluczy uwierzytelniających z bazy danych.</div>';
        exit;
    }
    
    $count = mysqli_num_rows($result);
    if($count !== 1){
        echo '<div class="alert alert-danger">Błąd procesu zapamiętywania użytkownika.</div>';
        exit;
    }

    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

    // porównanie kluczy
    if(!hash_equals($row['f2authenticator2'], $f2authenticator2)){
        echo '<div class="alert alert-danger">Zapisane klucze nie pasują do siebie.</div>';
        exit;
    } else {
        // wygeneruj i zapisz nowe klucze uwierzytelniające
        $authenticator1 = bin2hex(openssl_random_pseudo_bytes(10));
        $authenticator2 = openssl_random_pseudo_bytes(20);

        // zapisz klucze w ciasteczku
        $cookieValue = f1($authenticator1, $authenticator2);
        setcookie('rememberme', $cookieValue, time() + 15*24*60*60);

        // zapisz zmienne w bazie danych
        $f2authenticator2 = f2($authenticator2);
        $user_id = intval($_SESSION['user_id']);
        $expiration = date('Y-m-H H:i:s', time() + 15*24*60*60);
        $sql = "INSERT INTO rememberme (authenticator1, f2authenticator2, user_id, expires) VALUES ('$authenticator1', '$f2authenticator2', '$user_id', '$expiration')";
        try{
            $result = mysqli_query($link, $sql);
        } catch(Exception $e){
            echo '<div class="alert alert-danger">Podczas zapisywania danych wystąpił błąd, aby zapamiętać Cię na następny raz.</div>';
            exit;
        }

        // zapisz zmienne sesji i przekieruj na stronę z notatkami
        $_SESSION['user_id'] = $row['user_id'];

        header('location:mainpageloggedin.php');
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