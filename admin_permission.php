<?php
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
$permissionId = $_GET['id'];
//Check if selected permission level exists
if(!permissionIdExists($permissionId)){
	header("Location: admin_permissions.php"); die();	
}

$permissionDetails = fetchPermissionDetails($permissionId); //Fetch information specific to permission level

$action = isset($_POST['action']) ? $_POST['action'] : null;

switch($action){
    case 'updateGroup':
        if(!empty($_POST['delete'])){// if checkbox is checked, user wants to delete the group
		$deletions = $_POST['delete'];
		if ($deletion_count = deletePermission($deletions)){
		$successes[] = lang("PERMISSION_DELETIONS_SUCCESSFUL", array($deletion_count));
		header("Location: admin_permissions.php"); die();	
		}
		else {
			$errors[] = lang("SQL_ERROR");	
		}
	}
	else // user wants to update the name of the group
	{
		//Update permission level name
		if($permissionDetails['name'] != $_POST['name']) {
			$permission = trim($_POST['name']);
			//Validate new name
			if (permissionNameExists($permission)){
				$errors[] = lang("ACCOUNT_PERMISSIONNAME_IN_USE", array($permission));
			}
			elseif (minMaxRange(1, 50, $permission)){
				$errors[] = lang("ACCOUNT_PERMISSION_CHAR_LIMIT", array(1, 50));	
			}
			else {
				if (updatePermissionName($permissionId, $permission)){
					$successes[] = lang("PERMISSION_NAME_UPDATE", array($permission));
				}
				else {
					$errors[] = lang("SQL_ERROR");
				}
			}
		}
	}
        break;
    case 'updateMembers':
        // Remove user from permission group
		if(!empty($_POST['removePermission'])){
			$remove = $_POST['removePermission'];
			if ($deletion_count = removePermission($permissionId, $remove)) {
				$successes[] = lang("PERMISSION_REMOVE_USERS", array($deletion_count));
			}
			else {
				$errors[] = lang("SQL_ERROR");
			}
		}
		// Add user to permission group
		if(!empty($_POST['addPermission'])){
			$add = $_POST['addPermission'];
			if ($addition_count = addPermission($permissionId, $add)) {
				$successes[] = lang("PERMISSION_ADD_USERS", array($addition_count));
			}
			else {
				$errors[] = lang("SQL_ERROR");
			}
		}
        break;
    case 'updatePages':
        //Remove access to pages
		if(!empty($_POST['removePage'])){
			$remove = $_POST['removePage'];
			if ($deletion_count = removePage($remove, $permissionId)) {
				$successes[] = lang("PERMISSION_REMOVE_PAGES", array($deletion_count));
			}
			else {
				$errors[] = lang("SQL_ERROR");
			}
		}
		//Add access to pages
		if(!empty($_POST['addPage'])){
			$add = $_POST['addPage'];
			if ($addition_count = addPage($add, $permissionId)) {
				$successes[] = lang("PERMISSION_ADD_PAGES", array($addition_count));
			}
			else {
				$errors[] = lang("SQL_ERROR");
			}
		}
        break;
    default:
        //action not found
        break;
}

$permissionDetails = fetchPermissionDetails($permissionId);	
$pagePermissions = fetchPermissionPages($permissionId); //Retrieve list of accessible pages
$permissionUsers = fetchPermissionUsers($permissionId); //Retrieve list of users with membership
$userData = fetchAllUsers(); //Fetch all users
$pageData = fetchAllPages(); //Fetch all pages
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Thoroughwiz | Admin Permissions</title>
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
        <li class="active">Admin Permission Group</li>
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
            <div class="panel-heading">Permission Group</div>
            <div class="panel-body">
        <?php
            echo "
			<form name='adminPermission' action='".$_SERVER['PHP_SELF']."?id=".$permissionId."' method='post'>
            <input type='hidden' name='action' value='updateGroup'>
			<p>
			<label>ID:</label>
			".$permissionDetails['id']."
			</p>			
			<p>
			<label>Name:</label>
			<input type='text' class='form-control' name='name' value='".$permissionDetails['name']."' />
			</p>
			<input type='checkbox' name='delete[".$permissionDetails['id']."]' id='delete[".$permissionDetails['id']."]' value='".$permissionDetails['id']."'>&nbsp;Delete This Group
			</p>
			<hr>
            <button type='submit' class='btn btn-success pull-right'><i class='fa fa-refresh'></i>&nbsp;&nbsp;Update Group</button>
			</form>
            
			</div>
			</div>
			</div>
			
			<div class='col-md-4'>
        	<div class='panel panel-default' >
            <div class='panel-heading'>Group Membership</div>
            <div class='panel-body'>
            
			<form name='adminPermission' action='".$_SERVER['PHP_SELF']."?id=".$permissionId."' method='post'>
            <input type='hidden' name='action' value='updateMembers'>
			<p><strong>Current Group Membership (select to remove):</strong>";
			//List users with permission level
			foreach ($userData as $v1) {
				if(isset($permissionUsers[$v1['id']])){
					echo "<br><input type='checkbox' name='removePermission[".$v1['id']."]' id='removePermission[".$v1['id']."]' value='".$v1['id']."'> ".$v1['email'];
				}
			}
			echo"
			</p>
            <p><strong>Non-members (select to add):</strong>";
			//List users without permission level
			foreach ($userData as $v1) {
				if(!isset($permissionUsers[$v1['id']])){
					echo "<br><input type='checkbox' name='addPermission[".$v1['id']."]' id='addPermission[".$v1['id']."]' value='".$v1['id']."'> ".$v1['email'];
				}
			}
			echo"
			</p>
			<hr>
            <button type='submit' class='btn btn-success pull-right'><i class='fa fa-refresh'></i>&nbsp;&nbsp;Update Members</button>
			</form>
            
			</div>
			</div>
			</div>			
			
			<div class='col-md-4'>
        	<div class='panel panel-default' >
            <div class='panel-heading'>Page Access</div>
            <div class='panel-body'>
            
			<form name='adminPermission' action='".$_SERVER['PHP_SELF']."?id=".$permissionId."' method='post'>
            <input type='hidden' name='action' value='updatePages'>
			<p>
			<strong>Allowed to Access:</strong>";
			//List pages accessible to permission level
			foreach ($pageData as $v1) {
				if(isset($pagePermissions[$v1['id']]) AND $v1['private'] == 1){
					echo "<br><input type='checkbox' name='removePage[".$v1['id']."]' id='removePage[".$v1['id']."]' value='".$v1['id']."'> ".$v1['page'];
				}
			}
			echo"
			</p>
			<p>
			<strong>Not Allowed to Access:</strong>";
			//List pages inaccessible to permission level
			foreach ($pageData as $v1) {
				if(!isset($pagePermissions[$v1['id']]) AND $v1['private'] == 1){
					echo "<br><input type='checkbox' name='addPage[".$v1['id']."]' id='addPage[".$v1['id']."]' value='".$v1['id']."'> ".$v1['page'];
				}
			}
			echo"
			</p>
			<hr>
            <button type='submit' class='btn btn-success pull-right'><i class='fa fa-refresh'></i>&nbsp;&nbsp;Update Pages</button>
			</form>
			</div>
			</div>
			</div>";
			?>
            </div><!--/panel-body-->
        </div><!--/panel-->
        </div><!--/col-md-4-->
    </div><!--/row-->
  </div><!--/container-->
  <!--=== End Content Part ===-->
  <?php include("footer.php"); ?>
    <?php include("modals.php"); ?>
</div><!--/wrapper-->
</body>
</html>