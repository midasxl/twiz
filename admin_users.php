<?php
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

$userData = fetchAllUsers(); //Fetch information for all users
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Thoroughwiz | Admin Users</title>
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
        <li class="active">Admin Users</li>
      </ul>
    </div>
  </div>
  <!--/breadcrumbs-->
  <!--=== End Breadcrumbs ===-->
  <!--=== Content Part ===-->
  <div class="container content">
  
	<?php include("assets/snippets/left-nav.php"); ?>
    
    <div class="row">
    <div class="col-md-12">
        <div class="panel panel-default" >
            <div class="panel-heading">Current Thoroughwiz Members</div>
                <div class="panel-body">
                         <div class="table-responsive">
                         <table width="98%" align="center" cellpadding="3" cellspacing="0"  class="table table-bordered" id="stacktable">
                            <tbody>
                               <tr>    
                                  <th>User ID</th>
                                  <th>Member Level</th>
                                  <th>Email Address</th>
                                  <th>Last Sign In</th>
                                  <th>Account Active?</th>
                               </tr>
        <?php
			foreach ($userData as $v1) {
				echo "
				<tr>
				<td><a href='admin_user.php?id=".$v1['id']."'>".$v1['id']."</td>
				<td>".$v1['title']."</td>
				<td><a href='mailto:".$v1['email']."'>".$v1['email']."</td>
				<td>
				";
				//Interpret last login
				if ($v1['last_sign_in_stamp'] == '0'){
					echo "Never";	
				}
				else {
					echo date("j M, Y", $v1['last_sign_in_stamp']);
				}
				echo "
				</td>";
				if ($v1['active'] == '1'){
				echo "<td>Yes</td>";
				}else{
				echo "<td>No</td>";
				}
				echo "</tr>";
			}
			?>
            </tbody>
			</table>
                </div> 
            </div>
        </div>
    </div>
      <!--/col-md-12-->
    </div>
    <!--/row-->
  </div>
  <!--/container-->
  <!--=== End Content Part ===-->
  <?php include("modals.php"); ?>
<?php include("footer.php"); ?>
</div><!--/wrapper-->
<script src="assets/js/stacktable.js"></script>
<script>
$('#stacktable').stacktable();
</script>

</body>
</html>