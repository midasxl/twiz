<?php
require_once("models/config.php");
require_once('scripts/stripe/stripe-config.php'); // fetches publishable key to identify twiz site to Stripe for communication
if (!securePage($_SERVER['PHP_SELF'])){die();}
$userid = $loggedInUser->user_id;
$userdetails = fetchUserDetails(NULL, NULL, $userid); //Fetch user details
$userPermission = fetchUserPermissions($userid);
$permissionData = fetchAllPermissions();
$usercredits = fetchAllCredits($userid); //fetch user credits
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Thoroughwiz | User Profile...</title>
<!-- Meta Data -->
<?php include("meta.php"); ?>
<!-- CSS Import -->
<?php include("style_block.php"); ?>
</head>
<body>
<?php 
    echo $userid;
    ?>
<div class="wrapper">
	<?php include("header.php"); ?>
    <!--=== Breadcrumbs ===-->
    <div class="breadcrumbs">
        <div class="container">
            <h1 class="pull-left"><?php echo "Welcome $loggedInUser->email!" ?></h1>
            <ul class="pull-right breadcrumb">
            <li><a href="index.php">Home</a></li>
            <li class="active">User Profile</li>
            </ul>
        </div>
    </div>
    <!--/breadcrumbs-->
    <!--=== End Breadcrumbs ===-->
	<!--=== Content Part ===-->
	<div class="container content">
  
	<?php include("assets/snippets/left-nav.php"); ?>

    <div class="row">
    <div class="col-md-8">
        <div class="panel panel-default" >
            <div class="panel-heading">User Data</div>
            <div class="panel-body">
            <div class="col-md-2">
            <img src="assets/img/icons/member-image.jpg" alt="members icon" />
            </div>
            <div class="col-md-5">
            <?php
                echo "
                <p>			
                <label>User ID:&nbsp;&nbsp;</label>
                ".$userdetails['id']."
                </p>
                <p>
                <label>Email:&nbsp;&nbsp;</label>
                ".$userdetails['email']."
                </p>
				<p>
                <label>Status:&nbsp;&nbsp;</label>";
    
                if ($userdetails['active'] == '1'){
                    echo "Active";	
                }
                else{
                    echo "Inactive";
                }
                echo "
                </p>";
			?>
            </div>
            <div class="col-md-5">
            <?php
                echo "
                <p>
                <label>Member Level:&nbsp;&nbsp;</label>
                ".$userdetails['title']."
                </p>";
				$isSubscriptionMember = fetchPlanId($loggedInUser->user_id); //get stripe id for this user if it exists
					  foreach ($isSubscriptionMember as $planid){
						  if($planid['planid'] !== '0'){
								  $stripe_customer = Stripe_Customer::retrieve($loggedInUser->stripe_id);
								  echo '<p><form action="user_cancel_subscription.php" method="POST">
								  <input type="hidden" name="customer_id" value="'.$stripe_customer->id.'" />
								  <input type="hidden" name="plan_id" value="'.$stripe_customer->subscriptions->data[0]->id.'" />
								  <input type="submit" name="submit" value="Cancel Subscription" />
								  </form></p>';
						   }
					  } 
				echo "
				<p>
                <label>Registration Date:&nbsp;&nbsp;</label>
                ".date("j M, Y", $userdetails['sign_up_stamp'])."
                </p>
				
				<p>
                <label>Last Access Date:&nbsp;&nbsp;&nbsp;</label>";
                if ($userdetails['last_sign_in_stamp'] == '0'){
                    echo "  Never";	
                }
                else {
                    echo date("j M, Y", $userdetails['last_sign_in_stamp']);
                };
                foreach ($usercredits as $credits){
					if($credits['credits'] > 0){
						echo "</p><p><label>Sheet Credits:&nbsp;&nbsp;</label>".$credits['credits']."</p>";
					} else {
                        echo "</p><p><label>Sheet Credits:&nbsp;&nbsp;</label>0</p>";
					}
                }
			?>
            
            </div>
            <!--<div class="table-responsive">
                         
                         <table width="98%" align="center" cellpadding="3" cellspacing="0"  class="table table-bordered">
                            <tbody>
                            	<tr>    
                                  <th colspan="2" style="background-color:#72c02c;">Transaction History</th>
                               </tr>
                               <tr>    
                                  <th>Date</th>
                                  <th>Transaction Details</th>
                               </tr>
                              </tbody>
                          </table>
            </div>-->
            </div>
        </div>
    </div>
            
    <div class="col-md-4">
        <div class="panel panel-default" >
            <div class="panel-heading">Change Password</div>
            <div class="panel-body">
