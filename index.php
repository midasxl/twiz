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
<!-- never use a row outside a container classed element; it won't work -->
<div class="container">
    <div class="row">
        <div class="col-sm-6">
            <div class="outline">
                <div class="pub_300x250"></div>
            </div>
        </div>
   
    </div>
</div>

<div class="wrapper">
	<?php include("header.php"); ?>
    <div class="purchase">
        <div class="container content">
            <div class="row">        
                <div class="col-md-4 animated fadeInLeft">
				    <p id="opener"><span id="trigger">Member Login</span></p>
                    <form id="homepage-login-form" name="login" action="user-login.php" method="post"> 
                        <label>Email Address:</label>
                        <div class="input-group margin-bottom-20">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <input type="text" id="username" name="email" class="form-control" required/>
                        </div>  
                        <label>Password:</label>                  
                        <div class="input-group margin-bottom-20">
                            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                            <input type="password" id="password" name="password" class="form-control" required/>
                        </div>
                        <div class="row">                            
                            <div class="sign-in-trouble-wrap col-md-6">
                                <a href="forgot-password.php">Forgot Password?</a><br>
                                <a href="resend-activation.php">Resend Activation Email</a><br>
                            </div>
                            <div class="log-in-wrap col-md-6">
                            <button type="submit" class="btn btn-success pull-center"><i class="fa fa-sign-in"></i>&nbsp;&nbsp;Log In</button>
                            </div>
                        </div>
                        <br>
                      
                    </form>
                </div><!-- /col-md-4 -->
            
                <div class="col-md-1">
                </div>
            
                <div class="col-md-7 animated fadeInRight">
                    <p id="opener"><span>THOROUGHWIZ *Now with the ability to filter/customize the PP'lines that make-up the Summary Sheet!</span> A unique algorithm designed over years of observation and testing to produce a special ranking called the <strong>TWIZrank</strong>.  Based on several highly proficient handicappers' precise methodologies, this unique algorithm was developed and refined through computer programming to form a unique way of predicting and quantifying the results of a horse race.</p>
                    
                        <div class="feature-list-wrap col-xs-6">
                                <ul class="feature-list">
                                    <li class="feature-list-item"><i class="fa fa-star color-green"></i>&nbsp;&nbsp;Sortable categories</li>
                                    <li class="feature-list-item"><i class="fa fa-star color-green"></i>&nbsp;&nbsp;Instant access to last race charts</li>
                                    <li class="feature-list-item"><i class="fa fa-star color-green"></i>&nbsp;&nbsp;Proprietary trainer, Jockey and horse ratings</li>
                          
 <li class="feature-list-item"><i class="fa fa-star color-green"></i>&nbsp;&nbsp;Equibase 'E' average speed figures</li>
                                    <li class="feature-list-item"><i class="fa fa-star color-green"></i>&nbsp;&nbsp;Summary and detailed sheets</li>
