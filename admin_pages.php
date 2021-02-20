<?php
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

$pages = getPageFiles(); //Retrieve list of pages in root folder
$dbpages = fetchAllPages(); //Retrieve list of pages in pages table
$creations = array();
$deletions = array();

//Check if any pages exist which are not in DB
foreach ($pages as $page){
	if(!isset($dbpages[$page])){
		$creations[] = $page;	
	}
}

//Enter new pages in DB if found
if (count($creations) > 0) {
	createPages($creations)	;
}

if (count($dbpages) > 0){
	//Check if DB contains pages that don't exist
	foreach ($dbpages as $page){
		if(!isset($pages[$page['page']])){
			$deletions[] = $page['id'];	
		}
	}
}

//Delete pages from DB if not found
if (count($deletions) > 0) {
	deletePages($deletions);
}

//Update DB pages
$dbpages = fetchAllPages();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Thoroughwiz | Admin Pages</title>
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
        <li class="active">Admin Pages</li>
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
            <div class="panel-heading">Private Pages</div>
                <div class="panel-body">
                         <div class="table-responsive">
                         <table width="98%" align="center" cellpadding="3" cellspacing="0"  class="table table-bordered">
                            <tbody>
                               <tr>    
                                  <th>Page ID</th>
                                  <th>Page Name</th>
                               </tr>
        <?php
            //Display list of pages
            foreach ($dbpages as $page){
                if($page['private'] == 1){
                    echo "
                    <tr>
                    <td>".$page['id']."</td><td><a href ='admin_page.php?id=".$page['id']."'>".$page['page']."</a></td>
                    </tr>";
                }
            }
			?>
            </tbody>
            </table>
                </div> 
            </div>
        </div>
    </div><!--/col-md-6-->
    <div class="col-md-6">
        <div class="panel panel-default" >
            <div class="panel-heading">Public Pages</div>
                <div class="panel-body">
                         <div class="table-responsive">
                         <table width="98%" align="center" cellpadding="3" cellspacing="0"  class="table table-bordered">
                            <tbody>
                               <tr>    
                                  <th>Page ID</th>
                                  <th>Page Name</th>
                               </tr>
        <?php
            //Display list of pages
            foreach ($dbpages as $page){
                if($page['private'] == 0){
                    echo "
                    <tr>
                    <td>".$page['id']."</td><td><a href ='admin_page.php?id=".$page['id']."'>".$page['page']."</a></td>
                    </tr>";
                }
            }
			?>
            </tbody>
            </table>
                </div>
              </div>
            </div>
      </div><!--/col-md-6-->
    </div><!--/row-->
  </div><!--/container-->
  <!--=== End Content Part ===-->
  <?php include("footer.php"); ?>
    <?php include("modals.php"); ?>
</div><!--/wrapper-->
</body>
</html>