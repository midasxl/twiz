<?php
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
if(isUserLoggedIn()) { header("Location: account.php"); die(); }

//User has slected the deny link in the email and therefore denied the request to change their password
if(!empty($_GET["deny"]))
{
	$token = trim($_GET["deny"]);
    // negation unary operator; it flips the boolean value of a value. Same as 'validatActivationToken($token,TRUE) == false'
	if($token == "" || !validateActivationToken($token,TRUE))// if token is empty or function returns false
	{
		$errors[] = lang("FORGOTPASS_INVALID_TOKEN");
	}
	else
	{
		$userdetails = fetchUserDetails(NULL,$token);
		if(!flagLostPasswordRequest($userdetails["id"],0))
		{
			$errors[] = lang("SQL_ERROR");
		}
			if(!flagPasswordReset($userdetails["id"],0))
			{
				$errors[] = lang("SQL_ERROR");
			}
		else {
			$successes[] = lang("FORGOTPASS_REQUEST_CANNED");
		}
	}
}else{
header("Location: index.php"); die();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Thoroughwiz | Deny Password Page</title>
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
      <h1 class="pull-left">Thoroughwiz Deny Password Request</h1>
      <ul class="pull-right breadcrumb">
        <li><a href="index.php">Home</a></li>
        <li class="active">Deny Password Request</li>
      </ul>
    </div>
  </div>
  <!--/breadcrumbs-->
  <!--=== End Breadcrumbs ===-->
  <!--=== Content Part ===-->
  <div class="container content">
        <div class="row">
                <div class="col-md-6" style="margin-bottom:55px;">
                    <!--<img style="float:left;" src="img/cancel-email.png" alt="send email icon" class="img-responsive"/>-->
                    <h3 style="position:relative;left:20px;">The lost password request has been cancelled</h3>
                    <p style="position:relative;left:20px;">If you did not initiate this lost password request and feel this may be a malicious attempt to access your account, please contact us for further guidance.</p>
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
</body>
</html>
