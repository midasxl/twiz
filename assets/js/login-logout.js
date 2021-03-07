$(document).ready(function(){
	
    $("#logInDiv").dialog({
        modal: true,
        draggable: false,
        autoOpen: false,
        closeOnEscape: false,
        dialogClass: "no-close",
        height: 100
    });
        
    $(document).ajaxStart(function(){ 
        $("#logInDiv").dialog("open"); 
    });
    
    $(document).ajaxStop(function(){ 
        $('#logInDiv').dialog("close");
    });
        
    // submit the form
    $('#login-form').on('submit', function (e) {            
        
        // Get the form.
        var form = $('#login-form');
    
        // Get the messages div.
        var formMessages = $('#form-messages');
        var logInGood = $('#logInGood');
        
        // Stop the browser from submitting the form.
        e.preventDefault();
        
        // Serialize the form data.
        var formData = $(form).serialize();
        
        $.ajax({
            url: $(form).attr('action'),
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(data) {
                if(data[0] == "match"){
                    $(logInGood).html("Retrieving Membership Data...");
                    $(logInGood).dialog({
                    modal: true,
                    draggable: false,
                    autoOpen: false,
                    closeOnEscape: false,
                    dialogClass: "no-close",
                    height: 100
                });
                $(logInGood).dialog("open");
                setTimeout(function(){ document.location.href = 'account.php'; }, 3000);
                }else{
                $(formMessages).html(data[0]);
                $(formMessages).dialog({
                    autoOpen: false,
                    modal: true,
                    buttons: [ { 
                        text: "Ok", click: function() { 
                        $( this ).dialog( "close" );
                    } 
                    } ]
                });
                $(formMessages).dialog("open");
                }
            },
            error: function(xhr, desc, err) {
                //$(formMessages).html("Details: " + desc + "\nError:" + err + "\nError:" + xhr);
                $(formMessages).html("The system has encountered an error");
                $(formMessages).dialog({
                    autoOpen: false,
                    modal: true,
                    buttons: [ { 
                        text: "Ok", click: function() { 
                        $( this ).dialog( "close" );
                    } 
                    } ]
                });
                $(formMessages).dialog("open");
            }
        }); // end ajax call
                
    });

    $("#logOutButton").click(function(e){
        e.preventDefault();
        $("#logOutDiv").dialog("open");
        setTimeout(function(){
          window.location.href = "logout.php";
        }, 3000);
    });
          
      $("#logOutDiv").dialog({
        modal: true,
        draggable: false,
        autoOpen: false,
        closeOnEscape: false,
        dialogClass: "no-close",
        height: 100
    });
        
}); //jquery
