<?php
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
if(isUserLoggedIn()) { header("Location: account.php"); die(); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Thoroughwiz | Resend Activation Email</title>
<!-- Meta Data -->
<?php include("meta.php"); ?>
<!-- CSS Import -->
<?php include("style_block.php"); ?>
</head>
<body>
<div class="wrapper">
  <?php include("header.php"); ?>
  <!--=== Breadcrumbs ===-->
  <div class="breadcrumbs">
    <div class="container">
      <h1 class="pull-left">Resend Activation Email</h1>
      <ul class="pull-right breadcrumb">
        <li><a href="index.php">Home</a></li>
        <li class="active">Resend Activation Email</li>
      </ul>
    </div>
  </div>
  <!--/breadcrumbs-->
  <!--=== End Breadcrumbs ===-->
  <!--=== Content Part ===-->
  <div class="container content">
    <div class="row">
      <div class="col-md-3">
        <h3>Account not active?</h3>
          <p>Provide your valid registered email address and we will send you instructions to activate your account.</p>
      </div>
      <!--/col-md-3-->
      <div class="col-md-4">
        <h3>Please provide credentials</h3>
		<form id="resend-activation-form" name="resendActivation" action="user-resend-activation.php" method="post"> 
        <!-- <label>Username:</label>
        <div class="input-group margin-bottom-20">
            <span class="input-group-addon"><i class="fa fa-user"></i></span>
            <input type="text" id="username" name="username" class="form-control" required/>
        </div> -->
        <label>Registered Email Address:</label>                 
        <div class="input-group margin-bottom-20">
            <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
            <input type="text" id="email" name="email" class="form-control" required/>
        </div>
        <div class="row">
            <div class="col-md-12">
                <button type="submit" class="btn btn-success pull-right"><i class="fa fa-info-circle"></i>&nbsp;&nbsp;Send Instructions!</button>
            </div>
        </div>
        </form>
        <!--<div id="form-messages" title="Thoroughwiz says..." style="text-align:center;padding:5px;"></div>-->
      </div>
      <!--/col-md-4-->
    </div>
    <!--/row-->
  </div>
  <!--/container-->
  <!--=== End Content Part ===-->
  <?php include("footer.php"); ?>
    <?php include("modals.php"); ?>
</div><!--/wrapper-->
<script>
$(document).ready(function(){
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
    $('#resend-activation-form').on('submit', function (e) {
		
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
		
			/* if ($("#firstname").val().length !==0 && $("#lastname").val().length !==0 && $("#email").val().length !==0 && $("#username").val().length !==0 && $("#displayname").val().length !==0 && $("#password").val().length !==0 && $("#passwordc").val().length !==0 && $("#captcha").val().length !==0){*/ 
			if ($("#email").val().length !==0){	
				// Get the form.
				var form = $('#resend-activation-form');
			
				// Get the messages div.
				var formMessages = $('#form-messages');
				
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
						$(formMessages).html(data[1]);
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

            } // close if/else

  		} else { // if required attribute IS supported, we can let HTML 5 handle the validation and jump right to the ajax
		
				// Get the form.
				var form = $('#resend-activation-form');
			
				// Get the messages div.
				var formMessages = $('#form-messages');
				
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
						$(formMessages).html(data[1]);
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
						//$(formMessages).html("Details: " + desc + "\nError:" + err + "\nError:" + eval(xhr));
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

}); //jquery
</script>
</body>
</html>