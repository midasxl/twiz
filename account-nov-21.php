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
    													echo "<br><form action='user-delete-sheets.php' method='post' id='deleteSheetSet'>
    													<button type='submit' class='btn btn-success pull-center btn-sm btn-block'>
    													<i class='fa fa-remove'></i>&nbsp;&nbsp;Delete This Set</button>
    													<input type='hidden' name='sheetId' value='".$sheet_id."' />
    													</form>";
												}
		
												echo "
												</td>
  												</tr>
                                                
												<tr>
												<td>";
                                                    if ($_SERVER["REQUEST_METHOD"] == "POST") { // if user applied filters
                                                        
                                                        function test_input($data) { // trim all white space, and strip all html and php tags
                                                              $data = trim($data);
                                                              $data = strip_tags($data);
                                                              return $data;
                                                        }
                                                        
                                                        /*foreach ($_POST as $key => $value) {
                                                            
                                                            echo $key;                                                            
                                                            echo $value;
                                                            
                                                        }*/
                                                        
                                                        if (isset($_POST['maxRaces'])){
                                                            $filter1=test_input($_POST['maxRaces']);
                                                        }
                                                        if (isset($_POST['remTrLines'])){
                                                            $filter2=test_input($_POST['remTrLines']);
                                                        }
                                                        if (isset($_POST['exclOffTracks'])){
                                                            $filter3=test_input($_POST['exclOffTracks']);
                                                        }
                                                        if (isset($_POST['finPos'])){
                                                            $filter4=test_input($_POST['finPos']);
                                                        }
                                                        if (isset($_POST['sameSurToday'])){
                                                            $filter5=test_input($_POST['sameSurToday']);
                                                        }
                                                        if (isset($_POST['distMinus'])){
                                                            $filter6=test_input($_POST['distMinus']);
                                                        }
                                                        if (isset($_POST['distPlus'])){
                                                            $filter7=test_input($_POST['distPlus']);
                                                        }

                                                        echo "<form style='display:inline' action='scripts/summary.php' method='post' enctype='multipart/form-data' target='_blank'>
                                                            <input type='hidden' name='card' value='" .$sheets['sheet']. "'>
                                                            <input type='hidden'  name='filter1val1' value='" .$filter1. "'>
                                                            <input type='hidden'  name='filter1val2' value='" .$filter2. "'>
                                                            <input type='hidden'  name='filter1val3' value='" .$filter3. "'>
                                                            <input type='hidden'  name='filter1val4' value='" .$filter4. "'>
                                                            <input type='hidden'  name='filter1val5' value='" .$filter5. "'>
                                                            <input type='hidden'  name='filter1val6' value='" .$filter6. "'>
                                                            <input type='hidden'  name='filter1val7' value='" .$filter7. "'>

                                                            <button type='submit' class='btn btn-success btn-u-sm'><i class='fa fa-file-text-o'></i>&nbsp;&nbsp;Summary Sheet</button>
                                                        </form>";
                                                    }else{// user did not apply filters
                                                        echo "<form style='display:inline' action='scripts/summary.php' method='post' enctype='multipart/form-data' target='_blank'>
                                                            <input type='hidden' name='card' value='" .$sheets['sheet']. "'>
                                                            <button type='submit' class='btn btn-success btn-u-sm'><i class='fa fa-file-text-o'></i>&nbsp;&nbsp;Summary Sheet</button>
                                                        </form>";
                                                    } 
                                                        
                                                echo "&nbsp;&nbsp;<a href='#' data-id='" .$sheets['sheet']. "' data-toggle='modal' data-target='#filters' class='runWithFilters'><i class='fa fa-filter'></i>&nbsp;Apply Filters</a>                                           
                                                </td>
                                                </tr>
                                                <tr>                                                
                                                <td>												
												
												<form action='scripts/details_horse.php' method='post' enctype='multipart/form-data' target='_blank'>
												  <input type='hidden' name='card' value='" .$sheets['sheet']. "'>
												  <button type='submit' class='btn btn-danger btn-u-sm'><i class='fa fa-file-text-o'></i>&nbsp;&nbsp;Past Performances</button>
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
                    <form name="updateAccount" id="user-update-form" action="user-update-account.php" method="post">';
                                  /*
					<p>
                    <label>User Name:</label>
                    <input type="text" class="form-control" value="'.$loggedInUser->username.'" disabled/>
                    </p>
					<p>
                    <label>Display Name:</label>
                    <input type="text" class="form-control" value="'.$loggedInUser->displayname.'" required/>
                    </p>*/
                    echo '
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
						<button class="btn-u pull-right"><i class="fa fa-refresh"></i>&nbsp;&nbsp;Change Password</button>
						<button type="reset" id="cancel-pw" class="btn-u btn-u-red pull-right" style="margin-right:5px;"><i class="fa fa-ban"></i>&nbsp;&nbsp;Cancel</button>
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
	echo '<div class="col-md-4">
        <div class="panel panel-default" >
            <div class="panel-heading">Payment Options</div>
                <div class="panel-body">
                         <div>                         
                         <p>A one-time transaction provides access to process a single TrackMaster .zip file.</p>'; ?> 
                         
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

          <p>10 Credit Package.  To be used at your discretion.  Save 50% compared to the single credit price!</p>
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

            </div> 
        </div>
    </div>
    </div><!--/col-md-4-->
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
                                  $dbcredits = fetchAllCredits($loggedInUser->user_id); //get all creditsw for this user funcs.php 1422
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
                              <?php echo '</tbody>
                          </table>
                </div> 
            </div>
        </div>
    </div>';
	?>
    <div class="col-md-5">
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
		
												//if ($date_now > $sheet_date) {
    													//echo "<br><form action='user-delete-sheets.php' method='post'>
    													//<button type='submit' class='btn btn-success pull-center btn-sm btn-block'>
    													//<i class='fa fa-remove'></i>&nbsp;&nbsp;Delete This Set</button>
    													//<input type='hidden' name='sheetId' value='".$sheet_id."' />
    													//</form>";
												//}
		
												echo "
												</td>
  												</tr>
												<tr>
												<td>
												<form action='scripts/test.php' method='post' enctype='multipart/form-data' target='_blank'>
												  <input type='hidden' name='card' value='" .$sheets['sheet']. "'>
												  <button type='submit' class='btn btn-primary btn-u-sm'><i class='fa fa-file-text-o'></i>&nbsp;&nbsp;Scratch Sheet</button>
												</form><br>
												
												<form action='scripts/summary.php' method='post' enctype='multipart/form-data' target='_blank'>
												  <input type='hidden' name='card' value='" .$sheets['sheet']. "'>
												  <button type='submit' class='btn btn-success btn-u-sm'><i class='fa fa-file-text-o'></i>&nbsp;&nbsp;Summary Sheet</button>
												</form><br>
												
												
												<form action='scripts/details_horse.php' method='post' enctype='multipart/form-data' target='_blank'>
												  <input type='hidden' name='card' value='" .$sheets['sheet']. "'>
												  <button type='submit' class='btn btn-danger btn-u-sm'><i class='fa fa-file-text-o'></i>&nbsp;&nbsp;Details by Horse</button>
												</form><br>

												<form action='scripts/details_race.php' method='post' enctype='multipart/form-data' target='_blank'>
												  <input type='hidden' name='card' value='" .$sheets['sheet']. "'>
												  <button type='submit' class='btn btn-warning btn-u-sm'><i class='fa fa-file-text-o'></i>&nbsp;&nbsp;Details by Race</button>
												</form><br>

