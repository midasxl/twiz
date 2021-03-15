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
  	<?php include("modals.php"); ?>
	<?php include("footer.php"); ?>
</div><!--/wrapper-->

</body>
</html>