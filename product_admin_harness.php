<?php 
require_once("models/config.php");
if(!securePage($_SERVER['PHP_SELF'])){die();}
include("scripts/switch_up.php");
// add sheet to user sheets table for later access (will expire in 96 hours)
//createSheet($loggedInUser->user_id, $_SESSION['data'], $trackloc, $_SESSION['racedate']);
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
        </div>
        <div class="row">
          <div class="col-lg-12" style="text-align:center;">
            <form action='scripts/summary_harness.php' method='post' enctype='multipart/form-data' target='_blank'>
              <?php echo "<input type='hidden' name='card'  value='" .$_SESSION['data']. "'><br>"; ?>
              <button type="submit" class="btn btn-success btn-u-md"><i class="fa fa-file-text-o"></i>&nbsp;&nbsp;Summary Harness Sheet</button>
            </form>
			<br>
			          <div class="col-lg-12" style="text-align:center;">
            <form action='scripts/details_horse_harness.php' method='post' enctype='multipart/form-data' target='_blank'>
              <?php echo "<input type='hidden' name='card'  value='" .$_SESSION['data']. "'><br>"; ?>
              <button type="submit" class="btn btn-success btn-u-md"><i class="fa fa-file-text-o"></i>&nbsp;&nbsp;Detail Horse</button>
            </form>
			<br>
                          <div class="col-lg-12" style="text-align:center;">
            <form action='scripts/details_race_harness.php' method='post' enctype='multipart/form-data' target='_blank'>
              <?php echo "<input type='hidden' name='card'  value='" .$_SESSION['data']. "'><br>"; ?>
              <button type="submit" class="btn btn-success btn-u-md"><i class="fa fa-file-text-o"></i>&nbsp;&nbsp;Detail Race</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--/container-->
  <!--=== End Content Part ===-->
  <?php include("footer.php"); ?>
        <?php include("modals.php"); ?>
</div><!--/wrapper-->
</body>
</html>