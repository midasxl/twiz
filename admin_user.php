<?php
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
//assign posted id to a variable
$userId = $_GET['id'];
//Check if selected user exists
if(!userIdExists($userId)){
	header("Location: admin_users.php"); die();
}
//get all user details
$userdetails = fetchUserDetails(NULL, NULL, $userId); //Fetch user details

$action = isset($_POST['action']) ? $_POST['action'] : null;

switch($action){
    case 'deactivateUser':
		$displayname = trim($_POST['display']);
			if (setUserInActive($userdetails['activation_token'])){
				$successes[] = lang("ACCOUNT_MANUALLY_DEACTIVATED", array($displayname));
			}
			else {
				$errors[] = lang("SQL_ERROR");
			}
	break;
	case 'activateUser':
		$displayname = trim($_POST['display']);
			if (setUserActive($userdetails['activation_token'])){
				$successes[] = lang("ACCOUNT_MANUALLY_ACTIVATED", array($displayname));
			}
			else {
				$errors[] = lang("SQL_ERROR");
			}
	break;
	case 'updatePerms':
		if(!empty($_POST['removePermission'])){
			$remove = $_POST['removePermission'];
			if ($deletion_count = removePermission($remove, $userId)){
				$successes[] = lang("ACCOUNT_PERMISSION_REMOVED", array ($deletion_count));
			}
			else {
				$errors[] = lang("SQL_ERROR");
			}
		}
		if(!empty($_POST['addPermission'])){
			$add = $_POST['addPermission'];
			if ($addition_count = addPermission($add, $userId)){
				$successes[] = lang("ACCOUNT_PERMISSION_ADDED", array ($addition_count));
			}
			else {
				$errors[] = lang("SQL_ERROR");
			}
		}
    break;
	case 'deleteUser':
		$deletions = $_POST['delete'];
		if ($deletion_count = deleteUsers($deletions)) {
			$successes[] = lang("ACCOUNT_DELETIONS_SUCCESSFUL", array($deletion_count));
			header("Location: https://thoroughwiz.com/sheets/admin_users.php"); /* Redirect browser */
			exit();
		}
		else {
			$errors[] = lang("SQL_ERROR");
		}
    break;
    default:
        //action not found
        break;
}



/* old way, legacy code
$deleteUser = isset($_POST['user-delete']);
if ($deleteUser) {
	if(!empty($_POST['delete'])){
		$deletions = $_POST['delete'];
		if ($deletion_count = deleteUsers($deletions)) {
			$successes[] = lang("ACCOUNT_DELETIONS_SUCCESSFUL", array($deletion_count));
			header("Location: https://thoroughwiz.com/sheets/admin_users.php");
			exit();
		}
		else {
			$errors[] = lang("SQL_ERROR");
		}
	}
}

$updatePermissions = isset($_POST['update-perms']);
if ($updatePermissions) {
		if(!empty($_POST['removePermission'])){
			$remove = $_POST['removePermission'];
			if ($deletion_count = removePermission($remove, $userId)){
				$successes[] = lang("ACCOUNT_PERMISSION_REMOVED", array ($deletion_count));
			}
			else {
				$errors[] = lang("SQL_ERROR");
			}
		}
		if(!empty($_POST['addPermission'])){
			$add = $_POST['addPermission'];
			if ($addition_count = addPermission($add, $userId)){
				$successes[] = lang("ACCOUNT_PERMISSION_ADDED", array ($addition_count));
			}
			else {
				$errors[] = lang("SQL_ERROR");
			}
		}
}

$modActiveStatus = isset($_POST['userActiveStatus']);
if ($modActiveStatus) {
	if (!empty($_POST['activate'])) {
			$displayname = trim($_POST['display']);
			if(isset($_POST['activate']) && $_POST['activate'] == "activate"){
				if (setUserActive($userdetails['activation_token'])){
					$successes[] = lang("ACCOUNT_MANUALLY_ACTIVATED", array($displayname));
				}
				else {
					$errors[] = lang("SQL_ERROR");
				}
			}
	}
	if (!empty($_POST['deactivate'])) {
			$displayname = trim($_POST['display']);
			if(isset($_POST['deactivate']) && $_POST['deactivate'] == "deactivate"){
				if (setUserInActive($userdetails['activation_token'])){
					$successes[] = lang("ACCOUNT_MANUALLY_DEACTIVATED", array($displayname));
				}
				else {
					$errors[] = lang("SQL_ERROR");
				}
			}
	}
}*/
		
