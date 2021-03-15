<?php
	require_once("models/config.php");
	if (!securePage($_SERVER['PHP_SELF'])){die();}
	$userid = $loggedInUser->user_id;
	$userdetails = fetchUserDetails(NULL, NULL, $userid); //Fetch user details
	/*
	First, it calls the 'models/config.php' file. This file connects to the database and initiates all of our functions. Second, run the securePage() function. This function checks if the page we're on is public or private, and (if it's private) checks to see if we're logged in as a user who has access to the page. If it's private and we don't have access, we'll get sent to a page we do have access to. Third is our include for the Stripe configuration files so we can communicate with the Stripe servers.  
	*/
	require_once('scripts/stripe/stripe-config.php'); // fetches publishable key to identify twiz site to Stripe for communication
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Thoroughwiz | Member Account Area</title>
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
        
      <?php echo '<h1 class="pull-left">Welcome '.$loggedInUser->email.'!</h1>'; ?>
        
      <ul class="pull-right breadcrumb">
        <li><a href="index.php">Home</a></li>
        <li class="active">Members Account</li>
      </ul>
    </div>
  </div>
  <!--/breadcrumbs-->
  <!--=== End Breadcrumbs ===-->
  <!--=== Content Part ===-->
  <div class="container content">
  
	<?php include("assets/snippets/left-nav.php"); ?>
	
	<?php
