<?php
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
?>
<!DOCTYPE html>
<html lang="en">
    
<head>
<title>Handicapping horse racing Thoroughwiz</title>
<!-- Meta Data -->
<?php include("meta.php"); ?>
<!-- CSS Import -->
<?php include("style_block.php"); ?>
</head>
    
<body>
    
<div class="wrapper">
    
	<?php include("header.php"); ?>
    
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h3>Twiz buttons</h3>
                <p>Submit button with font awesome:<br>
                    <button type="submit" class="btn btn-success pull-center"><i class="fa fa-sign-in"></i>&nbsp;&nbsp;Log In</button></p>
                <p>Submit button with glyphicon:<br>
                    <button type="submit" class='btn btn-success'><span class="glyphicon glyphicon-gift"></span>&nbsp;&nbsp;View Free Samples!</button></p>
                
                <p>Anchor tag with font awesome:<br>
                    <a href="#" target="_blank" class="btn btn-success"><i class="fa fa-video-camera"></i>&nbsp;&nbsp;Video</a></p>
                <p>Anchor tag with glyphicon:<br>
                    <a href='register.php' class='btn btn-success'><span class='glyphicon glyphicon-user'></span>&nbsp;&nbsp;Register Now!</a></p>
            </div>

        </div>
    </div>

<?php include("footer.php"); ?>
    
</div>
    
    <script>
    // new HTML5 'required' attribute is not supported in legacy browsers (IE9 and earlier); this provides a graceful fallback to alert users of required fields
$(function () {
	
    // feature detection for required attribute
    var supportsRequired = 'required' in document.createElement('input')
	
        // if 'required' isn't supported
        if (!supportsRequired) {

    		// loop through each element with a 'required' attribute
    		$('[required]').each(function () {

            	// this
            	var self = $(this)

            	// swap attribute for class
            	self.removeAttr('required').addClass('required');

            	// append an error message
            	self.parent().append('<span class="form-error">Required</span>')

    		}); //end each loop
	
        }; // end if supportsrequired
		
		

    // submit the form
    $('#login-form').on('submit', function (e) {
		
        // if 'required' isn't supported
		if (!supportsRequired) {
		
			// loop through class name required
			$('.required').each(function () {
	
				// this
				var self = $(this)
	
				// check shorthand if statement for input[type] detection
				var checked = (self.is(':checkbox') || self.is(':radio')) 
				? self.is(':not(:checked)') && $('input[name=' + self.attr('name') + ']:checked').length === 0 
				: false
	
				// run the empty/not:checked test
				if (self.val() === '' || checked) {
	
					// show error if the values are empty still (or re-emptied)
					// this will fire after it's already been checked once
					self.siblings('.form-error').show()
	
					// stop form submitting
					e.preventDefault()
	
				} 
				
			}) // close each loop
		
			// if required is not supported, then we have to check to make sure the fields are not empty for front-end validation
            if ($("#username").val().length !==0 && $("#password").val().length !==0){	
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
						//document.location.href = 'account.php';
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

            } // close if

  		} else { // if required attribute IS supported, we can let HTML 5 handle the validation and jump right to the ajax
		
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
						//document.location.href = 'account.php';
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
				
		}

    }) // close submit function

    // key change on all form inputs i.e user enters and exits a form field
    $('input').on('blur change', function () {

        // this
        var self = $(this)

        // check shorthand if statement for input[type] detection
        var checked = (self.is(':checkbox') || self.is(':radio')) 
        ? self.is(':not(:checked)') && $('input[name=' + self.attr('name') + ']:checked').length === 0 
        : false

        // if empty on change, i.e. if data is removed
        if (self.val() === '' || checked) {

            // show/keep the error in view
            self.siblings('.form-error').show()

        // if there's a value or checked
        } else {

            // hide the error
            self.siblings('.form-error').hide()

        }

    }) // close input blur/change

}) // close main function
    </script>

</body>
    
</html>