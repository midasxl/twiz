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
  	<?php include("modals.php"); ?>
	<?php include("footer.php"); ?>
</div><!--/wrapper-->
</body>
</html>