$("#contactForm").submit(function(event){
    event.preventDefault();
    var datatopost = $(this).serializeArray();

    $.ajax({
        url: "send-message.php",
        type: "POST",
        data: datatopost,
        success: function(data){
            if(data){
                $("#contactMessage").html(data);
            }  
        },
        error: function(){
            $('#contactMessage').html('<div class="alert alert-danger"><button type="button" class="btn-close position-absolute top-0 end-0 m-2" data-bs-dismiss="alert"></button><p>Wystąpił problem zapytania Ajax.</p></div >');
        }
    });


});