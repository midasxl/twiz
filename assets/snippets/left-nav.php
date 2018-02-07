<?php
if (!securePage($_SERVER['PHP_SELF'])){die();}
?>

<div class="navbar navbar-default" role="navigation">
  <div class="container">
    <div class="navbar-header">
    
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-responsive-collapse2">
        <span class="sr-only">Toggle navigation</span>
        <span class="fa fa-bars"></span>
       </button>
      
      <!--<div class="navbar-brand"><?php //echo "$loggedInUser->displayname!" ?></div>-->
    </div>
    <div class="collapse navbar-collapse navbar-responsive-collapse2">
      <ul class="nav navbar-nav">
		<?php
		//Links for logged in user
		if(isUserLoggedIn()) {
			//Links for permission level 1 (Administrator)
			if ($loggedInUser->checkPermission(array(1))){
			echo "
			<li><a href='account.php'>Account Home</a></li>
			<li><a href='page_admin.php'>Process Sheet</a></li>
    		<li><a href='page_admin_harness.php'>Process Harness Sheet</a></li>
			<li><a href='admin_configuration.php'>Configuration</a></li>
			<li><a href='admin_users.php'>Users</a></li>
			<li><a href='admin_permissions.php'>Permissions</a></li>
			<li><a href='admin_pages.php'>Pages</a></li>
			<li><a id='logOutButton' href='logout.php'>Logout</a></li>";
            //<li><button type='button' id='logOutButton' class='btn btn-warning btn-xs'>Log Out</button></li>";
			}
			//Links for permission level 2 (Base Member)
			if ($loggedInUser->checkPermission(array(2))){
			echo "
			<li><a href='account.php'>Account Home</a></li>
			<li><a href='user-profile.php'>User Profile</a></li>
            <li><a id='logOutButton' href='logout.php'>Logout</a></li>";
			}
			//Links for permission level 3 (Subscription Member)
			if ($loggedInUser->checkPermission(array(3))){
			echo "
			<li><a href='account.php'>Account Home</a></li>
			<li><a href='access.php'>Process Sheet</a></li>
			<li><a href='user-profile.php'>User Profile</a></li>            
			<li><a id='logOutButton' href='logout.php'>Logout</a></li>";
			}
		} 
        echo resultBlock($errors,$successes);
        ?>
      </ul>
    </div><!--/.nav-collapse -->
  </div>
</div>