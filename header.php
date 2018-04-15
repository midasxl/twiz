<!--=== Header ===-->  

    <div class="header">
        <!-- Topbar -->
        <div class="topbar">
            <div class="container">
                <!-- Topbar Navigation -->
                <ul class="loginbar pull-right">
					<?php
					if(isset($_SESSION["userCakeUser"]) && is_object($_SESSION["userCakeUser"])){ 
						
					echo "<li><i class='fa fa-check-square-o'></i></li>   
                    <li><a style='font-weight:bold;color:#72c02c;' href='account.php'>" .$loggedInUser->email. " (Signed In)</a></li>
                    <li class='topbar-divider'></li> 
                    <li><i class='fa fa-gift'></i></li>   
                    <li><a href='#' data-toggle='modal' data-target='#resources'>Resources</a></li>  
                    <li class='topbar-divider'></li>
                    <li><i class='fa fa-exclamation-circle'></i></li>             
                    <li><a href='http://knowtheodds.org' target='_blank'>NOT INTENDED FOR GAMBLING</a></li>";
                    /*<li class='topbar-divider'></li> 
                    <li><i class='fa fa-gift'></i></li>   
                    <li><a href='#' data-toggle='modal' data-target='#filters'>Filters</a></li>*/

					}else{
					echo "<li><i class='fa fa-sign-in'></i></li>   
                    <li><a href='login.php'>Member Login</a></li>
					<li class='topbar-divider'></li>   
                    <li><i class='fa fa-gift'></i></li>   
                    <li><a href='#' data-toggle='modal' data-target='#resources'>Resources</a></li> 
                    <!--<li><a href='#' data-toggle='modal' data-target='#promo' style='color:#3e4753'>P</a></li>-->
                    <li class='topbar-divider'></li>
                    <li><i class='fa fa-exclamation-circle'></i></li>           		
                    <li><a href='http://knowtheodds.org' target='_blank'>NOT INTENDED FOR GAMBLING</a></li>";
                        	}
						?>
                </ul>
                <!-- End Topbar Navigation -->
            </div>
        	<!-- End Container -->
        </div>
        <!-- End Topbar -->
    
        <!-- Navbar -->
        <div class="navbar navbar-default" role="navigation">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                
                    <button type="button" class="top-burger navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="fa fa-bars"></span>
                    </button>
                    
                    <a class="navbar-brand" href="index.php">
                        <img id="logo-header" class="collectOnMe" src="assets/img/logo-twiz.png" alt="Logo">
                    </a>
                    
                </div>
                <style>
                    @media (min-width:768px){
                        .nav.navbar-nav.main-nav{
                            float:right;
                        }
                    }
                </style>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse navbar-responsive-collapse">
                    <ul id="navigation" class="nav navbar-nav main-nav">
                    
                        <li>
                            <a href="index.php">
                                Home
                            </a>
                        </li>
                        
                        <li class="">
                            <a href="about.php">
                                About Us
                            </a>
                        </li>
                        
                        <li class="">
                            <a href="contact.php">
                                Contact Us
                            </a>
                        </li>
                        
                        <li class="">
                            <a href="faq.php">
                                FAQ
                            </a>
                        </li>

                        <li class="">
                            <a href="terms.php">
                                Terms of Service
                            </a>
                        </li>

                        <li class="">
                            <a href="privacy.php">
                                Privacy Policy
                            </a>
                        </li>
                        
                    </ul>
                </div><!--/navbar-collapse-->
            </div>    
        </div><!-- End Navbar -->
</div><!-- End Header -->