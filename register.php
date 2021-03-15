<?php
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
// if user is already logged in, why would they want to go to the register page?
if(isUserLoggedIn()) { header("Location: account.php"); die(); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Handicapping horse racing Thoroughwiz Member Registration</title>
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
      <h1 class="pull-left">New Member Registration</h1>
      <ul class="pull-right breadcrumb">
        <li><a href="index.php">Home</a></li>
        <li class="active">New Member Registration</li>
      </ul>
    </div>
  </div>
  <!--/breadcrumbs-->
  <!--=== End Breadcrumbs ===-->
  <!--=== Content Part ===-->
  <div class="container content">
    <div class="row">
    <div class="col-md-6 mobile-sep">
      <h2 class="text-center" style="color:#303030;">Premium content at an affordable price!</h2>
      <div class="text-center">
        <div style="color:#959595;font-size:16px;" class="col-md-10 col-md-offset-1">
        <p>This is the first step in the required FREE registration process.  Please take a moment to read our <a href='terms.php'>Terms of Service</a> and <a href='privacy.php'>Privacy Policy</a>.</p>
        <div class="text-center mobile-sep">
          <div class="col-md-12"><p>A Thoroughwiz membership brings top-notch service from one of the handicapping world's leading minds, and boasts a rich user experience from start to finish.</p>
          </div>
          <span style="color:#959595;">Registration with Thoroughwiz is free!</span><br>
          <span style="color:#959595;">Single credit/track purchase is $5.00</span><br>
          <span style="color:#959595;">10 Credit Package is $25.00</span><br>
          <span style="color:#959595;">$50.00 monthly unlimited access!</span>
          <!--<span><a href="faq.php">FAQ</a>&nbsp;|&nbsp;<a href="terms.php">TERMS</a></span>--> 
          </div>
          <?php echo resultBlock($errors,$successes); ?>
          <!--<div id="form-messages" title="Thoroughwiz says..." style="text-align:center;padding:5px;"></div>-->
        </div>
      </div>
    </div>
    <!--/col-md-6-->
    <div class="col-md-6">
    <h3>Registration Information</h3>
    <form id='user-register-form' name='newUser' action='user-register.php' method='post'>
    <!-- <label>First Name:</label>
    <div class="input-group margin-bottom-20">
            <span class="input-group-addon"><i class="fa fa-user"></i></span>
            <input type="text" name="firstname" id="firstname" class="form-control" required />
    </div>                    
    <label>Last Name:</label>
    <div class="input-group margin-bottom-20">
        <span class="input-group-addon"><i class="fa fa-user"></i></span>
        <input type="text" name="lastname" id="lastname" class="form-control" required />
    </div>
    <label>User Name:</label>
    <div class="input-group margin-bottom-20">
            <span class="input-group-addon"><i class="fa fa-user"></i></span>
            <input type="text" name="username" id="username" class="form-control" required />
    </div>                    
    <label>Display Name:</label>
    <div class="input-group margin-bottom-20">
        <span class="input-group-addon"><i class="fa fa-user"></i></span>
        <input type="text" name="displayname" id="displayname" class="form-control" required />
    </div> -->
    <label>Email Address:</label>
    <div class="input-group margin-bottom-20">
            <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
            <input type="text" name="email" id="email" class="form-control" required />
    </div> 
    <label>Password:</label>
    <div class="input-group margin-bottom-20">
            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
            <input type="password" name="password" id="password" class="form-control" required />
    </div>                    
    <label>Confirm Password:</label>
    <div class="input-group margin-bottom-20">
        <span class="input-group-addon"><i class="fa fa-key"></i></span>
        <input type="password" name="passwordc" id="passwordc" class="form-control" required />
    </div>
    <label>Security Code (enter code below):</label><br>
    <img src='models/captcha.php'>
    <div class="input-group margin-bottom-20">    
            <span class="input-group-addon"><i class="fa fa-key"></i></span>
            <input type="text" name="captcha" id="captcha" class="form-control" required />
    </div> 
    <hr>
      <p><input type='checkbox' name='agree' id='twiz-agree' />
      &nbsp;I have read and agree to the Thoroughwiz <a href='terms.php' class='color-green' target='_blank'>Terms of Service</a>&nbsp;and <a href='privacy.php' class='color-green' target='_blank'>Privacy Policy</a>.</p>
    <button type='submit' class='btn btn-success pull-right'><span class='glyphicon glyphicon-user'></span>&nbsp;&nbsp;Register</button>
    </form>
    
    </div><!--/col-md-6-->
    </div><!--/row-->
    <hr>
    <div class="title-box">
        <p><img alt="stripe payments" border="0" src="img/stripe-payments.png" class="img-responsive pp" /></p>
        <p><a href="https://stripe.com/" target="_blank" class="btn btn-info"><span class="glyphicon glyphicon-new-window"></span>&nbsp;&nbsp;What is Stripe?</a></p>
    </div>
    </div><!--/container-->
  <!--=== End Content Part ===-->
  	<?php include("modals.php"); ?>
	<?php include("footer.php"); ?>
</div><!--/wrapper-->
</body>
</html>