<form action='scripts/details_Track.php' method='post' enctype='multipart/form-data' target='_blank'>
												  <input type='hidden' name='card' value='" .$sheets['sheet']. "'>
												  <button type='submit' class='btn btn-info btn-u-sm'><i class='fa fa-file-text-o'></i>&nbsp;&nbsp;Details by Track</button>
												</form><br>

<form action='scripts/details_distance.php' method='post' enctype='multipart/form-data' target='_blank'>
												  <input type='hidden' name='card' value='" .$sheets['sheet']. "'>
												  <button type='submit' class='btn btn-primary btn-u-sm'><i class='fa fa-file-text-o'></i>&nbsp;&nbsp;Details by Distance</button>
												</form><br>

<form action='scripts/details_Surface.php' method='post' enctype='multipart/form-data' target='_blank'>
												  <input type='hidden' name='card' value='" .$sheets['sheet']. "'>
												  <button type='submit' class='btn btn-success btn-u-sm'><i class='fa fa-file-text-o'></i>&nbsp;&nbsp;Details by Surface</button>
												</form><br>

<form action='scripts/last_race.php' method='post' enctype='multipart/form-data' target='_blank'>
												  <input type='hidden' name='card' value='" .$sheets['sheet']. "'>
												  <button type='submit' class='btn btn-danger btn-u-sm'><i class='fa fa-file-text-o'></i>&nbsp;&nbsp;Details by Last Race</button>
												</form><br>

