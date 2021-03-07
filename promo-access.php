<?php 
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Thoroughwiz | Submit Data...</title>
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
      <h1 class="pull-left">Kentucky Derby Promotion</h1>
      <ul class="pull-right breadcrumb">
        <li><a href="index.php">Home</a></li>
        <li class="active">Kentucky Derby Promotion</li>
      </ul>
    </div>
    <!--/container-->
  </div>
  <!--/breadcrumbs-->
  <!--=== End Breadcrumbs ===-->
  <!--=== Content Part ===-->
  <div class="container content">

    <div class="row">
      <div class="col-md-3">
        <!-- Contact Us -->
        <div class="who margin-bottom-30">
          <div class="headline">
            <h2>May 1-7, 2017</h2>
          </div>
            <p>Beginning May 1st through the end of the Kentucky Derby on May 7th, enjoy free data submissions!</p>
            <img src="assets/img/promo/kderby-promo.jpg" alt="kentucky derby logo" class="img-responsive"/>  
        </div>
      </div>
      <!--/col-md-3-->
      <div class="col-md-9">
        <!-- Our Services -->
        <div class="headline">
          <h2>Free Data Submission</h2>
        </div>
        <div>
          <h3>Use the form below to submit your data file for processing.</h3>
          <p>Don't have your data file yet? <br />
            Click <a href="http://www.trackmaster.com/cgi-bin/axprodlist.cgi?tpp" target="_blank" class="color-green">HERE</a> to visit Trackmaster.</p>
        </div>
        <form action='scripts/promo-upload.php' method='post' id="productForm" enctype='multipart/form-data' class="sky-form">
                    
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
                    <input type="submit" class="btn btn-success btn-u-md" value="Submit Data" />
                    </div>
                    </div>
                     
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