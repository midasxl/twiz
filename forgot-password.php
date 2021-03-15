<?php
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
if(isUserLoggedIn()) { header("Location: account.php"); die(); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Thoroughwiz | Forgot Password</title>
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
      <h1 class="pull-left">Forgot Password</h1>
      <ul class="pull-right breadcrumb">
        <li><a href="index.php">Home</a></li>
        <li class="active">Forgot Password</li>
      </ul>
    </div>
  </div>
  <!--/breadcrumbs-->
  <!--=== End Breadcrumbs ===-->
  <!--=== Content Part ===-->
  <div class="container content">
    <div class="row">
      <div class="col-md-3">
        <h3>Yeah, it happens.</h3>
			<p>Provide your valid registered email address and we will send you instructions to reset your password.</p>
      </div>
      <!--/col-md-3-->
    <div class="col-md-4">
        <h3>Please provide credentials</h3>
		<form id="lost-pass-form" name="newLostPass" action="user-forgot-password.php" method="post"> 
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