if(isUserLoggedIn()) {

	//********************************************************************************permission level 1 (Administrator)
	if ($loggedInUser->checkPermission(array(1))){
        
        echo '<div class="col-md-6">
	        <div class="panel panel-default" >
            <div class="panel-heading">Available Race Sheets</div>
                <div class="panel-body">
                         <div class="table-responsive">
                         
                         <table width="98%" align="center" cellpadding="3" cellspacing="0"  class="table table-bordered">
                            <tbody>
                               <tr class="panel-heading">    
                                  <th style="color:#000;">Track and Date</th>
                                  <th style="color:#000;">Sheet Expiration</th>
                               </tr>';
                                  $dbsheets = fetchAllSheets($loggedInUser->user_id);
								  if($dbsheets != NULL){
									  foreach ($dbsheets as $sheets){
                                        $exp_date = date('m-d-Y H:i:s', strtotime($sheets['time'] . ' + 4 day'));
										// Returns the file name, less the extension.
										$sheet_id = $sheets['id'];
										$sheet_name = preg_replace('/.[^.]*$/', '', $sheets['sheet']);
										$sheet_name = substr($sheet_name, 0, -6);
										$sheet_track = $sheets['racetrack'];
										$sheet_date = date('m-d-Y', strtotime($sheets['racedate']));
										$date_now = new DateTime();
                                        echo "<tr style='background-color:#72c02c;text-align:center;'>
												<td><strong>".$sheet_track."</strong><br>".$sheet_date."</td>
												<td>".$exp_date;
		
												if ($date_now > $sheet_date) {
    													echo "<br><form action='user-delete-sheets.php' method='post' id='" .$sheet_track. "' class='deleteSheetSet'>
    													<button type='submit' class='btn btn-success pull-center btn-sm btn-block'>
    													<i class='fa fa-remove'></i>&nbsp;&nbsp;Delete This Set</button>
    													<input type='hidden' name='sheetId' value='".$sheet_id."' />
    													</form>";
												}
		
												echo "
												</td>
  												</tr>
                                                
												<tr>
												<td>
                                                <form style='display:inline' action='scripts/summary.php' method='post' enctype='multipart/form-data' target='_blank'>
                                                            <input type='hidden' name='card' value='" .$sheets['sheet']. "'>
                                                            <button type='submit' class='btn btn-primary btn-u-sm'><i class='fa fa-file-text-o'></i>&nbsp;&nbsp;Summary Sheet</button>
                                                </form>                                
                                                </td>
                                                </tr>
                                                <tr>                                                
                                                <td>												
												
												<form action='scripts/details_horse.php' method='post' enctype='multipart/form-data' target='_blank'>
												  <input type='hidden' name='card' value='" .$sheets['sheet']. "'>
												  <button type='submit' class='btn btn-info btn-u-sm'><i class='fa fa-file-text-o'></i>&nbsp;&nbsp;Past Performances</button>
												</form>
													</td>
                         						<td></td>
												</tr>";
                                        }
								  }
                          echo '</tbody>
                          </table>
                </div> 
            </div>
        </div>
    </div>
	<div class="col-md-6">
        <div class="panel panel-default" >
            <div class="panel-heading">User Data</div>
                <div class="panel-body">
				<div>
                    <form name="updateAccount" id="user-update-form" action="user-update-account.php" method="post">
					<p>
                    <label>User Role:</label>
                    <input type="text" class="form-control" value="'.$loggedInUser->title.'" disabled/>
                    </p>
					<p>
                    <label>Registered Email:</label>
                    <input type="text" class="form-control" name="email" value="'.$loggedInUser->email.'" disabled/>
                    </p>
                    <p><a href="#" id="toggle-chg-pwd" style="font-weight:bold;">Change Password</a></p>
					
					<div id="chg-pwd" style="display:none;">
						<p>
						<label>Current Password:</label>
						<input type="password" class="form-control" name="password" required/>
						</p>
						<p>
						<label>New Password (8 to 50 characters):</label>
						<input type="password" class="form-control" name="passwordc" required/>
						</p>
						<p>
						<label>Confirm New Password:</label>
						<input type="password" class="form-control" name="passwordcheck" required/>
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
	</div>'; 
	}
    
	//********************************************************************************permission level 2 (Base Member)
	if ($loggedInUser->checkPermission(array(2))){
	echo '<div class="col-md-3">
        <div class="panel panel-default" >
            <div class="panel-heading">Payment Options</div>
                <div class="panel-body">
                         <div>                         
                         <p>A single credit purchase provides you access to process a single TrackMaster .zip file. Quick and easy!</p>'; ?> 
                         
         <form action="user_charge.php" method="post">
         <?php $isStripeCustomer = fetchStripeId($loggedInUser->user_id); //get stripe id for this user if it exists
				foreach ($isStripeCustomer as $stripeid){
					if($stripeid['stripeid'] !== '0'){
							$stripe_customer = Stripe_Customer::retrieve($stripeid['stripeid']);?>
							<input type="hidden" name="customer_id" value="<?php echo $stripeid['stripeid'] ?>" />
					<?php }
				} ?>
          <p align="center">
				  <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                          	data-key="<?php echo $stripe['publishable_key']; ?>"
							data-email="<?php echo $loggedInUser->email; ?>"
                          	data-amount="250" 
                          	data-description="One Credit Purchase ($2.50)"
                          	data-name="Thoroughwiz Sheet"
                        	data-panel-label="One Credit - "
                        	data-label="One Credit - $2.50">
                  </script>
          </p>
          </form>
          
        <hr class="hr-sm">

          <p>10 Credit Package.  Banked credits are used at your discretion.  Save 50% compared to the single credit price!</p>
          <form action="user_charge_package_10.php" method="post">
         <?php $isStripeCustomer = fetchStripeId($loggedInUser->user_id); //get stripe id for this user if it exists
				foreach ($isStripeCustomer as $stripeid){
					if($stripeid['stripeid'] !== '0'){
							$stripe_customer = Stripe_Customer::retrieve($stripeid['stripeid']);?>
							<input type="hidden" name="customer_id" value="<?php echo $stripeid['stripeid'] ?>" />
					<?php }
				} ?>
          <p align="center">
				  <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                          	data-key="<?php echo $stripe['publishable_key']; ?>"
							data-email="<?php echo $loggedInUser->email; ?>"
                          	data-amount="1250" 
                          	data-description="Ten Credit Purchase ($12.50)"
                          	data-name="Thoroughwiz Sheet"
                        	data-panel-label="Ten Credits - "
                        	data-label="Ten Credits - $12.50">
                  </script>
          </p>
          </form>         

            <?php echo '</div> 
        </div>
    </div>
    </div>'; ?><!--/col-md-3-->
    <div class="col-md-3">
		<div class="panel panel-default" >
            <div class="panel-heading">Sheet Credits</div>
                <div class="panel-body">
                         <div class="table-responsive">
                         
                         <table width="98%" align="center" cellpadding="3" cellspacing="0"  class="table table-bordered">
                            <tbody>
                               <tr>    
                                  <th colspan="2" style="background-color:#72c02c;">Current # of Banked Credits</th>
                               </tr>
								  <?php
                                  $dbcredits = fetchAllCredits($loggedInUser->user_id); //get all credits
                                        foreach ($dbcredits as $credits){
												if($credits['credits'] > 0){
												echo "<tr>
                                                <td align='center' class='credit-bg'>".$credits['credits']."</td><td><a href='single-access.php' class='credit-bg-a'>Run your sheet now!</a></td>
                                                </tr>";
												} else {
                                                echo "<tr>
                                                <td>You have no credits!  <strong>Go buy some!</strong></td>
                                                </tr>";
												}
                                        }
                                  ?>
                             </tbody>
                        </table>
                    </div> 
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default" >
            <div class="panel-heading">Available Race Sheets</div>
                <div class="panel-body">
                         <div class="table-responsive">
                         
                         <table width="98%" align="center" cellpadding="3" cellspacing="0"  class="table table-bordered">
                            <tbody>
                               <tr class="panel-heading">    
                                  <th style="color:#000;">Track and Date</th>
                                  <th style="color:#000;">Sheet Expiration</th>
                               </tr>
								  <?php
                                  $dbsheets = fetchAllSheets($loggedInUser->user_id);
								  if($dbsheets != NULL){
									  foreach ($dbsheets as $sheets){
                                        $exp_date = date('m-d-Y H:i:s', strtotime($sheets['time'] . ' + 4 day'));
										// Returns the file name, less the extension.
										$sheet_id = $sheets['id'];
										$sheet_name = preg_replace('/.[^.]*$/', '', $sheets['sheet']);
										$sheet_name = substr($sheet_name, 0, -6);
										$sheet_track = $sheets['racetrack'];
										$sheet_date = date('m-d-Y', strtotime($sheets['racedate']));
										$date_now = new DateTime();
                                        echo "<tr style='background-color:#72c02c;text-align:center;'>
												<td><strong>".$sheet_track."</strong><br>".$sheet_date."</td>
												<td>".$exp_date;
		
												if ($date_now > $sheet_date) {
    													echo "<br><form action='user-delete-sheets.php' method='post' id='" .$sheet_track. "' class='deleteSheetSet'>
    													<button type='submit' class='btn btn-success pull-center btn-sm btn-block'>
    													<i class='fa fa-remove'></i>&nbsp;&nbsp;Delete This Set</button>
    													<input type='hidden' name='sheetId' value='".$sheet_id."' />
    													</form>";
												}
		
												echo "
												</td>
  												</tr>
                                                
												<tr>
												<td>
                                                <form style='display:inline' action='scripts/summary.php' method='post' enctype='multipart/form-data' target='_blank'>
                                                            <input type='hidden' name='card' value='" .$sheets['sheet']. "'>
                                                            <button type='submit' class='btn btn-primary btn-u-sm'><i class='fa fa-file-text-o'></i>&nbsp;&nbsp;Summary Sheet</button>
                                                </form>
												</td>
                                                </tr>
                                                <tr>                                                
                                                <td>												
												
												<form action='scripts/details_horse.php' method='post' enctype='multipart/form-data' target='_blank'>
												  <input type='hidden' name='card' value='" .$sheets['sheet']. "'>
												  <button type='submit' class='btn btn-info btn-u-sm'><i class='fa fa-file-text-o'></i>&nbsp;&nbsp;Past Performances</button>
												</form>
													</td>
                         						<td></td>
												</tr>";
                                        }
								  }
                                  ?>
                              </tbody>
                          </table>
                </div> 
            </div>
        </div>
    </div>                  
                                
	<?php }	
	//********************************************************************************permission level 3 (Subscription Member) ?>
	<?php if ($loggedInUser->checkPermission(array(3))){
    echo '<div class="col-md-8">
        <div class="panel panel-default" >
            <div class="panel-heading">Available Race Sheets</div>
                <div class="panel-body">
                         <div class="table-responsive">
                         
                         <table width="98%" align="center" cellpadding="3" cellspacing="0"  class="table table-bordered">
                            <tbody>
                               <tr class="panel-heading">    
                                  <th style="color:#000;">Track and Date</th>
                                  <th style="color:#000;">Sheet Expiration</th>
                               </tr>'; ?>
								  <?php
                                  $dbsheets = fetchAllSheets($loggedInUser->user_id);
								  if($dbsheets != NULL){
									  foreach ($dbsheets as $sheets){
                                        $exp_date = date('m-d-Y H:i:s', strtotime($sheets['time'] . ' + 4 day'));
										// Returns the file name, less the extension.
										$sheet_id = $sheets['id'];
										$sheet_name = preg_replace('/.[^.]*$/', '', $sheets['sheet']);
										$sheet_name = substr($sheet_name, 0, -6);
										$sheet_track = $sheets['racetrack'];
										$sheet_date = date('m-d-Y', strtotime($sheets['racedate']));
										$date_now = new DateTime();
                                        echo "<tr style='background-color:#72c02c;text-align:center;'>
												<td><strong>".$sheet_track."</strong><br>".$sheet_date."</td>
												<td>".$exp_date;
		
												if ($date_now > $sheet_date) {
    													echo "<br><form action='user-delete-sheets.php' method='post' id='" .$sheet_track. "' class='deleteSheetSet'>
    													<button type='submit' class='btn btn-success pull-center btn-sm btn-block'>
    													<i class='fa fa-remove'></i>&nbsp;&nbsp;Delete This Set</button>
    													<input type='hidden' name='sheetId' value='".$sheet_id."' />
    													</form>";
												}
		
												echo "
												</td>
  												</tr>
                                                
												<tr>
												<td>
                                                <form style='display:inline' action='scripts/summary.php' method='post' enctype='multipart/form-data' target='_blank'>
                                                            <input type='hidden' name='card' value='" .$sheets['sheet']. "'>
                                                            <button type='submit' class='btn btn-primary btn-u-sm'><i class='fa fa-file-text-o'></i>&nbsp;&nbsp;Summary Sheet</button>
                                                </form>
												</td>
                                                </tr>
                                                <tr>                                                
                                                <td>												
												
												<form action='scripts/details_horse.php' method='post' enctype='multipart/form-data' target='_blank'>
												  <input type='hidden' name='card' value='" .$sheets['sheet']. "'>
												  <button type='submit' class='btn btn-info btn-u-sm'><i class='fa fa-file-text-o'></i>&nbsp;&nbsp;Past Performances</button>
												</form>
													</td>
                         						<td></td>
												</tr>";
                                        }
								  }
                                  ?>
                              <?php echo '</tbody>
                          </table>
                </div> 
            </div>
        </div>
    </div>
	
    <div class="col-md-4">
        <div class="panel panel-default" >
            <div class="panel-heading">Reserved Space</div>
                <div class="panel-body">
            </div>
        </div>
    </div>';
	}
	} //-- end is userLoggedIn()
	?>
    
    </div><!--/container-->
<?php include("modals.php"); ?>
<?php include("footer.php"); ?>
                    
</div><!--/wrapper-->
            
<?php
	// conditional logic here to check if user needs to update from a temporary password
	if ($userdetails['pass_change'] == '1'){// if it is 1, user has not yet updated from the issued temp password
	echo '<script type="text/javascript">$(document).ready(function(){'
	. '$("#passChangeDiv").dialog({
				modal: true,
				draggable: false,
				autoOpen: false,
				closeOnEscape: false,
				dialogClass: "no-close",
				height: 175,
				width: 400,
				buttons: [
				  {
					text: "OK",
					click: function() {
					  $( this ).dialog( "close" );
					}
				  }
				]
			});'
	.'$("#passChangeDiv").html("You are using a temporary password!<br />Please update your password in your user profile!");'		
	.'$("#passChangeDiv").dialog("open");'
	.'});'
    . '</script>';
	}							  
?>

</body>
</html>
