<?php
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Thoroughwiz | Thoroughwiz Sample Data Sheets</title>
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
      <h1 class="pull-left">Thoroughwiz Free Sample Data Sheets</h1>
      <ul class="pull-right breadcrumb">
        <li><a href="index.php">Home</a></li>
        <li class="active">Thoroughwiz Free Sample Data Sheets</li>
      </ul>
    </div><!--/container-->
  </div><!--/breadcrumbs-->
  <!--=== End Breadcrumbs ===-->
  
  <!--=== Content Part ===-->      
 <div class="container content">
    <div class="row">
      <div class="col-md-4">
        <!-- Contact Us -->
        <div class="who margin-bottom-30">
          <div class="headline">
            <h2>Sample Data Sheets</h2>              
          </div>
             
            <form class="sheet-form" action='scripts/summary_free.php' method='post' enctype='multipart/form-data' target='_blank'>
                <button type='submit' class='btn btn-success btn-u-md'><i class='fa fa-file-text-o'></i>&nbsp;&nbsp;Summary Sheet</button>
            </form>
            
        </div>
      </div>
      <!--/col-md-3-->
      <div class="col-md-8">
        <!-- Our Services -->
        <div class="headline">
          <h2>Thank you for viewing our free samples!</h2>
        </div>     
        <div>
                          <p>If you are impressed with our service, consider a Thoroughwiz membership.</p>
                          <p>Registration is free and required for access. Once you have activated your account you will have single-credit, multi-credit, and monthly purchase options.</p>
                          <p><a href="register.php" class='btn btn-success btn-md'><span class='glyphicon glyphicon-user'></span>&nbsp;&nbsp;BECOME A MEMBER!</a></p>
                          <span style="color:#959595;">Registration with Thoroughwiz is free!</span><br>
                          <span><a href="faq.php"><strong>FAQ</strong></a>&nbsp;|&nbsp;<a href="terms.php"><strong>TERMS</strong></a>&nbsp;|&nbsp;<a href="privacy.php"><strong>PRIVACY</strong></a></span> 
                      </div> 
      </div><!--/col-md-9-->
    </div><!--/row-->
  </div><!--/container-->   
  
  <!--=== End Content Part ===-->
  
  <?php include("modals.php"); ?>
  <?php include("footer.php"); ?>
  
</div><!--/wrapper-->
<script>
  $(document).ready(function(){
	  //submit filters form and reload account page at the same time to reset the form
      $("#sampleFilterForm").on("submit", function(e) {
          e.preventDefault();
          setTimeout(function() {
               window.location.reload();
          },0);
          this.submit();
        });
  });
</script>
</body>

</html>
