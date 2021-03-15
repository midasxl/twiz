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
        <p class="success" style="display:none;color:#090"><i class="fa fa-check-square-o"></i>Thank you for your correspondence.  Your message has been sent successfully.</p>
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
        <p>Simple.  We have an obsession with the horse racing industry.  We also really dig complicated algorithms.  And we need some kind of justification for consuming massive amounts of coffee.  So, that's it.  Horses and coffee.  And math.</p>
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
</body>
</html>