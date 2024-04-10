// zapytanie Ajax do update-username.php
$("#updateUsernameForm").submit(function(event){
    event.preventDefault();
    var datatopost = $(this).serializeArray();
    console.log(datatopost);

    $.ajax({
        url: "update-username.php",
        type: "POST",
        data: datatopost,
        success: function(data){
            if(data){
                $("#updateUsernameMessage").html(data);
            } else {
                location.reload();
            }
            
        },
        error: function(){
            $("#updateUsernameMessage").html("<div class='alert alert-danger'> Wystąpił błąd podczas wywołania Ajax. Spróbuj ponownie później.</div>");
        }
    });
});

// zapytanie Ajax do update-password.php
$("#updatePasswordForm").submit(function(event){
    event.preventDefault();
    var datatopost = $(this).serializeArray();
    console.log(datatopost);

    $.ajax({
        url: "update-password.php",
        type: "POST",
        data: datatopost,
        success: function(data){
            if(data){
                $("#updatePasswordMessage").html(data);
            }
            
        },
        error: function(){
            $("#updatePasswordMessage").html("<div class='alert alert-danger'> Wystąpił błąd podczas wywołania Ajax. Spróbuj ponownie później.</div>");
        }
    });
});

// zapytanie Ajax do update-email.php
$("#updateEmailForm").submit(function(event){
    event.preventDefault();
    var datatopost = $(this).serializeArray();
    console.log(datatopost);

    $.ajax({
        url: "update-email.php",
        type: "POST",
        data: datatopost,
        success: function(data){
            if(data){
                $("#updateEmailMessage").html(data);
            }
            
        },
        error: function(){
            $("#updateEmailMessage").html("<div class='alert alert-danger'> Wystąpił błąd podczas wywołania Ajax. Spróbuj ponownie później.</div>");
        }
    });
});



