<?php
if(isset($_SESSION['user_id']) && $_GET['logout'] == 1){
    // zakończ sesję
    session_destroy();

    // zniszcz ciasteczko
    setcookie('rememberme', '', time()-3600);

}


?>