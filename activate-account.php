<?php 
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
if(isUserLoggedIn()) { header("Location: account.php"); die();}

//Get token param from user email return
if(isset($_GET["token"]))
{	
	$token = $_GET["token"];
    if(!isset($token))
	{
		$errors[] = lang("FORGOTPASS_INVALID_TOKEN");
    }
	//Check for a valid token. Must exist and active must be = 0. only passing one parameter here $token.  
	// the function will therefore use the value of null for the $lostpass variable (this ties into a lost password request)
	else if(!validateActivationToken($token)) 
	{
		$errors[] = lang("ACCOUNT_TOKEN_NOT_FOUND");
	}
	else
	{ 
		if(!setUserActive($token))// update active from 0 to 1 on the record that matches the provided token
		{
			$errors[] = lang("SQL_ERROR");
        }
    }
}
else
{
	$errors[] = lang("FORGOTPASS_INVALID_TOKEN");
}
if(count($errors) == 0) {
	$successes[] = lang("ACCOUNT_ACTIVATION_COMPLETE");
}
ob_end_flush();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Thoroughwiz | Activate Account Page</title>
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
      <h1 class="pull-left">Thoroughwiz Activate Account</h1>
      <ul class="pull-right breadcrumb">
        <li><a href="index.php">Home</a></li>
        <li class="active">Activate Account</li>
      </ul>
    </div>
  </div>
  <!--/breadcrumbs-->
  <!--=== End Breadcrumbs ===-->
  <!--=== Content Part ===-->
  <div class="container content">
    <div class="row">
    <div class="col-md-12">
    <img style="float:left;" src="img/tick_48.png" alt="checkmark icon" class="img-responsive" />
     <h2 style="position:relative;left:10px;">Your account is now active!</h2> 
     <hr>
     </div>
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
        <!--<div id="form-messages" title="Thoroughwiz says..." style="text-align:center;padding:5px;"></div>
        <div id="logInDiv" title="Logging In" style="display:none;text-align:center;padding:5px;">
        	<img src="img/loading11.gif" alt="loading" />
        </div>
        <div id="logInGood" title="You're In!" style="text-align:center;padding:5px;"></div>-->
    </div>
      <!--/col-md-4-->
      <div class="col-md-1 mobile-sep">
      </div>
      <div class="col-md-3 mobile-sep">
        
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