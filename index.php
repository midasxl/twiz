<?php
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
?>
<!DOCTYPE html>
<html lang="en">
<head>

<title>Handicapping horse racing Thoroughwiz</title>
<!-- Meta Data -->
<?php include("meta.php"); ?>
<!-- CSS Import -->
<?php include("style_block.php"); ?>
</head>
<body>
<!-- never use a row outside a container classed element; it won't work -->
<div class="container">
    <div class="row">
        <div class="col-sm-6">
            <div class="outline">
                <div class="pub_300x250"></div>
            </div>
        </div>
   
    </div>
</div>

<div class="wrapper">
	<?php include("header.php"); ?>
    <div class="purchase">
        <div class="container content">
            <div class="row">        
                <div class="col-md-4 animated fadeInLeft">
				    <p id="opener"><span id="trigger">Member Login</span></p>
                    <form id="login-form" name="login" action="user-login.php" method="post"> 
                        <label>Email Address:</label>
                        <div class="input-group margin-bottom-20">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <input type="text" id="username" name="email" class="form-control" required/>
                        </div>  
                        <label>Password:</label>                  
                        <div class="input-group margin-bottom-20">
                            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                            <input type="password" id="password" name="password" class="form-control" required/>
                        </div>
                        <div class="row margin-bottom-50"> 
                            <div class="sign-in-trouble-wrap col-md-6">
                                <a href="forgot-password.php">Forgot Password?</a><br>
                                <a href="resend-activation.php">Resend Activation Email</a>
                            </div>
                            <div class="log-in-wrap col-md-6">
                                <button type="submit" class="btn btn-success pull-right"><i class="fa fa-sign-in"></i>&nbsp;&nbsp;Log In</button>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="log-in-wrap col-md-12">
                                <a href='register.php' class='btn btn-success'><span class='glyphicon glyphicon-user'></span>&nbsp;&nbsp;Register Now!</a>
                            </div>
                        </div>
                        <br>
                      
                    </form>
                </div><!-- /col-md-4 -->
            
                <div class="col-md-1">
                </div>
            
                <div class="col-md-7 animated fadeInRight">
                    <p id="opener"><span>Welcome to Thoroughwiz!</span> A unique algorithm designed over years of observation and testing to produce a special ranking called the <strong>TWIZ rank</strong>. Based on several highly proficient handicappers' precise methodologies, this unique algorithm was developed and refined through computer programming to form a unique way of predicting and quantifying the results of a horse race.<br><br>
                    We are your thoroughbred racing wizard!</p>
                    <hr>
                        <div class="feature-list-wrap col-xs-6">
                                <ul class="feature-list">
                                    <li class="feature-list-item"><i class="fa fa-star color-green"></i>&nbsp;&nbsp;Sortable categories</li>
                                    <li class="feature-list-item"><i class="fa fa-star color-green"></i>&nbsp;&nbsp;Instant access to last race charts</li>
                                    <li class="feature-list-item"><i class="fa fa-star color-green"></i>&nbsp;&nbsp;Proprietary trainer, Jockey and horse ratings</li>
                          
 <li class="feature-list-item"><i class="fa fa-star color-green"></i>&nbsp;&nbsp;Equibase 'E' average speed figures</li>
                                    
                                </ul>
                        </div>
                           
                       <div class="feature-list-wrap col-xs-6 text-center">
                            	<ul class="feature-list">
                                <br><br>   
                                <button type="submit" class='btn btn-success'><span class="glyphicon glyphicon-gift"></span>&nbsp;&nbsp;Check Out Our Free Sample!</button>
                                </ul>
                        </div>
                    
                        <div style="clear:both;"></div>
                    
                </div><!-- close col-md-7 -->     
            </div><!-- /row -->
        </div><!-- /container -->
    </div><!-- /purchase -->

    <div class="container content">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1><strong>HOW IT WORKS</strong></h1>
            </div>
        
        <div class="col-md-4">
            <div class="service">
                <i class="service-icon"><img src="img/step1.png" alt="Step One" /></i>
                <div class="desc">
                    <h4>Create Account</h4>
                    <p><a href="register.php">Register for free</a> to purchase one of our package options, or take it slow and use our <strong>$5.00</strong> per credit/track option.  That's about the cost of a cup of coffee, which quite honestly is probably what we will use it for.  Thanks for the buzz!</p>
                    <p><a href='register.php' class='btn btn-success'><span class='glyphicon glyphicon-user'></span>&nbsp;&nbsp;Register Now!</a></p>
               
			   </div>
				
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="service">
                <!--<i class="fa fa-money service-icon"></i>-->
                <i class="service-icon"><img src="img/step2.png" alt="Step Two" /></i>
                <div class="desc">
                    <h4>Get Data File</h4>
                    <p><a href="https://www.trackmaster.com/cgi-bin/register.cgi?tpp" target="_blank">Sign up at TrackMaster</a>.  Navigate to TrackMaster Past Performances Downloads, choose a track, choose a date, and get the Data File (XML).  Our service requires the file to be in .zip or .xml format.</p>
                    <p><a href="http://new.trackmaster.com/products/tpp/download" target="_blank" class="btn btn-success"><span class="glyphicon glyphicon-new-window"></span>&nbsp;&nbsp;Visit Trackmaster</a></p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="service">
                <!--<i class="fa fa-cogs service-icon"></i>-->
                <i class="service-icon"><img src="img/step3.png" alt="Step Three" /></i>
                <div class="desc">
                    <h4>Process Data File</h4>
                    <p>Purchase single credits or one of our credit packages, and then simply browse, select, and upload your Trackmaster data file to process your custom Thoroughwiz strategy sheets. Check out our sample sheets below!</p>
                    <form action='product_free_sample.php' method='post' enctype='multipart/form-data'>
                    <button type="submit" class='btn btn-success'><span class="glyphicon glyphicon-gift"></span>&nbsp;&nbsp;View A Free Sample!</button>
                    </form>          
                </div>
            </div>
        </div>
        
        </div><!-- /row -->
    </div><!-- /container -->
    <hr>
    <!--=== Free Demo ===-->
    <!--<div class="purchase">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-1 animated fadeInLeft">
                    <p>Would you like to take our service for a test drive? Click the "Try For Free" button on the right to step through the process of submitting a TrackMaster Data File to be processed by our unique algorithm.</p>
                </div>
                <div class="col-md-4 btn-buy animated fadeInRight promo">
                    <form action='access_sample.php' method='post'>
                    <button type="submit" class="btn btn-success btn-lg"><i class="fa fa-thumbs-up"></i>&nbsp;&nbsp;Try For Free!</button>
                    </form>
                </div>
            </div>
        </div>
    </div>-->
    
    <div class="title-box">
        <p>Ready to do this?  Create your account, get your data file, and process your data.</p>
        <p><img alt="stripe payments" border="0" src="img/stripe-payments.png" class="img-responsive pp" /></p>
        <p><a href="https://stripe.com/" target="_blank" class="btn btn-info"><span class="glyphicon glyphicon-new-window"></span>&nbsp;&nbsp;What is Stripe?</a></p>
    </div>

    <!--<center>
    
        <a class="twitter-timeline" href="https://twitter.com/ThoroughWiz" data-widget-id="605769625473654785">Tweets by @ThoroughWiz</a>
        <script>    
        !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");
        </script>
    
    </center>-->
    
    <?php include("modals.php"); ?>
    <?php include("footer.php"); ?>
  
</div><!--/wrapper-->


    
</body>
</html>
