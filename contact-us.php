<?php

session_start();

include 'components/header.php';

include 'components/background.php';
    
include 'components/navbar.php'; ?>
    
<div class="content container">
    <div id="contactMessage"></div>
    <!--  Wyświetlenie błędu -->
    <div id="danger" class="alert alert-danger collapse">
        <button type="button" class="btn-close position-absolute top-0 end-0 m-2" data-bs-dismiss="alert"></button>
        <p id="danger-content"></p>
    </div >
    <!--  Wyświetlenie poprawnego wysłania maila -->
    <div id="success" class="collapse">
        <button type="button" class="btn-close position-absolute top-0 end-0 m-2" data-bs-dismiss="alert"></button>
        <p id="success-content"></p>
    </div >

    <p><h1>KONTAKT:</h1></p>
    <form class="contact-form" id="contactForm"  method="post">
        <div class="form-group">
            <input class="form-control" type="text" name="name" placeholder="Imię i nazwisko"/>
        </div>
        <div class="form-group">
            <input class="form-control" type="email" name="email" placeholder="Twój email"/>
        </div>
        <div class="form-group">
            <input class="form-control" type="text" name="subject" placeholder="Temat wiadomości"/>
        </div>
        <div class="form-group">
            <textarea class="form-control" name="message" rows="10" placeholder="Twoje wiadomość"></textarea>
        </div>
        <input class="btn btn-lg green" name="contact" type="submit" value="Wyślij wiadomość">



    </form>
</div>

<?php include 'components/modals.php' ?>

<script src="contact-us.js"></script>
    
<?php include 'components/footer.php' ?>