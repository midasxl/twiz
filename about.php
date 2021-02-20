<?php
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Handicapping horse racing Thoroughwiz About Us</title>
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
      <h1 class="pull-left">About Us</h1>
      <ul class="pull-right breadcrumb">
        <li><a href="index.php">Home</a></li>
        <li class="active">About Us</li>
      </ul>
    </div>
  </div>
  <!--/breadcrumbs-->
  <!--=== End Breadcrumbs ===-->
  <!--=== Content Part ===-->
  <div class="container content">
    <div class="row portfolio-item margin-bottom-50">
      <!-- Content Info -->
      <div class="col-md-6 md-margin-bottom-40">
        <h2>Thoroughwiz Company Profile</h2>
        <p>Our goal is simple: to provide you with unparalleled strategical race data in an interactive and easy-to-use format to assist you in making successful wagering  decisions at the track.  Thoroughwiz is a premiere horse racing sheet which uses a unique statistical algorithm to produce a special ranking called the <strong>TWIZ</strong> number. Our analysts are highly proficient in the art of handicapping, and have developed and refined a superior method of predicting and quantifying the results of a horse race.</p>
        <p>By registering FOR FREE, and purchasing credits to upload your Trackmaster data sheets you will be provided with a unique handicapping tool to help take much of the guesswork out of your picks.  Whatever you decide to utilize as your handicapping system, be it exclusive use of our Thoroughwiz data sheets, or as a complement to your current handicapping strategy, our service will prove to be a positive addition to your handicapping arsenal.</p>
        <div class="row portfolio-item1">
          <div class="col-xs-10">
            <ul class="list-unstyled">
              <li><i class="fa fa-star color-green"></i>&nbsp;&nbsp;Uses Exclusive Equibase Speed Figure</li>
              <li><i class="fa fa-star color-green"></i>&nbsp;&nbsp;Easy to use and easy to understand.</li>
              <li><i class="fa fa-star color-green"></i>&nbsp;&nbsp;Based on Trackmaster Past Performance data.</li>
              <li><i class="fa fa-star color-green"></i>&nbsp;&nbsp;Interactive and sortable wagering data.</li>
              <li><i class="fa fa-star color-green"></i>&nbsp;&nbsp;Service includes a summary and detailed sheet.</li>
            </ul>
          </div>
        </div>
        
        <div class="row portfolio-item1">
          <div class="col-xs-10">
            <h2>Thoroughwiz Product Pricing</h2>
        		<p>$2.50 per credit (one credit buys one track sheet)</p>
        		<p>$12.50 for a 10 credit package (half price of 10 single purchases)</p>
        		<p>*Coming Soon: Unlimited daily access*</p>
          </div>
        </div>
        
      </div>
      <!-- End Content Info -->
      <!-- Carousel -->
        <div class="col-md-6">
            <div class="carousel slide carousel-v1" id="myCarousel">
                <div class="carousel-inner">
                    <div class="item active"> <img alt="" src="assets/img/main/twiz-1.jpg">
                        <div class="carousel-caption">
                            <p>Exclusive use of Trackmaster XML data.</p>
                        </div>
                    </div>
                    <div class="item"> <img alt="" src="assets/img/main/twiz-2.jpg">
                        <div class="carousel-caption">
                            <p>Fully interactive Thoroughwiz data sheets.</p>
                        </div>
                    </div>
                    <div class="item"> <img alt="" src="assets/img/main/twiz-3.jpg">
                        <div class="carousel-caption">
                            <p>Responsive Site design for all major devices.</p>
                        </div>
                    </div>
                </div>
                <div class="carousel-arrow"> <a data-slide="prev" href="#myCarousel" class="left carousel-control"> <i class="fa fa-angle-left"></i> </a> <a data-slide="next" href="#myCarousel" class="right carousel-control"> <i class="fa fa-angle-right"></i> </a>
                </div>
            </div>
            <div class="margin-bottom-20 clearfix"></div>
            <h3>How to upload a Trackmaster data file <span class="label label-info">New!</span></h3>
            <div class="embed-responsive embed-responsive-16by9">
                <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/naMjj5oJOGk" allowfullscreen></iframe>
            </div>
        </div>
      <!-- End Carousel -->
    </div>
    <!--/row-->
    <div class="tag-box tag-box-v2">
      <p style="margin-bottom:10px;">So what do you think?  Are you ready?  Come on, give us a try, you won't be disappointed!</p>
      <a href="register.php" class="btn btn-success"><span class='glyphicon glyphicon-user'></span>&nbsp;&nbsp;Register Now!</a> 
    </div>
    <div class="margin-bottom-20 clearfix"></div>
  </div>
  <!--/container-->
  <!--=== End Content Part ===-->
  <?php include("footer.php"); ?>
    <?php include("modals.php"); ?>
</div><!--/wrapper-->
</body>
</html>