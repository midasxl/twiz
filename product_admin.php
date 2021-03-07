<?php 
require_once("models/config.php");
if(!securePage($_SERVER['PHP_SELF'])){die();}
include("scripts/switch_up.php");
// add sheet to user sheets table for later access (will expire in 96 hours)
createSheet($loggedInUser->user_id, $_SESSION['data'], $trackloc, $_SESSION['racedate']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Thoroughwiz | Thoroughwiz Data Sheets for Admin</title>
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
    
  <?php include("modals.php"); ?>
  <?php include("footer.php"); ?>
</div><!--/wrapper-->

</body>
</html>
