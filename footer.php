    <!--=== Footer ===-->
    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 md-margin-bottom-40">
                    <div class="headline"><h2>About</h2></div>  
                    <p class="margin-bottom-25 md-margin-bottom-40">Thoroughwiz is a premiere, purchase-based, self-service  handicapping sheet.  We offer unparalleled strategic algorithms to guide your decisions at the track.  What? You thought this was going to be complicated?</p>    
                </div><!--/col-md-4-->                  
                <div class="col-md-4 md-margin-bottom-40">
                    <div class="headline"><h2>Related Links</h2></div>                    
                    <div class="row">
                            <span class="col-md-6">
                                    <ul class="footer-related-links-list">
                                        <li><a href="http://theturfclub.yolasite.com/the-lobby.php" target="_blank"><i class="fa fa-star color-green"></i>&nbsp;&nbsp;The Turf Club</a></li>
                                        <li><a href="http://www.allhorseracing.ag/handicapping/past-performances-pps" target="_blank"><i class="fa fa-star color-green"></i>&nbsp;&nbsp;All Horse Racing</a></li>
                                    </ul>
                            </span>
                            <span class="col-md-6">
                                    <ul class="footer-related-links-list">
                                        <li><a href="http://knowtheodds.org" target="_blank"><i class="fa fa-star color-green"></i>&nbsp;&nbsp;Know The Odds!</a></li>
                                        <li><a href="https://www.google.com/drive/" target="_blank"><i class="fa fa-star color-green"></i>&nbsp;&nbsp;Google Drive</a></li>
                                    </ul>
                            </span>                           
                    </div>
                </div><!--/col-md-4-->
                <div class="col-md-4">
                    <div class="headline"><h2>Social Networks</h2></div> 
                    <ul class="social-icons">
                    	<li><a href="https://twitter.com/thoroughwiz" data-original-title="Twitter" class="social_twitter" target="_blank"></a></li>
                    	<li><a href="https://facebook.com/thoroughwizsheets" data-original-title="Facebook" class="social_facebook" target="_blank"></a></li>
                        <li><a href="https://www.youtube.com/c/thoroughwizsheets" data-original-title="Youtube" class="social_youtube" target="_blank"></a></li>
                        
                    </ul>                    
                </div><!--/col-md-4-->
            </div>
        </div> 
    </div><!--/footer-->
    <!--=== End Footer ===-->
    <!--=== Copyright ===-->
    <div class="copyright">
        <div class="container">
            <div class="row">
                <div class="col-md-6">                     
                    <p>
                        &copy; 2017 | ALL Rights Reserved<br />
                        <a href="privacy.php">Privacy Policy</a>&nbsp;|&nbsp;<a href="terms.php">Terms of Service</a><br />
Your Thoroughbred Racing Wizard!
                    </p>  
                </div>
                <div class="col-md-6">  
                    <a href="index.php">
                        <img class="pull-right" id="logo-footer" src="assets/img/logo1-twiz.png" alt="">
                    </a>
                </div>
            </div><!--/row-->
        </div><!--/container-->
    </div><!--/copyright--> 
    <!--=== End Copyright ===-->

<!-- JS Global Compulsory -->
<script type="text/javascript" src="assets/plugins/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="assets/js/ui-theme/jquery-ui.min.js"></script>
<script type="text/javascript" src="assets/plugins/jquery-migrate-1.2.1.min.js"></script>
<!-- JS Implementing Plugins -->
<script type="text/javascript" src="assets/plugins/back-to-top.js"></script>
<!-- JS Page Level -->
<script type="text/javascript" src="assets/js/app.js"></script>
<!-- active-nav js -->
<script type="text/javascript" src="assets/js/active-nav.js"></script>
<!-- php file tree -->
<script type="text/javascript" src="assets/js/php_file_tree_jquery.js"></script>
<!-- jquery range slider -->
<script type="text/javascript" src="assets/js/rangeslider.min.js"></script>

<script type="text/javascript">
    jQuery(document).ready(function() {
      	App.init();
        
        var $element = $('input[type="range"]');

        $element
          .rangeslider({
            polyfill: false,
            onInit: function() {
              var $handle = $('.rangeslider__handle', this.$range);
              updateHandle($handle[0], this.value);
            }
          })
          .on('input', function(e) {
            var $handle = $('.rangeslider__handle', e.target.nextSibling);
            updateHandle($handle[0], this.value);
          });

        function updateHandle(el, val) {
          el.textContent = val;
        }
    });
</script>
<!--[if lt IE 9]>

    <script src="assets/plugins/respond.js"></script>

    <script src="assets/plugins/html5shiv.js"></script>    

<![endif]-->