<form action='scripts/details_off.php' method='post' enctype='multipart/form-data' target='_blank'>
												  <input type='hidden' name='card' value='" .$sheets['sheet']. "'>
												  <button type='submit' class='btn btn-warning btn-u-sm'><i class='fa fa-file-text-o'></i>&nbsp;&nbsp;Off Tracks</button>
												</form><br>
                                                <form action='scripts/whoran.php' method='post' enctype='multipart/form-data' target='_blank'>
												  <input type='hidden' name='card' value='" .$sheets['sheet']. "'>
												  <button type='submit' class='btn btn-info btn-u-sm'><i class='fa fa-file-text-o'></i>&nbsp;&nbsp;Extra Info</button>
												</form><br>

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
                                
    
    <?php if($userid == '30'){ //This is an interim solution.  in the future a database flag will determine VIP status                        
    echo '<div class="col-md-5">
        <div class="panel panel-default" >
            <div class="panel-heading">VIP Race Sheets</div>
                <div class="panel-body">
                         <div class="table-responsive">
                         
                         <table width="98%" align="center" cellpadding="3" cellspacing="0"  class="table table-bordered">
                            <tbody>
                               <tr class="panel-heading">    
                                  <th style="color:#000;">Track and Date</th>
                                  <th style="color:#000;">Sheet Expiration</th>
                               </tr>';
                                
                                  $dbsheets = fetchAllSheets(32); // gets all of Doug's sheets for this VIP user
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
		
												//if ($date_now > $sheet_date) {
    													//echo "<br><form action='user-delete-sheets.php' method='post'>
    													//<button type='submit' class='btn btn-success pull-center btn-sm btn-block'>
    													//<i class='fa fa-remove'></i>&nbsp;&nbsp;Delete This Set</button>
    													//<input type='hidden' name='sheetId' value='".$sheet_id."' />
    													//</form>";
												//}
		
												echo "
												</td>
  												</tr>
												<tr>
												<td>
												<form action='scripts/test.php' method='post' enctype='multipart/form-data' target='_blank'>
												  <input type='hidden' name='card' value='" .$sheets['sheet']. "'>
												  <button type='submit' class='btn btn-primary btn-u-sm'><i class='fa fa-file-text-o'></i>&nbsp;&nbsp;Scratch Sheet</button>
												</form><br>
												
												<form action='scripts/summary.php' method='post' enctype='multipart/form-data' target='_blank'>
												  <input type='hidden' name='card' value='" .$sheets['sheet']. "'>
												  <button type='submit' class='btn btn-success btn-u-sm'><i class='fa fa-file-text-o'></i>&nbsp;&nbsp;Summary Sheet</button>
												</form><br>
												
												
												<form action='scripts/details_horse.php' method='post' enctype='multipart/form-data' target='_blank'>
												  <input type='hidden' name='card' value='" .$sheets['sheet']. "'>
												  <button type='submit' class='btn btn-danger btn-u-sm'><i class='fa fa-file-text-o'></i>&nbsp;&nbsp;Details by Horse</button>
												</form><br>

												<form action='scripts/details_race.php' method='post' enctype='multipart/form-data' target='_blank'>
												  <input type='hidden' name='card' value='" .$sheets['sheet']. "'>
												  <button type='submit' class='btn btn-warning btn-u-sm'><i class='fa fa-file-text-o'></i>&nbsp;&nbsp;Details by Race</button>
												</form><br>

<form action='scripts/details_Track.php' method='post' enctype='multipart/form-data' target='_blank'>
												  <input type='hidden' name='card' value='" .$sheets['sheet']. "'>
												  <button type='submit' class='btn btn-info btn-u-sm'><i class='fa fa-file-text-o'></i>&nbsp;&nbsp;Details by Track</button>
												</form><br>

<form action='scripts/details_distance.php' method='post' enctype='multipart/form-data' target='_blank'>
												  <input type='hidden' name='card' value='" .$sheets['sheet']. "'>
												  <button type='submit' class='btn btn-primary btn-u-sm'><i class='fa fa-file-text-o'></i>&nbsp;&nbsp;Details by Distance</button>
												</form><br>

<form action='scripts/details_Surface.php' method='post' enctype='multipart/form-data' target='_blank'>
												  <input type='hidden' name='card' value='" .$sheets['sheet']. "'>
												  <button type='submit' class='btn btn-success btn-u-sm'><i class='fa fa-file-text-o'></i>&nbsp;&nbsp;Details by Surface</button>
												</form><br>

<form action='scripts/last_race.php' method='post' enctype='multipart/form-data' target='_blank'>
												  <input type='hidden' name='card' value='" .$sheets['sheet']. "'>
												  <button type='submit' class='btn btn-danger btn-u-sm'><i class='fa fa-file-text-o'></i>&nbsp;&nbsp;Details by Last Race</button>
												</form><br>

<form action='scripts/details_off.php' method='post' enctype='multipart/form-data' target='_blank'>
												  <input type='hidden' name='card' value='" .$sheets['sheet']. "'>
												  <button type='submit' class='btn btn-warning btn-u-sm'><i class='fa fa-file-text-o'></i>&nbsp;&nbsp;Off Tracks</button>
												</form><br>
                                                <form action='scripts/whoran.php' method='post' enctype='multipart/form-data' target='_blank'>
												  <input type='hidden' name='card' value='" .$sheets['sheet']. "'>
												  <button type='submit' class='btn btn-info btn-u-sm'><i class='fa fa-file-text-o'></i>&nbsp;&nbsp;Extra Info</button>
												</form><br>

												</td>
                         						<td></td>
												</tr>";
                                        }
								  }
                            echo'
                              </tbody>
                          </table>
                </div> 
            </div>
        </div>
    </div>';
    }?>
                                
                                
                                
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
										$sheet_name = preg_replace('/.[^.]*$/', '', $sheets['sheet']);
										$sheet_name = substr($sheet_name, 0, -6);
										$sheet_track = $sheets['racetrack'];
										$sheet_date = date('m-d-Y', strtotime($sheets['racedate']));
                                                echo "<tr style='background-color:#72c02c;'><td>".$sheet_track."&nbsp;&nbsp;".$sheet_date."</td><td>".$exp_date."</td></tr>
												<tr>
												<td>
												<form action='scripts/test.php' method='post' enctype='multipart/form-data' target='_blank'>
												  <input type='hidden' name='card' value='" .$sheets['sheet']. "'>
												  <button type='submit' class='btn btn-primary btn-u-sm'><i class='fa fa-file-text-o'></i>&nbsp;&nbsp;Scratch Sheet</button>
												</form><br>
												
												<form action='scripts/summary.php' method='post' enctype='multipart/form-data' target='_blank'>
												  <input type='hidden' name='card' value='" .$sheets['sheet']. "'>
												  <button type='submit' class='btn btn-success btn-u-sm'><i class='fa fa-file-text-o'></i>&nbsp;&nbsp;Summary Sheet</button>
												</form><br>
												
												
												<form action='scripts/details_horse.php' method='post' enctype='multipart/form-data' target='_blank'>
												  <input type='hidden' name='card' value='" .$sheets['sheet']. "'>
												  <button type='submit' class='btn btn-danger btn-u-sm'><i class='fa fa-file-text-o'></i>&nbsp;&nbsp;Details by Horse</button>
												</form><br>

												<form action='scripts/details_race.php' method='post' enctype='multipart/form-data' target='_blank'>
												  <input type='hidden' name='card' value='" .$sheets['sheet']. "'>
												  <button type='submit' class='btn btn-warning btn-u-sm'><i class='fa fa-file-text-o'></i>&nbsp;&nbsp;Details by Race</button>
												</form><br>

