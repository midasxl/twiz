<?php
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Handicapping horse racing Thoroughwiz FAQ</title>
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
      <h1 class="pull-left">FAQs</h1>
      <ul class="pull-right breadcrumb">
        <li><a href="index.php">Home</a></li>
        <li class="active">FAQ</li>
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
          <h2>General Questions</h2>
        </div>
        <div class="panel-group acc-v1 margin-bottom-40" id="accordion">
            
          <div class="panel panel-default">
            <div class="panel-heading">
              <h4 class="panel-title"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne"> 1. How does your service work? </a> </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse in">
              <div class="panel-body"><p>It's easy. If you haven't already, navigate to and sign up for <a href="https://www.trackmaster.com/products/tpp/download" target="_blank">TrackMaster Past Performance Downloads</a>.  Select the Data File (XML) option, select a track, and select a date.  Then click the "Request Download" button to download Trackmaster Past Performances data for the TrackMaster fee of $1.50.  Remember where you saved it on your device.  You're going to need to submit that file to our processing service.</p>
              <p>Register FOR FREE with Thoroughwiz, and purchase credits for access to our processing engine. After successfully submitting your Trackmaster .zip or .xml file, you will receive links to Throughwiz Data Sheets featuring the <strong>TWIZrank</strong> to aid in your handicapping strategy. Your data sheets will be available for 4 days from the processing datetime. <a href="product_free_sample.php">View sample sheets</a>.</p>
              </div>
            </div>
          </div>
            
          <div class="panel panel-default">
            <div class="panel-heading">
              <h4 class="panel-title"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"> 2. How much does your service cost? </a> </h4>
            </div>
            <div id="collapseTwo" class="panel-collapse collapse">
              <div class="panel-body">
                <p>*Note: Trackmaster Charges $1.50 for the data file.</p>
                <p>We charge <strong>$2.50 per TWIZ credit</strong>.  This allows you to process the TrackMaster data file, and produce the Thoroughwiz data sheets.  One TWIZ credit equates to one data submission.</p>
                <p>We have a <strong>10 credit package that costs $12.50</strong> for a 50% savings over the single credit price!</p>
                <p>All credits you purchase will be available on your account home page.  They never expire, and can be used at your discretion.</p>
                <p>We will soon offer a <strong>daily subscription rate.</strong></p>
                <p>Our subscription package offers unlimited daily access to run your sheets.</p>
                <p>Your data sheets will be available for 4 days from the processing datetime.</p>
              </div>
            </div>
          </div>
            
        <div class="panel panel-default">
            <div class="panel-heading">
              <h4 class="panel-title"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseSeven"> 3. What file types will your service accept? </a> </h4>
            </div>
            <div id="collapseSeven" class="panel-collapse collapse">
              <div class="panel-body">Our processing engine will only accept Trackmaster .zip or .xml past performance data files.  You may upload either file type and our processing logic will do the rest.</div>
            </div>
          </div>
            
          <div class="panel panel-default">
            <div class="panel-heading">
              <h4 class="panel-title"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseThree"> 4. Will this site work on all devices? </a> </h4>
            </div>
            <div id="collapseThree" class="panel-collapse collapse">
              <div class="panel-body">
                <p>Our responsive design is optimized to perform on all current operating systems, user agents, and mobile devices including smart phones and tablets.</p>
                <p>Some things to consider:</p>
                <ul class="list-unstyled">
                  <li><i class="fa fa-check color-green"></i>&nbsp;&nbsp;The generated Thoroughwiz data sheets are best viewed on larger screens, simply because they will be easier to read.</li>
                  <li><i class="fa fa-check color-green"></i>&nbsp;&nbsp;If you use your mobile device to access TrackMaster to obtain the past performance data file, you must retrieve the file from your mobile device; it will not be available on your other devices. However using a service such as <a href="https://www.google.com/drive/" target="_blank">Google Drive</a> will solve this issue.</li>
                  <li><i class="fa fa-check color-green"></i>&nbsp;&nbsp;Some user agents (internet browsers) will not behave as expected with our application.  User agents are constantly being updated with new features and support while sometimes deprecating older support features.  We welcome any user experience reviews, both good and bad, in regards to browser experience.</li>
                </ul>
              </div>
            </div>
          </div>
            
          <div class="panel panel-default">
            <div class="panel-heading">
              <h4 class="panel-title"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseFour"> 5. How do I contact the site owners? </a> </h4>
            </div>
            <div id="collapseFour" class="panel-collapse collapse">
              <div class="panel-body">
                <p>You may use the following email address with your questions or concerns.</p>
                <ul class="list-unstyled">
                  <li>For general support: <a href="mailto:support@thoroughwiz.com?subject=General Support from FAQ">support@thoroughwiz.com</a></li>
                  <!--<li>For billing inquiries: <a href="mailto:billing@thoroughwiz.com?subject=Billing Support from FAQ">billing@thoroughwiz.com</a></li>
                  <li>For questions about the site: <a href="mailto:webmaster@thoroughwiz.com?subject=Website Support from FAQ">webmaster@thoroughwiz.com</a></li>-->
                </ul>
              </div>
            </div>
          </div>
            
          <div class="panel panel-default">
            <div class="panel-heading">
              <h4 class="panel-title"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseFive"> 6. What is your refund policy? </a> </h4>
            </div>
            <div id="collapseFive" class="panel-collapse collapse">
              <div class="panel-body">
                <p>Thoroughwiz WILL NOT provide a refund for any reason including termination of this Agreement except in the case of a customer being incorrectly billed due to an error that is the <strong>fault of Thoroughwiz</strong>.</p>
                <p>Thoroughwiz WILL provide a partial or full refund to the Customer's account for any product prior to its 4-day expiration for any of the following reasons:</p>
                <ul>
                  <li>The product purchased by the Customer contained data for the wrong track.</li>
                  <li>The product purchased by the Customer contained data for the wrong date.</li>
                  <li>The product contained incomplete data (except in the cases where this is explicitly notated).</li>
                  <li>The product's data was corrupted (either blank or not human-readable).</li>
                </ul>
                <p>For more information please read our <a href="terms.php">Terms of Service</a>.</p>
              </div>
            </div>
          </div>
            
          <!--<div class="panel panel-default">
            <div class="panel-heading">
              <h4 class="panel-title"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseSix"> 6. Do I need a Stripe account to use this service? </a> </h4>
            </div>
            <div id="collapseSix" class="panel-collapse collapse">
              <div class="panel-body"> No, you do not need a Stripe account to perform a transaction.  The stripe service can process all major credit cards without the need to sign up for a Stripe account. </div>
            </div>
          </div>-->
            
          <!--<div class="panel panel-default">

                        <div class="panel-heading">

                            <h4 class="panel-title">

                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseEight">

                                    8. How do we read your race cards?

                                </a>

                            </h4>

                        </div>

                        <div id="collapseEight" class="panel-collapse collapse">

                            <div class="panel-body">

                                <a href="#" data-toggle="modal" data-target="#legend">Click Here for Card Legend</a>

                            </div>

                        </div>

                    </div>-->
        </div>
        <div class="tag-box tag-box-v2">
          <p style="margin-bottom:10px;">So what do you think?  Are you ready?  Come on, give us a try, you won't be disappointed!</p>
          <a href="register.php" class="btn btn-success"><span class='glyphicon glyphicon-user'></span>&nbsp;&nbsp;Register Now!</a> 
        </div>
        <div class="margin-bottom-20 clearfix"></div>
          
        <div class="title-box">
        <p><img alt="stripe payments" border="0" src="img/stripe-payments.png" class="img-responsive pp" /></p>
        <p><a href="https://stripe.com/" target="_blank" class="btn btn-info"><span class="glyphicon glyphicon-new-window"></span>&nbsp;&nbsp;What is Stripe?</a></p>
    </div>
        <!--/acc-v1-->
        <!-- End General Questions -->
        <!-- Other Questions -->
        <!--<div class="headline"><h2>Other Questions</h2></div>

                <div class="panel-group acc-v1" id="accordion-1">

                    <div class="panel panel-default">

                        <div class="panel-heading">

                            <h4 class="panel-title">

                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-1" href="#collapse-One">

                                    Collapsible Group Item #1

                                </a>

                            </h4>

                        </div>

                        <div id="collapse-One" class="panel-collapse collapse in">

                            <div class="panel-body">

                                <div class="row">

                                    <div class="col-md-4">

                                        <img class="img-responsive" src="assets/img/new/img5.jpg" alt="">

                                    </div>

                                    <div class="col-md-8">

                                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et.

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>



                    <div class="panel panel-default">

                        <div class="panel-heading">

                            <h4 class="panel-title">

                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-1" href="#collapse-Two">

                                    Collapsible Group Item #2

                                </a>

                            </h4>

                        </div>

                        <div id="collapse-Two" class="panel-collapse collapse">

                            <div class="panel-body">

                                <div class="row">

                                    <div class="col-md-8">

                                        <p>Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid.</p>

                                        <ul class="list-unstyled">

                                            <li><i class="fa fa-check color-green"></i> Donec id elit non mi porta gravida at eget metus..</li>

                                            <li><i class="fa fa-check color-green"></i> Fusce dapibus, tellus ac cursus comodo egetine..</li>

                                            <li><i class="fa fa-check color-green"></i> Food truck quinoa nesciunt laborum eiusmod runch..</li>

                                        </ul>

                                    </div>

                                    <div class="col-md-4">

                                        <img class="img-responsive" src="assets/img/main/6.jpg" alt="">

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>



                    <div class="panel panel-default">

                        <div class="panel-heading">

                            <h4 class="panel-title">

                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-1" href="#collapse-Three">

                                    Collapsible Group Item #3

                                </a>

                            </h4>

                        </div>

                        <div id="collapse-Three" class="panel-collapse collapse">

                            <div class="panel-body">

                                Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Food truck quinoa nesciunt laborum eiusmodolf moon tempor, sunt aliqua put a bird. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.

                            </div>

                        </div>

                    </div>



                    <div class="panel panel-default">

                        <div class="panel-heading">

                            <h4 class="panel-title">

                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-1" href="#collapse-Four">

                                    Collapsible Group Item #4

                                </a>

                            </h4>

                        </div>

                        <div id="collapse-Four" class="panel-collapse collapse">

                            <div class="panel-body">

                                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et.

                            </div>

                        </div>

                    </div>

                </div>-->
        <!--/acc-v1-->
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
          <li><a href="https://www.twizfigs.com/deny-password.php"><i class="fa fa-globe"></i>https://www.twizfigs.com/deny-password.php</a></li>
        </ul>
        <!-- Business Hours -->
        <!--<div class="headline"><h2>Contact us 24/7</h2></div>

                <ul class="list-unstyled margin-bottom-30">

                    <li><strong>We will do our best to respond ASAP</strong> </li>

                   </li>

                </ul>-->
        <!-- Why we do this? -->
        <div class="headline">
          <h2>Why do we do this?</h2>
        </div>
        <p>Simple.  We have an obsession with the horse racing industry.  We also really dig complicated algorithms.  And we need some kind of justification for consuming massive amounts of coffee.  So, that's it.  Horses and coffee.  And math.</p>
        <!--<ul class="list-unstyled who margin-bottom-30">
          <li><i class="fa fa-check color-green"></i>&nbsp;&nbsp;Higher the better figures</li>
          <li><i class="fa fa-check color-green"></i>&nbsp;&nbsp;Exclusive Trackmaster Data</li>
          <li><i class="fa fa-check color-green"></i>&nbsp;&nbsp;Easy to use and understand</li>
        </ul>-->
        <!-- Social -->
        <div class="magazine-sb-social margin-bottom-20">
          <div class="headline headline-md">
            <h2>Social Networks</h2>
          </div>
          <ul class="social-icons social-icons-color">
            <li><a href="https://twitter.com/thoroughwiz" data-original-title="Twitter" class="social_twitter" target="_blank"></a></li>
                    	<li><a href="https://facebook.com/thoroughwizsheets" data-original-title="Facebook" class="social_facebook" target="_blank"></a></li>
                        <li><a href="https://www.youtube.com/c/thoroughwizsheets" data-original-title="Youtube" class="social_youtube" target="_blank"></a></li>
                       
            <!--<li><a href="#" data-original-title="Feed" class="social_rss"></a></li>

                        <li><a href="#" data-original-title="Vimeo" class="social_vimeo"></a></li>

                        <li><a href="#" data-original-title="Pinterest" class="social_pintrest"></a></li>

                        <li><a href="#" data-original-title="Linkedin" class="social_linkedin"></a></li>

                        <li><a href="#" data-original-title="Dropbox" class="social_dropbox"></a></li>

                        <li><a href="#" data-original-title="Picasa" class="social_picasa"></a></li>

                        <li><a href="#" data-original-title="Spotify" class="social_spotify"></a></li>

                        <li><a href="#" data-original-title="Jolicloud" class="social_jolicloud"></a></li>

                        <li><a href="#" data-original-title="Wordpress" class="social_wordpress"></a></li>

                        <li><a href="#" data-original-title="Github" class="social_github"></a></li>

                        <li><a href="#" data-original-title="Xing" class="social_xing"></a></li>-->
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
    <?php include("modals.php"); ?>
</div><!--/wrapper-->
</body>
</html>