<?php

session_start();
include('connection.php');

include('logout.php');

include('rememberme.php');

if(isset($_SESSION['user_id'])){
    header("location: mainpageloggedin.php");
}

 include 'components/header.php';

 include 'components/background.php';

 include 'components/navbar.php'; 
 
 ?>

        <!-- Jumbotron with sign up button -->
        
        <div class="content text-main container">
            <h1><strong>Notatki Online</strong></h1>
            <p><h4>Twoje notatki zawsze przy Tobie, gdziekolwiek jesteś.</h4></p>
            <p><h4>Łatwe w użyciu, przechowuje wszystkie Twoje notatki!</h4></p>
            <button type="button" class="btn btn-lg green signup" data-bs-target="#signupModal" data-bs-toggle="modal">Zarejestruj się za darmo!</button>
        </div>


<?php 

include 'components/modals.php'; 

include 'components/footer.php';

?>


    