<li class="feature-list-item"><i class="fa fa-star color-green"></i>&nbsp;&nbsp;Customize with your own 'recipe' of filters.</li>
                                </ul>
                        </div>
                           
                       <div class="feature-list-wrap col-xs-6">
                            	<ul class="feature-list">
                                <br><br>   
								 <a href="https://youtu.be/naMjj5oJOGk" target="_blank" class="btn btn-success"><i class="fa fa-video-camera"></i>&nbsp;&nbsp;Video (Uploading your TRACKMASTER FILE)</a>
                                </ul>
                        </div>
                    
                        <div style="clear:both;"></div>
                    
                </div><!-- close col-md-7 -->     
            </div><!-- /row -->
        </div><!-- /container -->
    </div><!-- /purchase -->

    <div class="container content">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1><strong>HOW IT WORKS</strong></h1>
            </div>
        
        <div class="col-md-4">
            <div class="service">
                <i class="service-icon"><img src="img/step1.png" alt="Step One" /></i>
                <div class="desc">
                    <h4>Create Account</h4>
                    <p><a href="register.php">Register for free</a> to purchase our credit package option, or take it slow and use our <strong>$2.50</strong> per credit option.  That's about the cost of a cup of coffee, which quite honestly is probably what we will use it for.  Thanks for the buzz!</p>
                    <p><a href='register.php' class='btn btn-success'><span class='glyphicon glyphicon-user'></span>&nbsp;&nbsp;Register Now!</a></p>
               
			   </div>
				
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="service">
                <!--<i class="fa fa-money service-icon"></i>-->
                <i class="service-icon"><img src="img/step2.png" alt="Step Two" /></i>
                <div class="desc">
                    <h4>Get Data File</h4>
                    <p><a href="https://www.trackmaster.com/cgi-bin/register.cgi?tpp" target="_blank">Sign up at TrackMaster</a>.  Navigate to TrackMaster Past Performances Downloads, choose a track, choose a date, and get the Data File (XML).  Our service requires the file to be in .zip or .xml format.</p>
                    <p><a href="http://new.trackmaster.com/products/tpp/download" target="_blank" class="btn btn-success"><span class="glyphicon glyphicon-new-window"></span>&nbsp;&nbsp;Visit Trackmaster</a></p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="service">
                <!--<i class="fa fa-cogs service-icon"></i>-->
                <i class="service-icon"><img src="img/step3.png" alt="Step Three" /></i>
                <div class="desc">
                    <h4>Process Data File</h4>
                    <p>Purchase single credits or our credit package, and then simply browse, select, and upload your Trackmaster data file to process your custom Thoroughwiz strategy sheets. Check out our sample sheets below!</p>
                    <form action='product_free_sample.php' method='post' enctype='multipart/form-data'>
                    <button type="submit" class='btn btn-success'><span class="glyphicon glyphicon-gift"></span>&nbsp;&nbsp;View Free Samples!</button>
                    </form>          
                </div>
            </div>
        </div>
        
        </div><!-- /row -->
    </div><!-- /container -->

    <!--=== Free Demo ===-->
    <!--<div class="purchase">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-1 animated fadeInLeft">
                    <p>Would you like to take our service for a test drive? Click the "Try For Free" button on the right to step through the process of submitting a TrackMaster Data File to be processed by our unique algorithm.</p>
                </div>
                <div class="col-md-4 btn-buy animated fadeInRight promo">
                    <form action='access_sample.php' method='post'>
                    <button type="submit" class="btn btn-success btn-lg"><i class="fa fa-thumbs-up"></i>&nbsp;&nbsp;Try For Free!</button>
                    </form>
                </div>
            </div>
        </div>
    </div>-->
    
    <div class="title-box">
        <p>Ready to do this?  Create your account, get your data file, and process your data.</p>
        <p><img alt="stripe payments" border="0" src="img/stripe-payments.png" class="img-responsive pp" /></p>
        <p><a href="https://stripe.com/" target="_blank" class="btn btn-info"><span class="glyphicon glyphicon-new-window"></span>&nbsp;&nbsp;What is Stripe?</a></p>
    </div>
    
    <!--<center>
    
        <a class="twitter-timeline" href="https://twitter.com/ThoroughWiz" data-widget-id="605769625473654785">Tweets by @ThoroughWiz</a>
        <script>    
        !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");
        </script>
    
    </center>-->
    
    
    <!-- End Like Block -->
    
    <hr>
    <?php include("footer.php"); ?>
    <?php include("modals.php"); ?>
  
</div><!--/wrapper-->

<script>
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
        $("#logInDiv").dialog("close");
    });

    // submit the form
    $("#homepage-login-form").on("submit", function (e) {

        // Stop the browser from submitting the form.
        e.preventDefault();

        // Get the form.
        var form = $("#homepage-login-form");

        // Get the messages div.
        var formMessages = $("#form-messages");
        var logInGood = $("#logInGood");

        // Serialize the form data.
        var formData = $(form).serialize();

        $.ajax({
          url: $(form).attr("action"),
          type: "POST",
          data: formData,
          dataType: "json",
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
                setTimeout(function(){ document.location.href = "account.php"; }, 3000);
              }else{
                $(formMessages).html(data[0]);
                $(formMessages).dialog({
                    autoOpen: false,
                    modal: true,
                    buttons: [{ 
                         text: "Ok", click: function() { 
                            $( this ).dialog( "close" );
                         } 
                    }]
                });
                $(formMessages).dialog("open");
              }
          },
          error: function(xhr, desc, err) {
                $(formMessages).html("The system has encountered an error");
                $(formMessages).dialog({
                    autoOpen: false,
                    modal: true,
                    buttons: [{ 
                         text: "Ok", click: function() { 
                            $( this ).dialog( "close" );
                         } 
                    }]
                });
                $(formMessages).dialog("open");
          }
        });
    })    
});    
</script>
    
</body>
</html>
