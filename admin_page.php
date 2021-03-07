<?php
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
$pageId = $_GET['id'];
//Check if selected pages exist
if(!pageIdExists($pageId)){
	header("Location: admin_pages.php"); die();	
}
$pageDetails = fetchPageDetails($pageId); //Fetch information specific to page
//Forms posted

$action = isset($_POST['action']) ? $_POST['action'] : null;

switch($action){
    case 'updatePage':
        if(!empty($_POST['privpub'])){ 
		$private = $_POST['privpub']; 
        }
        //Toggle private page setting
        if (isset($private) AND $private == 'Yes'){
            if ($pageDetails['private'] == 0){
                if (updatePrivate($pageId, 1)){
                    $successes[] = lang("PAGE_PRIVATE_TOGGLED", array("private"));
                }
                else {
                    $errors[] = lang("SQL_ERROR");
                }
            }
        }
        elseif ($pageDetails['private'] == 1){
            if (updatePrivate($pageId, 0)){
                $successes[] = lang("PAGE_PRIVATE_TOGGLED", array("public"));
            }
            else {
                $errors[] = lang("SQL_ERROR");	
            }
        }
        break;
    case 'updateAccess':
        if(!empty($_POST['removePermission'])){
            $remove = $_POST['removePermission'];
            if ($deletion_count = removePage($pageId, $remove)){
                $successes[] = lang("PAGE_ACCESS_REMOVED", array($deletion_count));
            }
            else {
                $errors[] = lang("SQL_ERROR");	
            }
        }
        //Add permission level(s) access to page
        if(!empty($_POST['addPermission'])){
            $add = $_POST['addPermission'];
            if ($addition_count = addPage($pageId, $add)){
                $successes[] = lang("PAGE_ACCESS_ADDED", array($addition_count));
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
	
$pageDetails = fetchPageDetails($pageId);
$pagePermissions = fetchPagePermissions($pageId);
$permissionData = fetchAllPermissions();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Thoroughwiz | Admin Page Controls</title>
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
        <li class="active">Admin Page Control</li>
      </ul>
    </div>
  </div>
  <!--/breadcrumbs-->
  <!--=== End Breadcrumbs ===-->
  <!--=== Content Part ===-->
  <div class="container content">
  
	<?php include("assets/snippets/left-nav.php"); ?>

    <div class="row">
    
    <div class="col-md-6">
        <div class="panel panel-default" >
            <div class="panel-heading">Page Data</div>
            <div class="panel-body">
        <?php
			echo "
			<form name='adminPage' action='".$_SERVER['PHP_SELF']."?id=".$pageId."' method='post'>
			<input type='hidden' name='process' value='1'>
            <input type='hidden' name='action' value='updatePage'>
			<p>
			<label>ID:</label>
			".$pageDetails['id']."
			</p>
			<p>
			<label>Name:</label>
			".$pageDetails['page']."
			</p>
			<p>";
			//Display private checkbox
			if ($pageDetails['private'] == 1){
				echo "<label>Private:</label>&nbsp;<input type='radio' name='privpub' id='private' value='Yes' checked>&nbsp;&nbsp;&nbsp;&nbsp;";
				echo "<label>Public:</label>&nbsp;<input type='radio' name='privpub' id='public' value='No'>";
			}
			else {
				echo "<label>Private:</label>&nbsp;<input type='radio' name='privpub' id='private' value='Yes'>&nbsp;&nbsp;&nbsp;&nbsp;";
				echo "<label>Public:</label>&nbsp;<input type='radio' name='privpub' id='public' value='No' checked>";
			}
			echo "
			</p>
			<hr>
			<button type='submit' class='btn btn-success pull-right'><i class='fa fa-refresh'></i>&nbsp;&nbsp;Update Page</button>
			</form>
			</div>
			</div>
			</div>
			
			<div class='col-md-6'>
        	<div class='panel panel-default' >
            <div class='panel-heading'>Group Access</div>
            <div class='panel-body'>
            
			<form name='adminPage' action='".$_SERVER['PHP_SELF']."?id=".$pageId."' method='post'>
            <input type='hidden' name='action' value='updateAccess'>
			<p><strong>Current Access:</strong>";
			//Display list of permission levels with access
			foreach ($permissionData as $v1) {
				if(isset($pagePermissions[$v1['id']])){
					echo "<br><input type='checkbox' name='removePermission[".$v1['id']."]' id='removePermission[".$v1['id']."]' value='".$v1['id']."'> ".$v1['name'];
				}
			}
			echo"
			</p><p><strong>Allow Access:</strong>";
			//Display list of permission levels without access
			foreach ($permissionData as $v1) {
				if(!isset($pagePermissions[$v1['id']])){
					echo "<br><input type='checkbox' name='addPermission[".$v1['id']."]' id='addPermission[".$v1['id']."]' value='".$v1['id']."'> ".$v1['name'];
				}
			}
			echo"
			</p>
			<hr>
			<button type='submit' class='btn btn-success pull-right'><i class='fa fa-refresh'></i>&nbsp;&nbsp;Update Access</button>
			</form>";
			?>
      </div>
        </div>
      </div><!--/col-md-12-->
    </div><!--/row-->
  </div>
  <!--/container-->
  <!--=== End Content Part ===-->
<?php include("modals.php"); ?>
<?php include("footer.php"); ?>
</div><!--/wrapper-->

</body>
</html>