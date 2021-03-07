<?php
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
$permissionId = $_GET['id'];
//Check if selected permission level exists
if(!permissionIdExists($permissionId)){
	header("Location: admin_permissions.php"); die();	
}
// get all permission details
$permissionDetails = fetchPermissionDetails($permissionId); //Fetch information specific to permission level

$action = isset($_POST['action']) ? $_POST['action'] : null;

switch($action){
    case 'deleteGroup':
		$deletions = $_POST['delete'];
		if ($deletion_count = deletePermission($deletions)){
		$successes[] = lang("PERMISSION_DELETIONS_SUCCESSFUL", array($deletion_count));
		header("Location: admin_permissions.php"); die();	
		}
		else {
			$errors[] = lang("SQL_ERROR");	
		}
	break;
		
	case 'updateGroup':
		//Update permission level name
		if($permissionDetails['name'] != $_POST['name'] || $permissionDetails['access_level'] != $_POST['level'] || $permissionDetails['description'] != $_POST['descr']) {
			$permission = trim($_POST['name']);
			$level = trim($_POST['level']);
			$descr = trim($_POST['descr']);
			//Validate new name
			/*if (permissionNameExists($permission)){
			echo "2";
				$errors[] = lang("ACCOUNT_PERMISSIONNAME_IN_USE", array($permission));
			}*/
			if (minMaxRange(1, 50, $permission)){
				$errors[] = lang("ACCOUNT_PERMISSION_CHAR_LIMIT", array(1, 50));	
			}
			else {
				if (updatePermissionGroup($permissionId, $permission, $level, $descr)){
					//$successes[] = lang("PERMISSION_NAME_UPDATE", array($permission, $level, $descr));
					$successes[] = lang("PERMISSION_GROUP_UPDATE");
				}
				else {
					//$errors[] = lang("SQL_ERROR");
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
            <div class="panel-heading">Change Group Information</div>
            <div class="panel-body">
        <?php
            echo "
			<form name='adminPermission' action='".$_SERVER['PHP_SELF']."?id=".$permissionId."' method='post'>
            <input type='hidden' name='action' value='updateGroup'>
			<label>Group Name:</label>
			<input type='text' class='form-control' name='name' value='".$permissionDetails['name']."' /><br>
			<label>Access Level:</label>
			<input type='text' class='form-control' name='level' value='".$permissionDetails['access_level']."' /><br>
			<label>Description:</label>
			<input type='text' class='form-control' name='descr' value='".$permissionDetails['description']."' />
			<hr>
			<button type='submit' class='btn btn-success pull-right'><i class='fa fa-refresh'></i>&nbsp;&nbsp;Update Group Data</button>
			</form>";
		?>
            
			</div>
		</div>
        <div class="panel panel-default" >
            <div class="panel-heading">Delete Group</div>
            <div class="panel-body">
        <?php
            echo "
			<form name='adminDelete' action='".$_SERVER['PHP_SELF']."?id=".$permissionId."' method='post'>
			<input type='hidden' name='action' value='deleteGroup'>
			<p>
			<label>Warning! This action cannot be reversed!</label>
			<br><input type='hidden' name='delete[".$permissionDetails['id']."]' id='delete[".$permissionDetails['id']."]' value='".$permissionDetails['id']."'>
			</p><hr>
			<button type='submit' name='group-delete' class='btn btn-danger pull-right'><i class='fa fa-trash-o'></i>&nbsp;&nbsp;Delete Group</button>
			</form>";
		?>
            
			</div>
		</div>
	</div>
			
			<div class='col-md-4'>
        	<div class='panel panel-default' >
            <div class='panel-heading'>Group Membership</div>
            <div class='panel-body'>
        
		<?php
			echo "<form name='adminPermission' action='".$_SERVER['PHP_SELF']."?id=".$permissionId."' method='post'>
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
			</form>";
         ?>   
			</div>
			</div>
			</div>			
			
			<div class='col-md-4'>
        	<div class='panel panel-default' >
            <div class='panel-heading'>Page Access</div>
            <div class='panel-body'>
          
		<?php
			echo "<form name='adminPermission' action='".$_SERVER['PHP_SELF']."?id=".$permissionId."' method='post'>
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
  <?php include("modals.php"); ?>
<?php include("footer.php"); ?>
</div><!--/wrapper-->

</body>
</html>