$userdetails = fetchUserDetails(NULL, NULL, $userId);
$userPermission = fetchUserPermissions($userId);
$permissionData = fetchAllPermissions();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Thoroughwiz | Admin User...</title>
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
            <li class="active">Admin User</li>
            </ul>
        </div>
    </div>
    <!--/breadcrumbs-->
    <!--=== End Breadcrumbs ===-->
	<!--=== Content Part ===-->
	<div class="container content">
  
	<?php include("assets/snippets/left-nav.php"); ?>

    <div class="row">
    <div class="col-md-4">
        <div class="panel panel-default" >
            <div class="panel-heading">User Data</div>
            <div class="panel-body">
            <?php
                echo "
                <p>			
                <label>User ID:&nbsp;&nbsp;</label>
                ".$userdetails['id']."
                </p>
                <p>
                <label>Email Address:&nbsp;&nbsp;</label>
                ".$userdetails['email']."
                </p>
                <p>
                <label>Member Level:&nbsp;&nbsp;</label>
                ".$userdetails['title']."
                </p>
                <p>
                <label>Registration Date:&nbsp;&nbsp;</label>
                ".date("j M, Y", $userdetails['sign_up_stamp'])."
                </p>
                <p>
                <label>Last Access Date:&nbsp;&nbsp;&nbsp;</label>";
                
                //Last sign in, interpretation
    
                if ($userdetails['last_sign_in_stamp'] == '0'){
                    echo "  Never";	
                }
                else {
                    echo date("j M, Y", $userdetails['last_sign_in_stamp']);
                };
                
                echo "</p>";
				
				// show number of credits user has if any
				$dbcredits = fetchAllCredits($userId); //get all credits for this user
					foreach ($dbcredits as $credits){
							if($credits['credits'] > 0){
							echo "<p><label>Sheet Credits:&nbsp;&nbsp;</label>
							".$credits['credits']."</p>";
							} else {
							echo "<p><label>Sheet Credits:&nbsp;&nbsp;</label>0</p>";
							}
				}
                //Display activation link, if account inactive
    
                if ($userdetails['active'] == '1'){
                    echo "<p style='color:green;'><label>Active Status:&nbsp;&nbsp;&nbsp;</label>Active</p>
                    <form name='adminUser' action='".$_SERVER['PHP_SELF']."?id=".$userId."' method='post'>
					<input type='hidden' name='action' value='deactivateUser'>
					<input type='hidden' name='display' value='".$userdetails['display_name']."' />
                    <button type='submit' name='userActiveStatus' class='btn btn-success pull-right'><i class='fa fa-toggle-on'></i>&nbsp;&nbsp;Deactivate User</button>
					</form>";
                }
                else{
                    echo "<p style='color:red;'><label>Active Status:&nbsp;&nbsp;&nbsp;</label>Inactive User!</p>
                    <form name='adminUser' action='".$_SERVER['PHP_SELF']."?id=".$userId."' method='post'>
					<input type='hidden' name='action' value='activateUser'>
					<input type='hidden' name='display' value='".$userdetails['display_name']."' />
                    <button type='submit' name='userActiveStatus' class='btn btn-success pull-right'><i class='fa fa-toggle-on'></i>&nbsp;&nbsp;Activate User</button>
					</form>";
                }
			?>
            </div>
        </div>
    </div>
            
    <div class="col-md-4">
        <div class="panel panel-default" >
            <div class="panel-heading">User Permissions</div>
            <div class="panel-body">
                <?php
                echo "<form name='adminPerms' action='".$_SERVER['PHP_SELF']."?id=".$userId."' method='post'>
				<input type='hidden' name='action' value='updatePerms'>
                <p>Current Permission Levels (select to remove):&nbsp;&nbsp;";
                
                foreach ($permissionData as $v1) {
                    if(isset($userPermission[$v1['id']])){
                        echo "<br><input type='checkbox' name='removePermission[".$v1['id']."]' id='removePermission[".$v1['id']."]' value='".$v1['id']."'> ".$v1['name'];
                    }
                }

                echo "</p><p>Available Permission Levels (select to add):&nbsp;&nbsp;";
                
                foreach ($permissionData as $v1) {
                    if(!isset($userPermission[$v1['id']])){
                        echo "<br><input type='checkbox' name='addPermission[".$v1['id']."]' id='addPermission[".$v1['id']."]' value='".$v1['id']."'> ".$v1['name'];
                    }
                }
                
                echo "</p><hr><button type='submit' name='update-perms' class='btn btn-success pull-right'><i class='fa fa-refresh'></i>&nbsp;&nbsp;Update Permissions</button>
                </form>";
                ?>
            </div>
        </div>
    </div>
            
    <div class="col-md-4">
        <div class="panel panel-default" >
            <div class="panel-heading">Delete User</div>
            <div class="panel-body">
                <?php
                echo "
                <form name='adminDelete' action='".$_SERVER['PHP_SELF']."?id=".$userId."' method='post'>
				<input type='hidden' name='action' value='deleteUser'>
                <p>
                <label>Warning! This action cannot be reversed!</label>
                <br><input type='hidden' name='delete[".$userdetails['id']."]' id='delete[".$userdetails['id']."]' value='".$userdetails['id']."'>
                </p><hr>
                <button type='submit' name='user-delete' class='btn btn-success pull-right'><i class='fa fa-trash-o'></i>&nbsp;&nbsp;Delete User</button>
                </form>";
                ?>
            </div>
        </div>
    </div>
    </div><!--/row-->
  </div><!--/container-->
  <!--=== End Content Part ===-->
    <?php include("modals.php"); ?>
<?php include("footer.php"); ?>
</div><!--/wrapper-->

</body>
</html>