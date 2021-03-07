<?php
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

//Forms posted
if(!empty($_POST))
{
	//Create new permission level
	if(!empty($_POST['newPermission'])) {
		$permission = trim($_POST['newPermission']);
		$level = trim($_POST['newLevel']);
		$descr = trim($_POST['newDescr']);
		//Validate request
		if (permissionNameExists($permission)){
			$errors[] = lang("PERMISSION_NAME_IN_USE", array($permission));
		}
		elseif (minMaxRange(1, 50, $permission)){
			$errors[] = lang("PERMISSION_CHAR_LIMIT", array(1, 50));	
		}
		else{
			if (createPermission($permission,$level,$descr)) {
			$successes[] = lang("PERMISSION_CREATION_SUCCESSFUL", array($permission));
		}
			else {
				$errors[] = lang("SQL_ERROR");
			}
		}
	}
}
$permissionData = fetchAllPermissions(); //Retrieve list of all permission levels
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Thoroughwiz | Permission Groups</title>
<!-- Meta Data -->
<?php include("meta.php"); ?>
<!-- CSS Import -->
<?php include("style_block.php"); ?>
<!-- CSS Page Specific -->
<link rel="stylesheet" href="assets/css/stacktable.css" media="screen" />
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
        <li class="active">Permission Groups</li>
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
                <div class="panel-heading">Permission Groups</div>
                    <div class="panel-body">
                         <div class="table-responsive">
                             <table width="98%" align="center" cellpadding="3" cellspacing="0"  class="table table-bordered" id="stacktable">
                                <tbody>
                                    <tr>    
                                      <th>Group ID</th>
                                      <th>Group Name</th>
                                      <th>Access Level</th>
                                      <th>Description</th>
                                    </tr>
                                    <?php
                                        //List each permission level
                                        foreach ($permissionData as $v1) {
                                            echo "
                                            <tr>
                                            <td>".$v1['id']."</td>
                                            <td><a href='admin_permission.php?id=".$v1['id']."'>".$v1['name']."</a></td>
                                            <td>".$v1['access_level']."</td>
                                            <td>".$v1['description']."</td>
                                            </tr>";
                                    }
                                    ?>
                                </tbody>
                             </table>
                        </div> 
                    </div>
            </div>
        </div><!--/col-md-8-->
        <div class="col-md-4">
            <div class="panel panel-default" >
                <div class="panel-heading">Create New Group</div>
                <div class="panel-body">
                    <form name='adminPermissions' <?php echo "action='".$_SERVER['PHP_SELF']."'"; ?> method='post'>
					<label>Group Name:</label>
                    <input type='text' class='form-control' name='newPermission' required /><br />
					<label>Access Level:</label>
                    <input type='text' class='form-control' name='newLevel' required /><br />
					<label>Description:</label>
                    <input type='text' class='form-control' name='newDescr' required />
					<hr>
                    <button type='submit' class='btn btn-success pull-right'><i class='fa fa-plus-square'></i>&nbsp;&nbsp;Create Group</button>
                    </form>
                </div>
            </div>
        </div><!--/col-md-4-->
    </div><!--/row-->
    </div><!--/container-->
    <?php include("modals.php"); ?>
<?php include("footer.php"); ?>
</div><!--/wrapper-->
<script src="assets/js/stacktable.js"></script>
<script>
    $('#stacktable').stacktable();
</script>

</body>
</html>