<form name="updateAccount" id="user-update-form" action="user-update-account.php" method="post">
					<div>
						<p>
						<label>Current Password:</label>
						<input type="password" class="form-control" id="password" name="password" required/>
						</p>
						<p>
						<label>New Password (8 to 50 characters):</label>
						<input type="password" class="form-control" id="passwordc" name="passwordc" required/>
						</p>
						<p>
						<label>Confirm New Password:</label>
						<input type="password" class="form-control" id="passwordcheck" name="passwordcheck" required/>
						</p>
						<p>
						<label>&nbsp;</label>
						<button class="btn btn-success pull-right"><i class="fa fa-refresh"></i>&nbsp;&nbsp;Change Password</button>
						<button type="reset" id="cancel-pw" class="btn btn-danger pull-right" style="margin-right:5px;"><i class="fa fa-ban"></i>&nbsp;&nbsp;Cancel</button>
						</p>
					</div>
                    </form>            
                    </div>
        </div>
    </div>
            
    <!--<div class="col-md-4">
        <div class="panel panel-default" >
            <div class="panel-heading">Delete Account</div>
            <div class="panel-body">
			<?php /*
            echo "
			<form name='adminDelete' action='".$_SERVER['PHP_SELF']."?id=".$userId."' method='post'>
			<p>
			<label>Select to Delete Your Account:</label>
			<br><input type='checkbox' name='delete[".$userdetails['id']."]' id='delete[".$userdetails['id']."]' value='".$userdetails['id']."'> Delete Account
			</p><hr>
			<input type='submit' value='Delete Account' name='user-delete' class='btn-u btn-u-primary pull-right' />
			</form>";
			*/ ?>
            </div>
        </div>
    </div>-->
    </div><!--/row-->
  </div><!--/container-->
  <!--=== End Content Part ===-->
  <?php include("footer.php"); ?>
    <?php include("modals.php"); ?>