<form action='scripts/details_Track.php' method='post' enctype='multipart/form-data' target='_blank'>
												  <input type='hidden' name='card' value='" .$sheets['sheet']. "'>
												  <button type='submit' class='btn btn-info btn-u-sm'><i class='fa fa-file-text-o'></i>&nbsp;&nbsp;Details by Track</button>
												</form><br>

<form action='scripts/details_distance.php' method='post' enctype='multipart/form-data' target='_blank'>
												  <input type='hidden' name='card' value='" .$sheets['sheet']. "'>
												  <button type='submit' class='btn btn-primary btn-u-sm'><i class='fa fa-file-text-o'></i>&nbsp;&nbsp;Details by Distance</button>
												</form><br>

<form action='scripts/details_Surface.php' method='post' enctype='multipart/form-data' target='_blank'>
												  <input type='hidden' name='card' value='" .$sheets['sheet']. "'>
												  <button type='submit' class='btn btn-success btn-u-sm'><i class='fa fa-file-text-o'></i>&nbsp;&nbsp;Details by Surface</button>
												</form><br>

<form action='scripts/last_race.php' method='post' enctype='multipart/form-data' target='_blank'>
												  <input type='hidden' name='card' value='" .$sheets['sheet']. "'>
												  <button type='submit' class='btn btn-danger btn-u-sm'><i class='fa fa-file-text-o'></i>&nbsp;&nbsp;Details by Last Race</button>
												</form><br>

