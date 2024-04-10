$(function(){
    // definicja zmiennych
    var activeNote = 0;
    var editMode = false;
    
    // ładowanie notatek - load-notes.php
    $.ajax({
        url: "load-notes.php",
        success: function(data){
            $('#notes').html(data);
            clickOnNote();
            clickOnDelete();
        },
        error: function(){
            $('#alert-content').text('Wystąpił problem zapytania Ajax');
            $('#alert').fadeIn();
        }
    });


    // dodawanie notatek - create-note.php
    $('#add-note').click(function(){
        $.ajax({
            url: "create-note.php",
            success: function(data){
                if(data == 'error'){
                    $('#alert-content').text('Wystąpił problem połączenia z bazą danych.');
                    $('#alert').fadeIn();
                    
                } else {
                    // aktualizacja activeNote numerem id z bazy danych
                    activeNote = data;
                    $('textarea').val('');
                    showHide(['#note-pad', '#all-notes'], ['#notes', '#add-note', '#edit-notes', '#done']);
                    $('textarea').focus();

                }
            },
            error: function(){
                $('#alert-content').text('Wystąpił problem zapytania Ajax.');
                        $('#alert').fadeIn();
            }
        })
    });

    // wpisanie notatki - update.php
    $('textarea').keyup(function(){
        // ajax - aktualizacja notatki
        $.ajax({
            url: 'update-note.php',
            type: 'POST',
            // wysłanie id notatki i jej zawartości do php
            data: {note: $(this).val(), id: activeNote},
            success: function(data){
                if(data == 'error'){
                    $('#alert-content').text('Wystąpił problem z aktualizacją notatki w bazie danych.');
                    $('#alert').fadeIn();
                }
            },
            error: function(){
                $('#alert-content').text('Wystąpił problem zapytania Ajax');
                $('#alert').fadeIn();
            }
        })
    });

    // przycisk 'Wszystkie'
    $('#all-notes').click(function(){
        $.ajax({
            url: "load-notes.php",
            success: function(data){
                $('#notes').html(data);
                showHide(['#add-note', '#edit-notes', '#notes'], ['#all-notes', '#note-pad'])
                clickOnNote();
                clickOnDelete();
            },
            error: function(){
                $('#alert-content').text('Wystąpił problem zapytania Ajax');
                $('#alert').fadeIn();
            }
        });
    });

    // przycisk 'Gotowe'
    $('#done').click(function(){
        editMode = false;
        $('.note-header').removeClass('col-8');
        showHide(['#edit-notes'], [this, '.delete']);

    });


    // przycisk 'Edytuj'
    $('#edit-notes').click(function(){
        editMode = true;
        // zmiana rozmiaru okien
        $('.note-header').addClass('col-8');

        showHide(['#done', '.delete'], [this]);


    });


    // przycisk 'Usuń'
    function clickOnDelete(){
        $('.delete').click(function(){
            var deleteButton = $(this);
            // zapytanie Ajax, usunięcie notatki
            $.ajax({
                url: 'delete-note.php',
                type: 'POST',
                // wysłanie id notatki i jej zawartości do php
                data: {id: deleteButton.next().attr('id')},
                success: function(data){
                    if(data == 'error'){
                        $('#alert-content').text('Wystąpił problem z usunięciem notatki z bazy danych.');
                        $('#alert').fadeIn();
                    } else {
                        // usuń <div> po notatce
                        deleteButton.parent().remove();
                    }
                },
                error: function(){
                    $('#alert-content').text('Wystąpił problem zapytania Ajax');
                    $('#alert').fadeIn();
                }
            })

        });
    }

    function clickOnNote(){
        $('.note-header').click(function(){
            if(!editMode){
                activeNote = $(this).attr('id');
    
                // wypełnienie pola tekstowego 
                $('textarea').val($(this).find('.note-text').text());
                // schowanie niepotrzebnych elementów
                showHide(['#note-pad', '#all-notes'], ['#notes', '#add-note', '#edit-notes', '#done']);
                $('textarea').focus();
            }
        });
    }


    // funkcje pomocnicze
    function showHide(array1, array2){
        for(i = 0; i < array1.length; i++){
            $(array1[i]).show();
        }
        for(i = 0; i < array2.length; i++){
            $(array2[i]).hide();
        }
    };

});