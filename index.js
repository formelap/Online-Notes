// SIGNUP

$("#signupForm").submit(function(event){
    event.preventDefault();
    var datatopost = $(this).serializeArray();

    $.ajax({
        url: "signup.php",
        type: "POST",
        data: datatopost,
        success: function(data){
            if(data){
                $("#signupMessage").html(data);
            }
            
        },
        error: function(){
            $("#signupMessage").html("<div class='alert alert-danger'> Problem z zapytaniem Ajax. </div>");
        }
    });


});

// LOGIN

$("#loginForm").submit(function(event){
    event.preventDefault();
    var datatopost = $(this).serializeArray();
    console.log(datatopost);

    $.ajax({
        url: "login.php",
        type: "POST",
        data: datatopost,
        success: function(data){
            if(data == "success"){
                window.location = "mainpageloggedin.php"
            } else {
                $('#loginMessage').html(data);
            }
            
        },
        error: function(){
            $("#signupMessage").html("<div class='alert alert-danger'> Problem z zapytaniem Ajax.</div>");
        }
    });


});


$("#forgotPasswordForm").submit(function(event){
    event.preventDefault();
    var datatopost = $(this).serializeArray();

    $.ajax({
        url: "forgot-password.php",
        type: "POST",
        data: datatopost,
        success: function(data){
            $('#forgotMessage').html(data);
            
        },
        error: function(){
            $("#signupMessage").html("<div class='alert alert-danger'> There was an error with the Ajax call. Please try again later</div>");
        }
    });


});