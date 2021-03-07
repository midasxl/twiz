<?php
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Handicapping horse racing Thoroughwiz Contact Us</title>
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
      <h1 class="pull-left">Contact Us</h1>
      <ul class="pull-right breadcrumb">
        <li><a href="index.php">Home</a></li>
        <li class="active">Contact Us</li>
      </ul>
    </div>
  </div>
  <!--/breadcrumbs-->
  <!--=== End Breadcrumbs ===-->
  <!--=== Content Part ===-->
  <div class="container content">
    <div class="row margin-bottom-30">
      <div class="col-md-8 mobile-sep">
        <p>*All Fields are Required</p>
        <form method="post" id="contact-form" action="contact-submit.php">
        
        <div class="input-group margin-bottom-20">
            <span class="input-group-addon"><i class="fa fa-user"></i></span>
            <input type="text" name="name" placeholder="Name" class="form-control" id="name" required/>
        </div>                    
        <div class="input-group margin-bottom-20">
            <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
            <input type="text" name="email" placeholder="Valid Email Address" class="form-control" id="email" required/>
        </div>
        <div class="input-group margin-bottom-20">
            <span class="input-group-addon"><i class="fa fa-comment"></i></span>
            <textarea rows="8" name="message" id="message" maxlength="250" placeholder="Your Message" class="form-control" required></textarea>
        </div>
        <label>Security Code (enter code below):</label><br><img src='models/captcha.php'>
            <div class="input-group margin-bottom-20">    
                    <span class="input-group-addon"><i class="fa fa-key"></i></span>
                    <input type="text" name="captcha" id="captcha" class="form-control" required/>
            </div> 
          <p>
            <button type="submit" class="btn btn-success pull-right"><i class="fa fa-envelope"></i>&nbsp;&nbsp;Send Message</button>
          </p>          
        </form>
          
        <!--<div id="form-messages" title="Thoroughwiz says..." style="text-align:center;padding:5px;"></div>-->
        <p class="success" style="display:none;color:#090"><i class="fa fa-check-square-o"></i>Thank you for your correspondence. Your message has been sent successfully.</p>
        <p class="error" style="display:none;"><i class="fa fa-frown-o"></i>Our email agent has experienced errors. Please notify Thoroughwiz <a href="mailto:support@thoroughwiz.com" class="">Administrators.</a>&nbsp;&nbsp;We sincerely apologize for this inconvenience.</p>
        
      </div>
      <!--/col-md-9-->
      <div class="col-md-4">
        <!-- Contacts -->
        <div class="headline">
          <h2>Company Data</h2>
        </div>
        <ul class="list-unstyled who margin-bottom-30">
          <!--<li><i class="fa fa-users"></i>Partnership: Wood/Husband-Wood</li>
          <li><i class="fa fa-home"></i>Horseheads, NY 14845</li>-->
          <li><a href="mailto:support@thoroughwiz.com?subject=From the contact page"><i class="fa fa-envelope"></i>support@thoroughwiz.com</a></li>
          <li><a href="https://www.twizfigs.com"><i class="fa fa-globe"></i>https://www.twizfigs.com</a></li>
        </ul>
        <!-- Why we are? -->
        <div class="headline">
          <h2>Why do we do this?</h2>
        </div>
        <p>Simple. We have an obsession with the horse racing industry. We also really dig complicated algorithms. And we need some kind of justification for consuming massive amounts of coffee. So, that's it. Horses and coffee. And math.</p>
        <!-- Social -->
        <div class="magazine-sb-social margin-bottom-20">
          <div class="headline headline-md">
            <h2>Social Networks</h2>
          </div>
          <ul class="social-icons social-icons-color">
            <li><a href="https://twitter.com/thoroughwiz" data-original-title="Twitter" class="social_twitter" target="_blank"></a></li>
                    	<li><a href="https://facebook.com/thoroughwizsheets" data-original-title="Facebook" class="social_facebook" target="_blank"></a></li>
                        <li><a href="https://www.youtube.com/c/thoroughwizsheets" data-original-title="Youtube" class="social_youtube" target="_blank"></a></li>
                        
          </ul>
          <div class="clearfix"></div>
        </div><!-- End Social -->
      </div><!--/col-md-3-->
    </div><!--/row-->
    
  </div><!--/container-->
  <!--=== End Content Part ===-->
	<?php include("modals.php"); ?>
	<?php include("footer.php"); ?>
</div><!--/wrapper-->
<script type="text/javascript">
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
    $('#contact-form').on('submit', function (e) {
		
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
			if ($("#name").val().length !==0 && $("#email").val().length !==0 && $("#message").val().length !==0 && $("#captcha").val().length !==0){	
				// Get the form.
				var form = $('#contact-form');
			
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
								$('form').find("input[type=text], textarea").val("");
								$('.success').show();
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
				var form = $('#contact-form');
			
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
								$('form').find("input[type=text], textarea").val("");
								$('.success').show();
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
						$(formMessages).html("Details: " + desc + "\nError:" + err + "\nError:" + eval(xhr));
						//$(formMessages).html("The system has encountered an error");
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