<?php 
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
/* this is the page that admins use to process sheets */
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Thoroughwiz | Welcome Administrator...</title>
<!-- Meta Data -->
<?php include("meta.php"); ?>
<!-- CSS Import -->
<?php include("style_block.php"); ?>
<!-- CSS page specific -->
<link rel="stylesheet" href="assets/plugins/sky-forms/version-2.0.1/css/custom-sky-forms.css">
</head>
<body>
<div class="wrapper">
  <?php include("header.php"); ?>
  <!--=== Breadcrumbs ===-->
  <div class="breadcrumbs">
    <div class="container">
      <h1 class="pull-left"><?php echo "Welcome $loggedInUser->email!" ?></h1>
      <ul class="pull-right breadcrumb">
        <li><a href="index.php">Home</a></li>
        <li class="active">Welcome Administrator</li>
      </ul>
    </div>
  </div>
  <!--/breadcrumbs-->
  <!--=== End Breadcrumbs ===-->
  <!--=== Content Part ===-->
  <div class="container content">
  
	<?php include("assets/snippets/left-nav.php"); ?>

    <div class="row">
      <div class="col-md-3">
        <div class="margin-bottom-30">
          <div class="headline">
            <h2>Welcome Administrator</h2>
          </div>
          <p>Be sure to lock up when you're done.</p>
        </div>
        <!-- Contact Us -->
        <!--<div class="who margin-bottom-30">

                    <div class="headline"><h2>Contact Us</h2></div>

                    <p>Vero facilis est etenim a feugiat cupiditate non quos etrerum facilis.</p>

                    <ul class="list-unstyled">

                        <li><a href="#"><i class="fa fa-home"></i>5B amus ED554, New York, US</a></li>

                        <li><a href="#"><i class="fa fa-envelope"></i>infp@example.com</a></li>

                        <li><a href="#"><i class="fa fa-phone"></i>1(222) 5x86 x97x</a></li>

                        <li><a href="#"><i class="fa fa-globe"></i>http://www.example.com</a></li>

                    </ul>

                </div>-->
      </div>
      <!--/col-md-3-->
      <div class="col-md-9">
        <!-- Our Services -->
        <div class="headline">
          <h2>Harness Data Submission</h2>
        </div>
        <div>
          <h3>Use the form below to submit your XML Data from Trackmaster for processing.</h3>
          <p>Don't have the data file yet? <br />
            Click <a href="http://www.trackmaster.com/cgi-bin/axprodlist.cgi?tpp" target="_blank" class="color-green">HERE</a> to visit Trackmaster.</p>
        </div>
        <form action='scripts/upload_admin_harness.php' method='post' id="productForm" enctype='multipart/form-data' class="sky-form">
                    
                    <fieldset style="background-color:#585f69;">
                    
                        <section>
                            <label style="color:#CCC;" class="label">File input</label>
                            <label for="file" class="input input-file">
                                <div class="button"><input type="file" id="filefield" name="myfile" onChange="this.parentNode.nextSibling.value = this.value" required>Browse</div><input type="text" readonly>
                            </label>
                        </section>                  
                    </fieldset>   
                    
                    <div class="row" style="padding:8px;">
                    <div class="col-lg-8"><input type="checkbox" id="twiz-agree">&nbsp;I have read and agree to the Thoroughwiz <a href="terms.php" class="color-green" target="_blank">Terms of Service</a></div>
					<div class="col-lg-4 text-right">
                    <button type="submit" class="btn btn-success btn-u-md"><i class="fa fa-arrow-circle-right"></i>&nbsp;&nbsp;Submit Data</button>
                    </div>
                    </div>
                     
                </form>
      </div>
      <!--/col-md-9-->
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