<?php 
require_once("models/config.php");
if(!securePage($_SERVER['PHP_SELF'])){die();}
include("scripts/switch_up.php");
if(isset($_SESSION['data']) && !empty($_SESSION['data'])) {//if session data is set and not empty
    if ($loggedInUser->checkCredits()){ // if user has 1 or more credits...
            createSheet($loggedInUser->user_id, $_SESSION['data'], $trackloc, $_SESSION['racedate']);
            removeCredit(1, $loggedInUser->user_id); // decrement credit tally and allow access to page
    }
}else{// session data is empty or not set, kill
    header("Location: account.php"); die();
}
/* legacy below */
/* if(!isset($_SESSION["single-purchase-flag"]) || (isset($_SESSION["single-purchase-flag"]) && $_SESSION['single-purchase-flag'] != "TRUE")){
	header("location:http://www.thoroughwiz.com/account.php");
	exit();
}elseif(isset($_SESSION["single-purchase-flag"]) && $_SESSION['single-purchase-flag'] == "TRUE"){
	if ($loggedInUser->checkCredits()){ // if user has 1 or more credits...
		createSheet($loggedInUser->user_id, $_SESSION['data']);
		removeCredit(1, $loggedInUser->user_id); // decrement credit tally and allow access to page
	}
} */
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Thoroughwiz | Thoroughwiz Data Sheets</title>
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
      <h1 class="pull-left">Thoroughwiz Data Sheets</h1>
      <ul class="pull-right breadcrumb">
        <li><a href="index.php">Home</a></li>
        <li class="active">Thoroughwiz Data Sheets</li>
      </ul>
    </div>
    <!--/container-->
  </div>
  <!--/breadcrumbs-->
  <!--=== End Breadcrumbs ===-->
  <!--=== Content Part ===-->
  <div class="container content">
  
	<?php include("assets/snippets/left-nav.php"); ?>

    <div class="row">
      <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
        <div class="reg-header">
          <h2>Data Processing Complete!</h2>
          <?php include("scripts/switch_up.php"); ?>
          <h4><?php echo $trackloc; ?></h4>
          <?php $race_date = date('m-d-Y', strtotime($_SESSION['racedate'])); ?>
          <h4><?php echo $race_date; ?></h4>
          <h5>Sheets are available on your account home page and will expire in 4 days!</h5>
            <a href="account.php" class="btn btn-success"><i class="fa fa-home"></i>&nbsp;&nbsp;Go Home!</a>
        </div>        
      </div>
    </div>
  </div><!--/container-->
  <!--=== End Content Part ===-->
  <?php include("footer.php"); ?>
    <?php include("modals.php"); ?>
</div><!--/wrapper-->
<?php
	$_SESSION['data'] = "";
	//$_SESSION['single-purchase-flag'] = "FALSE";
	if ($loggedInUser->checkCredits()){ // if user still has 1 or more credits, keep quickie role...
		// return true;
	}else{
		removePermission(4, $loggedInUser->user_id); // no more credits; remove quickie role...
	}
?>
</body>
</html>