</div><!--/wrapper-->
<!--<div id="form-messages" title="Throughwiz says..." style="text-align:center;padding:5px;"></div>-->
<script>
$(document).ready(function(){
	
	$(function () {
		
		// feature detection for required attribute
		var supportsRequired = 'required' in document.createElement('input')
		
			// if 'required' isn't supported
			if (!supportsRequired) {
	
				// loop through each element with a 'required' attribute
				$('[required]').each(function () {
	
					// this
					var self = $(this)
	
					// swap attribute for class
					self.removeAttr('required').addClass('required');
	
					// append an error message
					self.parent().append('<span class="form-error">Required</span>')
	
				}); //end each loop
		
			}; // end if supportsrequired
			
			
	
		// submit the form
		$('#user-update-form').on('submit', function (e) {
			
			// if 'required' isn't supported
			if (!supportsRequired) {
			
				// loop through class name required
				$('.required').each(function () {
		
					// this
					var self = $(this)
		
					// check shorthand if statement for input[type] detection
					var checked = (self.is(':checkbox') || self.is(':radio')) 
					? self.is(':not(:checked)') && $('input[name=' + self.attr('name') + ']:checked').length === 0 
					: false
		
					// run the empty/not:checked test
					if (self.val() === '' || checked) {
		
						// show error if the values are empty still (or re-emptied)
						// this will fire after it's already been checked once
						self.siblings('.form-error').show()
		
						// stop form submitting
						e.preventDefault()
		
					} 
					
				}) // close each loop
			
				if ($("#password").val().length !==0 && $("#passwordc").val().length !==0 && $("#passwordcheck").val().length !==0){	
					// Get the form.
					var form = $('#user-update-form');
				
					// Get the messages div.
					var formMessages = $('#form-messages');
					
					// Stop the browser from submitting the form.
					e.preventDefault();
					
					// Serialize the form data.
					var formData = $(form).serialize();
					
					$.ajax({
					  url: $(form).attr('action'),
					  type: 'POST',
					  data: formData,
					  dataType: 'json',
					  success: function(data) {
							$(formMessages).html(data[0]);
							$(formMessages).dialog({
						autoOpen: false,
						modal: true,
						buttons: [ { 
							text: "Ok", click: function() { 
							$( this ).dialog( "close" );
						} 
						} ]
					});
							$(formMessages).dialog("open");
							if(data[1] == "match"){
								$("#chg-pwd").hide();
							}
					  },
					  error: function(xhr, desc, err) {
						  //$(formMessages).html("Details: " + desc + "\nError:" + err + "\nError:" + eval(xhr));
							$(formMessages).html("The system has encountered an error");
							$(formMessages).dialog({
						autoOpen: false,
						modal: true,
						buttons: [ { 
							text: "Ok", click: function() { 
							$( this ).dialog( "close" );
						} 
						} ]
					});
							$(formMessages).dialog("open");
					  }
					}); // end ajax call
	
				} // close if/else
	
			} else { // if required attribute IS supported, we can let HTML 5 handle the validation and jump right to the ajax
			
					// Get the form.
					var form = $('#user-update-form');
				
					// Get the messages div.
					var formMessages = $('#form-messages');
					
					// Stop the browser from submitting the form.
					e.preventDefault();
					
					// Serialize the form data.
					var formData = $(form).serialize();
					
					$.ajax({
					  url: $(form).attr('action'),
					  type: 'POST',
					  data: formData,
					  dataType: 'json',
					  success: function(data) {
							$(formMessages).html(data[0]);
							$(formMessages).dialog({
						autoOpen: false,
						modal: true,
						buttons: [ { 
							text: "Ok", click: function() { 
							$( this ).dialog( "close" );
						} 
						} ]
					});
							$(formMessages).dialog("open");
							if(data[1] == "match"){
								$("#chg-pwd").hide();
							}
					  },
					  error: function(xhr, desc, err) {
							//$(formMessages).html("Details: " + desc + "\nError:" + err + "\nError:" + eval(xhr));
							$(formMessages).html("The system has encountered an error");
							$(formMessages).dialog({
						autoOpen: false,
						modal: true,
						buttons: [ { 
							text: "Ok", click: function() { 
							$( this ).dialog( "close" );
						} 
						} ]
					});
							$(formMessages).dialog("open");
					  }
					}); // end ajax call
					
			}
	
		}) // close submit function
	
		// key change on all form inputs i.e user enters and exits a form field
		$('input').on('blur change', function () {
	
			// this
			var self = $(this)
	
			// check shorthand if statement for input[type] detection
			var checked = (self.is(':checkbox') || self.is(':radio')) 
			? self.is(':not(:checked)') && $('input[name=' + self.attr('name') + ']:checked').length === 0 
			: false
	
			// if empty on change, i.e. if data is removed
			if (self.val() === '' || checked) {
	
				// show/keep the error in view
				self.siblings('.form-error').show()
	
			// if there's a value or checked
			} else {
	
				// hide the error
				self.siblings('.form-error').hide()
	
			}
	
		}) // close input blur/change
	
	}) // close main function
		
});
</script>
</body>
</html>