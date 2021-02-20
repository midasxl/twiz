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

<form id="homepage-login-form" name="login" action="user-login.php" method="post"> 
        <label>Email Address:</label>
        <div class="input-group margin-bottom-20">
            <span class="input-group-addon"><i class="fa fa-user"></i></span>
            <input type="text" id="email" name="email" class="form-control" required/>
        </div>  
        <label>Password:</label>                  
        <div class="input-group margin-bottom-20">
            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
            <input type="password" id="password" name="password" class="form-control" required/>
        </div>
        <div class="row">                            
            <div class="sign-in-trouble-wrap col-md-6">
                <a href="forgot-password.php">Forgot Password?</a><br>
                <a href="resend-activation.php">Resend Activation Email</a><br>
            </div>
            <div class="log-in-wrap col-md-6">
            <button type="submit" class="btn btn-success pull-center"><i class="fa fa-sign-in"></i>&nbsp;&nbsp;Log In 5</button>
            </div>
        </div>
        <br>
</form>
    
    
    
<div id="form-messages" title="Thoroughwiz says..." style="text-align:center;padding:5px;"></div>

<div id="logInDiv" title="Logging In" style="display:none;text-align:center;padding:5px;">
    <img src="img/loading11.gif" alt="loading" />
</div>

<div id="logInGood" title="You're In!" style="text-align:center;padding:5px;"></div>
    
    
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
    
<script>
//$(document).ready(function(){
	
// submit the form
//$('#homepage-login-form').on('submit', function (e) {
        
                // Stop the browser from submitting the form.
    			//e.preventDefault();
                
				//alert("internal");

    //}) // close submit function
    
//}); // end jquery
</script>
    
<script type="text/javascript" src="assets/js/custom.js"></script>
    
</body>
</html>