<?php
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
if(isUserLoggedIn()) { header("Location: account.php"); die(); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Thoroughwiz | Member Access Page</title>
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
      <h1 class="pull-left">Thoroughwiz Member Access</h1>
      <ul class="pull-right breadcrumb">
        <li><a href="index.php">Home</a></li>
        <li class="active">Member Access</li>
      </ul>
    </div>
  </div>
  <!--/breadcrumbs-->
  <!--=== End Breadcrumbs ===-->
  <!--=== Content Part ===-->
  <div class="container content">
    <div class="row">
            
    <div class="col-md-4">
        <h3>Please provide credentials</h3>
		 <form id="login-form" name="login" action="user-login.php" method="post"> 
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
        </form>
    </div>
      <!--/col-md-4-->
      <div class="col-md-1 mobile-sep"></div>
      <div class="col-md-3 mobile-sep">
        <h3>Not a member?</h3>
			<a href="register.php" class="btn btn-success"><span class='glyphicon glyphicon-user'></span>&nbsp;&nbsp;Register Now!</a>
      </div>
      <!--/col-md-3-->
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