<form action='scripts/details_off.php' method='post' enctype='multipart/form-data' target='_blank'>
												  <input type='hidden' name='card' value='" .$sheets['sheet']. "'>
												  <button type='submit' class='btn btn-warning btn-u-sm'><i class='fa fa-file-text-o'></i>&nbsp;&nbsp;Off Tracks</button>
												</form><br>
                                                <form action='scripts/whoran.php' method='post' enctype='multipart/form-data' target='_blank'>
												  <input type='hidden' name='card' value='" .$sheets['sheet']. "'>
												  <button type='submit' class='btn btn-info btn-u-sm'><i class='fa fa-file-text-o'></i>&nbsp;&nbsp;Extra Info</button>
												</form><br>

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
    
    </div>
  </div>
  <!--/container-->
  <!--=== End Content Part ===-->
                    
  <?php include("footer.php"); ?>
                    
</div><!--/wrapper-->
            
<div id="form-messages" title="Thoroughwiz says..." style="text-align:center;padding:5px;"></div>
<div id="passChangeDiv" title="Thoroughwiz says..." style="text-align:center;padding:5px;"></div>
<div id="dialog-confirm" title="Delete this set of race sheets?"></div>
<div id="logOutDiv" title="Logging Out" style="display:none;text-align:center;padding:5px;">
    <img src="img/loading11.gif" alt="loading" />
</div>
            
<?php
	// conditional logic here to check if user needs to update from a temporary password
	if ($userdetails['pass_change'] == '1'){// if it is 1, user has not yet updated from the issues temp password
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
<script>
  $(document).ready(function(){
		
      $(".runWithFilters").click(function(){
          var passSheetId = $(this).data('id');// this is the value of bootstraps data-id
          $(".modal-body #sheetId").val(passSheetId);
      });
      
      $("#logOutButton").click(function(){
			$("#logOutDiv").dialog("open");
		});
	  
		$("#logOutDiv").dialog({
			modal: true,
			draggable: false,
			autoOpen: false,
			closeOnEscape: false,
			dialogClass: "no-close",
			height: 100
		});
		
	  	$("#deleteSheetSet").submit(function(e){	
			e.preventDefault();
			var killForm = $("#deleteSheetSet");
			var formData = $(killForm).serialize();
			var formMessages = $('#form-messages');
			$("#dialog-confirm").html("You are about to delete the selected sheet set.  Are you sure?");
					$("#dialog-confirm").dialog({
						autoOpen: false,
						modal: true,
						buttons : {
					        "Delete Sheet Set" : function() {
					        	killSheetSet(formData, formMessages);
					        	$(this).dialog("close");
					        },
					        "Cancel" : function() {
					        	$(this).dialog("close");
					        }
					      }
					});
			$("#dialog-confirm").dialog("open");
		});

		function killSheetSet(formData, formMessages){
	  	$.ajax({
			  url: 'user-delete-sheets.php',
			  type: 'POST',
			  data: formData,
			  dataType: 'json',
			  	success: function(data) {
					$(formMessages).html(data[0]);
					//$(formMessages).html(data);
					$(formMessages).dialog({
						autoOpen: false,
						modal: true,
						buttons: [ { 
							text: "Ok", click: function() { 
								location.reload(true);
								$(this).dialog("close");
							} 
						}]
					});
					$(formMessages).dialog("open");
				},
			  	error: function(response, xhr) {
				  	console.log(response);
			  		$(formMessages).html(xhr.responseText);
					//$(formMessages).html("The system has encountered an error");
					$(formMessages).dialog({
						autoOpen: false,
						modal: true,
						buttons: [ { 
							text: "Ok", click: function() { 
								$(this).dialog("close");
							} 
						}]
					});
					$(formMessages).dialog("open");
			  	}
			}); // end ajax call
		} // end killSheetSet function

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

//$(document).ajaxStop(function() { location.reload(true); });
</script>
</body>
</html>
