<?php 
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
include("scripts/switch_up.php");
// add sheet to user sheets table for later access (will expire in 96 hours)
createSheet($loggedInUser->user_id, $_SESSION['data'], $trackloc, $_SESSION['racedate']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Handicapping horse racing Thoroughwiz Sheets</title>
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
      <div class="col-md-3">
        <!-- Contact Us -->
        <div class="who margin-bottom-30">
          <div class="headline">
            <h2>Thank You!</h2>
          </div>
        </div>
      </div>
      <!--/col-md-3-->
      <div class="col-md-9">
        <!-- Our Services -->
        <div class="headline">
          <h2>Data Submission Complete</h2>
        </div>
          <div>          
                <h3>Links to data sheets for</h3>
                <?php include("scripts/switch_up.php"); ?>
                <h4><?php echo $trackloc; ?></h4><!--- need to write this to database --->
                <?php $race_date = date('m-d-Y', strtotime($_SESSION['racedate'])); ?>
                <h4><?php echo $race_date; ?></h4>
          </div>
            <form class="sheet-form" action='scripts/test.php' method='post' enctype='multipart/form-data' target='_blank'>
              <?php echo "<input type='hidden' name='card' value='" .$_SESSION['data']. "'><br>"; ?>
              <button type="submit" class="btn btn-primary btn-u-md"><i class="fa fa-file-text-o"></i>&nbsp;&nbsp;Scratch Sheet</button>
            </form>
            <form class="sheet-form" action='scripts/summary.php' method='post' enctype='multipart/form-data' target='_blank'>
              <?php echo "<input type='hidden' name='card' value='" .$_SESSION['data']. "'><br>"; ?>
              <button type="submit" class="btn btn-success btn-u-md"><i class="fa fa-file-text-o"></i>&nbsp;&nbsp;Summary Sheet</button>
            </form>
            <form class="sheet-form" action='scripts/details_horse.php' method='post' enctype='multipart/form-data' target='_blank'>
              <?php echo "<input type='hidden' name='card' value='" .$_SESSION['data']. "'><br>"; ?>
              <button type="submit" class="btn btn-danger btn-u-md"><i class="fa fa-file-text-o"></i>&nbsp;&nbsp;Details by Horse</button>
            </form>
            <form class="sheet-form" action='scripts/details_race.php' method='post' enctype='multipart/form-data' target='_blank'>
              <?php echo "<input type='hidden' name='card' value='" .$_SESSION['data']. "'><br>"; ?>
              <button type="submit" class="btn btn-warning btn-u-md"><i class="fa fa-file-text-o"></i>&nbsp;&nbsp;Details by Race</button>
            </form>          
        
      </div><!--/col-md-9-->
    </div><!--/row-->
  </div><!--/container-->
  <!--=== End Content Part ===-->
    
  <?php include("modals.php"); ?>
  <?php include("footer.php"); ?>
</div><!--/wrapper-->
</body>
</html>