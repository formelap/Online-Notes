<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("location: index.php");
}

include 'components/header.php'; 

include 'components/background.php';

include 'components/navbar.php'; 
?>


<div class="content container">
<!--  Wyświetlenie błędu -->
    <div id="alert" class="alert alert-danger collapse">
        <button type="button" class="btn-close position-absolute top-0 end-0 m-2" data-bs-dismiss="alert"></button>
        <p id="alert-content"></p>

    </div >
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="mb-3">
                <button id="add-note" type="button" class="btn btn-info btn-lg me-2">Dodaj</button>
                <button id="all-notes" type="button" class="btn btn-info btn-lg me-2">Wszystkie</button>
                <button id="edit-notes" type="button" class="btn btn-info btn-lg float-end">Edytuj</button>
                <button id="done" type="button" class="btn btn-success btn-lg float-end">Gotowe</button>
            </div>

            <div id="note-pad">
                <textarea class="form-control" rows="10"></textarea>
            </div>

            <div id="notes" class="notes m-2">
                <!-- ajax call do pliku php -->
            </div>

        </div>
    </div>
</div>



<script src="my-notes.js"></script>

<?php include 'components/footer.php' ?>
