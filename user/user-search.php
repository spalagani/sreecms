<?php
include("../valid.php");
include("../head.php"); 
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Shree | Add User</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo $serverurl ?>bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo $serverurl ?>bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo $serverurl ?>bower_components/Ionicons/css/ionicons.min.css">

  <link rel="stylesheet" href="<?php echo $serverurl ?>plugins/iCheck/all.css">

  <link rel="stylesheet" href="<?php echo $serverurl ?>bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="<?php echo $serverurl ?>bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">

  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo $serverurl ?>dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo $serverurl ?>dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="<?php echo $serverurl ?>dist/css/jqueryui.css">


  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

 <?php include("../header.php");
    include("../aside.php");
  ?>
  
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Search User
       
      </h1>
    
    </section>

    <!-- Main content -->
    <section class="content" style="background-color:white; height:500px;">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <!--<div class="box box-primary">-->
            
            <form role="form">
              <div class="box-body">
                  <div class="row" style="margin-top:10%;">
                      <div class="col-md-2"></div>
                     <div class="col-md-4">
                          <div class="form-group">
                                <div class="form-group">
                                    <select class="form-control" id="category">
                                      <option value="">Select option</option>
                                      <option value="Name">Name</option>
                                      <option value="Mobile">Mobile</option>
                                      <option value="Id">UserId</option>
                                      <option value="Username">Username</option>
                                      <option value="Billing_Address">Address</option>
                                      <option value="IpAddress">Ip Address</option>
                                      <option value="MAC">MAC</option>
                                    </select>
                                 </div>
                          </div>
                     </div>
                     <div class="col-md-4">
                          <div class="form-group">
                              <input type="text" class="form-control"  id="autocomplete_data" placeholder="Search">
                          </div>
                     </div>
                     <div class="col-md-2">
                     </div>
                  </div>
              </div>
              <!-- /.box-body -->

            </form>
          <!--</div>-->
        
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

        </div>
      
      
 <?php include("../footer.php") ?>

 

<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="<?php echo $serverurl ?>bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo $serverurl ?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="<?php echo $serverurl ?>bower_components/fastclick/lib/fastclick.js"></script>
<script src="<?php echo $serverurl ?>dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo $serverurl ?>dist/js/demo.js"></script>
<script src="<?php echo $serverurl ?>dist/js/jqueryui.js"></script>
<script>
    var localurl = "<?php echo $serverurl.'user/user-details.php' ?>";
    $(document).ready(function(){
        $("#category,#autocomplete_data").val("");
        let category_name = '';
        $("#category").change(function() {
            category_name = $(this).val();
        });
        
        $("#autocomplete_data").autocomplete({
    	    source: function(request, response) {
    	        $.ajax({
    	            url: "<?php echo $serverurl ?>user/search.php",
    	            dataType: "json",
    	            data: {
    	                term : request.term,
    	                category : category_name
    	            },
    	            success: function(data) {
    	                response(data);
    	            }
    	        });
    	    }
    	}).data("ui-autocomplete")._renderItem = function (ul, item) {
        		return $("<li class='serchli'>")
        		.append("<a class='search_link' style='text-decoration:none' href='"+localurl+'?id='+item.id+"' >"+item.value+"</a>")
        		.appendTo(ul);
    	};
    });
</script>
</body>
</html>

