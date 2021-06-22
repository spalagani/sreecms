<?php
include("../valid.php");
include("../head.php");
 include("../loginUserDetails.php");
if(isset($_GET['id'])){$uid=$_GET['id'];}else{$uid='';}
$searchTerm = $_GET['id'];
$finalArr = array();
if (!empty($searchTerm)) {
	$sql = "SELECT * FROM `customers` WHERE `id`=".$searchTerm;
	$result = mysqli_query($conn, $sql);
	$finalArr = array();
	if (mysqli_num_rows($result) > 0) {
	    while($row = mysqli_fetch_assoc($result)) {
	        $finalArr = $row;
	    }
	}
}
$userid= $row5['lu_role'];
$dt = date("Y-m-d");

 $sql = "Select package_id,package_name from packages";
 $result = mysqli_query($conn, $sql);
 if ($result) 
 {
    while( $row = mysqli_fetch_array($result))
    {
        
       $pkgname1 .="<option value='".$row['package_id']." ".$row['package_name']."'>".$row['package_name']."</option>";
    }
 }
  $sql3 = "Select package_id from packages where package_name='".Trim($_POST['OldPkg'])."'";
 $result3 = mysqli_query($conn, $sql3);
 if ($result3) 
 {
    while( $row = mysqli_fetch_array($result3))
    {
        
       $pkgid1 =$row['package_id'];
    }
 }

if(isset($_POST['update']))
{
   if(isset($_POST['pkgU'])){$pkgu=trim(substr($_POST['pkgU'],2));}else{$pkgu='';}
   
   $sql = "update customers Set Package_Name='".$pkgu."' where Id='".$searchTerm."'";
  $result = mysqli_query($conn, $sql);
  $sql2 = "insert into userpackagelogs(oldpackage_id,user_id,newpackage_id,datestarted,comments) Values('".$pkgid1."','".$userid."','".$pkgu2."','".$dt."','')";
  $result2 = mysqli_query($conn, $sql2);
    if ($result) 
     {
        echo "<script>alert('Package Update successfully');
        window.location.href = '../user/user-details.php?id=$searchTerm'</script>";
     } 
     else
     {
        echo "<script>alert('Failed to Update Package');</script>";
     }
}

 $sqllu = "Select lu_operator_id from loginusers where lu_id=".$_SESSION['lu_id']."";
 $resultlu = mysqli_query($conn, $sqllu);
 if ($resultlu) 
 {
    while( $rowlu = mysqli_fetch_array($resultlu))
    {
        
       $loginopid .=$rowlu['lu_operator_id'];
    }
 }
 
 $sqlpkg = "Select package_id,package_name,package_price from packages where op_id=".$loginopid."";
 $resultpkg = mysqli_query($conn, $sqlpkg);
 if ($resultpkg) 
 {
    while( $rowpkg = mysqli_fetch_array($resultpkg))
    {
        
       $pkgchk .="<option value='".$rowpkg['package_id']." ".$rowpkg['package_name']."'>".$rowpkg['package_name']." ----- Rs ".$rowpkg['package_price']."</option>";
    }
 }
?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Shree | User Details</title>
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

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

        <!-- Google Font -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
        <link rel="stylesheet" href="<?php echo $serverurl ?>dist/css/jqueryui.css">
    </head>

    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">

            <?php include("../header.php");
    include("../aside.php");
  ?>

                <div class="content-wrapper">




                                    <div class="row">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-6">
                                            <?php if(!empty($finalArr)) { ?>
                                                <div class="box box-widget widget-user-2">
                                                    <!-- Add the bg color to the header using any of the bg-* classes -->
                                                    <div class="widget-user-header bg-yellow">
                                                        <h3 class="" style="text-align:center"><?php echo !empty($finalArr['Name'])?$finalArr['Name']."'s":''; ?> Change Package</h3>
                                                    </div>
                                                    <div class="box-footer no-padding">
                                                        <ul class="nav nav-stacked" style="background-color:#f7f7f7">

                                                            <li><a href="#">Name <span class="pull-right"><?php echo !empty($finalArr['Name'])?$finalArr['Name']:''; ?></span></a></li>
                                                            <li><a href="#">Mobile Number <span class="pull-right"><?php echo !empty($finalArr['Mobile'])?$finalArr['Mobile']:''; ?></span></a></li>
                                                            <li><a href="#">IP Address <span class="pull-right"><?php echo !empty($finalArr['IpAddress'])?$finalArr['IpAddress']:''; ?></span></a></li>
                                                            <li><a href="#">MAC <span class="pull-right"><?php echo !empty($finalArr['MAC'])?$finalArr['MAC']:''; ?></span></a></li>
                                                            <li><a href="#">Address <span class="pull-right"><?php echo !empty($finalArr['Billing_Address'])?$finalArr['Billing_Address']:''; ?></span></a></li>
                                                            <form method='POST'>
                                                                <a href="#" style="color: #444;margin-left:17px;">Current Package :</a> <input type='text' class="form-control" name="OldPkg" value='<?php echo $finalArr['Package_Name'] ?>' readonly/>
                                                                <select class="form-control"  name="pkgU" style="margin-bottom:10px;">
                                                                    <?php echo $pkgchk; ?>
                                                                </select>
                                                        </ul>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-2"></div>
                                                        <div class="col-md-8 text-center">
                                                            <input type="submit" name="update" value="Update" class="btn btn-primary"/>
                                                        </div>
                                                        <div class="col-md-2"></div>
                                                    </div>
                                                    </form>
                                                </div>


                                                <?php } else { ?>
                                                    <div class="col-md-12">
                                                        <p style="text-align:center; margin-left: 50%;">No data found</p>
                                                    </div>
                                                <?php } ?>
                                        </div>
                                        <div class="col-md-3"></div>
                                    </div>

                                </div>
                            </div>
                        </div>
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
                        $(document).ready(function() {
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
                                            term: request.term,
                                            category: category_name
                                        },
                                        success: function(data) {
                                            response(data);
                                        }
                                    });
                                }
                            }).data("ui-autocomplete")._renderItem = function(ul, item) {
                                return $("<li class='serchli'>")
                                    .append("<a class='search_link' style='text-decoration:none' href='" + localurl + '?id=' + item.id + "' >" + item.value + "</a>")
                                    .appendTo(ul);
                            };
                        });
                    </script>
    </body>
    </html>