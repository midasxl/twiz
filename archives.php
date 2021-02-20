<?php
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Handicapping horse racing Thoroughwiz Archives</title>
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
      <h1 class="pull-left">Archives</h1>
      <ul class="pull-right breadcrumb">
        <li><a href="index.php">Home</a></li>
        <li class="active">Archives</li>
      </ul>
    </div>
  </div>
  <!--/breadcrumbs-->
  <!--=== End Breadcrumbs ===-->
  <!--=== Content Part ===-->
  <div class="container content">
    <div class="row">
      <div class="col-md-8">
        <!-- General Questions -->
        <div class="headline">
          <h2>Archives</h2>
        </div>
        <div>
<?php

// Main function file
include("models/php_file_tree.php");
            
echo php_file_tree("/home/sparky/archives/", "javascript:alert('You clicked on [link]');");

?>
        </div>
        <!-- End Other Questions -->
      </div>
      <!--/col-md-9-->
      <div class="col-md-4">
        <!-- Contacts -->
        <div class="headline">
          <h2>Company Data</h2>
        </div>
        <ul class="list-unstyled who margin-bottom-30">
          <!--<li><i class="fa fa-users"></i>Partnership: Wood/Husband-Wood</li>
          <li><i class="fa fa-home"></i>Horseheads, NY 14845</li>-->
          <li><a href="mailto:support@thoroughwiz.com?subject=From the contact page"><i class="fa fa-envelope"></i>support@thoroughwiz.com</a></li>
          <li><a href="https://www.thoroughwiz.com"><i class="fa fa-globe"></i>https://www.thoroughwiz.com</a></li>
        </ul>
        <!-- Why we do this? -->
        <div class="headline">
          <h2>Why do we do this?</h2>
        </div>
        <p>Simple.  We have an obsession with the horse racing industry.  We also really dig complicated algorithms.  And we need some kind of justification for consuming massive amounts of coffee.  So, that's it.  Horses and coffee.  And math.</p>
        <!-- Social -->
        <div class="magazine-sb-social margin-bottom-20">
          <div class="headline headline-md">
            <h2>Social Networks</h2>
          </div>
          <ul class="social-icons social-icons-color">
            <li><a href="https://twitter.com/thoroughwiz" data-original-title="Twitter" class="social_twitter" target="_blank"></a></li>
                    	<li><a href="https://facebook.com/thoroughwizsheets" data-original-title="Facebook" class="social_facebook" target="_blank"></a></li>
                        <li><a href="https://www.youtube.com/c/thoroughwizsheets" data-original-title="Youtube" class="social_youtube" target="_blank"></a></li>
            </ul>
          <div class="clearfix"></div>
        </div>
        <!-- End Social -->
      </div>
      <!--/col-md-3-->
    </div>
    <!--/row-->
  </div>
  <!--/container-->
  <!--=== End Content Part ===-->
  <?php include("footer.php"); ?>
</div><!--/wrapper-->
</body>
</html>