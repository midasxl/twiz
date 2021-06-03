<?php
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

$languages = getLanguageFiles(); //Retrieve list of language files
$templates = getTemplateFiles(); //Retrieve list of template files
$permissionData = fetchAllPermissions(); //Retrieve list of all permission levels
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Thoroughwiz | Admin Configuration</title>
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
        <li class="active">Admin Configuration</li>
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
            <div class="panel-heading">Configuration</div>
                <div class="panel-body">
        <?php
			echo "<form name='adminConfiguration' id='admin-configuration-form' action='admin-update-configuration.php' method='post'>
			<p>
			<label>Website Name:</label>
			<input type='text' class='form-control' name='settings[".$settings['website_name']['id']."]' value='".$websiteName."' />
			</p>
			<p>
			<label>Website URL:</label>
			<input type='text' class='form-control' name='settings[".$settings['website_url']['id']."]' value='".$websiteUrl."' />
			</p>
			<p>
			<label>Email:</label>
			<input type='text' class='form-control' name='settings[".$settings['email']['id']."]' value='".$emailAddress."' />
			</p>
			<p>
			<label>Activation Threshold:</label>
			<input type='text' class='form-control' name='settings[".$settings['resend_activation_threshold']['id']."]' value='".$resend_activation_threshold."' />
			</p>
			<p>
			<label>Language:</label>
			<select class='form-control' name='settings[".$settings['language']['id']."]'>";
			//Display language options
			foreach ($languages as $optLang){
				if ($optLang == $language){
					echo "<option value='".$optLang."' selected>$optLang</option>";
				}
				else {
					echo "<option value='".$optLang."'>$optLang</option>";
				}
			}
			echo "
			</select>
			</p>
			<p>
			<label>Email Activation:</label>
			<select class='form-control' name='settings[".$settings['activation']['id']."]'>";
			//Display email activation options
			if ($emailActivation == "true"){
				echo "
				<option value='true' selected>True</option>
				<option value='false'>False</option>
				</select>";
			}
			else {
				echo "
				<option value='true'>True</option>
				<option value='false' selected>False</option>
				</select>";
			}
			echo "</p>
			<p>
			<label>Template:</label>
			<select class='form-control' name='settings[".$settings['template']['id']."]'>";
			//Display template options
			foreach ($templates as $temp){
				if ($temp == $template){
					echo "<option value='".$temp."' selected>$temp</option>";
				}
				else {
					echo "<option value='".$temp."'>$temp</option>";
				}
			}
			echo "
			</select>
			</p>
			<button type='submit' class='btn btn-success pull-right'><i class='fa fa-refresh'></i>&nbsp;&nbsp;Apply Updates</button>
			</form>";
			?>
                </div><!--/panel-body-->
            </div><!--/panel-->
        </div><!--/col-md-8-->
    </div><!--/row-->
  </div>
  <!--/container-->
  <!--=== End Content Part ===-->
  <?php include("modals.php"); ?>
<?php include("footer.php"); ?>
</div><!--/wrapper-->
<script>

$(document).ready(function(){

    // submit the form
    $('#admin-configuration-form').on('submit', function (e) {
		
		// Get the form.
		var form = $('#admin-configuration-form');
	
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
				if(data[0] == "match"){
					$(formMessages).html(data[1]);
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
				}else{
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

    }); // close submit function

});

</script>
</body>
</html>