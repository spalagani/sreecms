<?php
include("../valid.php");
include("../head.php"); 
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Shree | Search Payments</title>
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
       User Payment Histroy
       
      </h1>
    
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            
            <form role="form">
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Select Year</label> (*On Change of the year, we have show all the months with Paid / un paid / send sms / multiselect option / payment link)
                 <select class="form-control">
                    <option>2014</option>
                    <option>2015</option>
                    <option>2016</option>
                    <option>2017</option>
                    <option>2018</option>
                    <option>2019</option>
                  </select>
                </div>
                 
                <div class="form-group">
                  <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Select</th>
                  <th>Month</th>
                  <th>Paid / Unpaid</th>
                  <th>Paid Date</th>
                  <th>Amount Paid</th>
                  <th>Invoice Download</th>
                  <th>Send SMS Notification</th>
                  <th>Online / Offline</th>
                  
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><input type="checkbox" class="btn btn-primary"></input></td>
                  <td>Jan</td>
                  <td>Paid</td>
                  <td>23/12/2018</td>
                  <td>235.00</td>
                  <td><button type="submit" class="btn btn-primary">Download Invoice</button></td>
                  <td><button type="submit" class="btn btn-primary">Send SMS Notification</button></td>
                  
                  <td>
                    <select class="form-control">
                    <option>Select</option>
                    <option>Online</option>
                    <option>Offline</option>
                  </select>
                  </td>
                  
                  </tr>
                  
                  <tr>
                    <td><input type="checkbox" class="btn btn-primary"></input></td>
                  <td>Feb</td>
                  <td>Paid</td>
                  <td>23/12/2018</td>
                  <td>235.00</td>
                  <td><button type="submit" class="btn btn-primary">Download Invoice</button></td>
                  <td><button type="submit" class="btn btn-primary">Send SMS Notification</button></td>
                  
                  <td>
                    <select class="form-control">
                    <option>Select</option>
                    <option>Online</option>
                    <option>Offline</option>
                  </select>
                  </td>
                  
                  </tr>
                  <tr>
                    <td><input type="checkbox" class="btn btn-primary"></input></td>
                  <td>March</td>
                  <td>Paid</td>
                  <td>23/12/2018</td>
                  <td>235.00</td>
                  <td><button type="submit" class="btn btn-primary">Download Invoice</button></td>
                  <td><button type="submit" class="btn btn-primary">Send SMS Notification</button></td>
                  
                  <td>
                    <select class="form-control">
                    <option>Select</option>
                    <option>Online</option>
                    <option>Offline</option>
                  </select>
                  </td>
                  
                  </tr>
                  <tr>
                    <td><input type="checkbox" class="btn btn-primary"></input></td>
                  <td>April</td>
                  <td>Paid</td>
                  <td>23/12/2018</td>
                  <td>235.00</td>
                  <td><button type="submit" class="btn btn-primary">Download Invoice</button></td>
                  <td><button type="submit" class="btn btn-primary">Send SMS Notification</button></td>
                  
                  <td>
                    <select class="form-control">
                    <option>Select</option>
                    <option>Online</option>
                    <option>Offline</option>
                  </select>
                  </td>
                  
                  </tr>
                  <tr>
                    <td><input type="checkbox" class="btn btn-primary"></input></td>
                  <td>May</td>
                  <td>Paid</td>
                  <td>23/12/2018</td>
                  <td>235.00</td>
                  <td><button type="submit" class="btn btn-primary">Download Invoice</button></td>
                  <td><button type="submit" class="btn btn-primary">Send SMS Notification</button></td>
                  
                  <td>
                    <select class="form-control">
                    <option>Select</option>
                    <option>Online</option>
                    <option>Offline</option>
                  </select>
                  </td>
                  
                  </tr>
                  <tr>
                    <td><input type="checkbox" class="btn btn-primary"></input></td>
                  <td>June</td>
                  <td>Paid</td>
                  <td>23/12/2018</td>
                  <td>235.00</td>
                  <td><button type="submit" class="btn btn-primary">Download Invoice</button></td>
                  <td><button type="submit" class="btn btn-primary">Send SMS Notification</button></td>
                  
                  <td>
                    <select class="form-control">
                    <option>Select</option>
                    <option>Online</option>
                    <option>Offline</option>
                  </select>
                  </td>
                  
                  </tr>
                  <tr>
                    <td><input type="checkbox" class="btn btn-primary"></input></td>
                  <td>July</td>
                  <td>Paid</td>
                  <td>23/12/2018</td>
                  <td>235.00</td>
                  <td><button type="submit" class="btn btn-primary">Download Invoice</button></td>
                  <td><button type="submit" class="btn btn-primary">Send SMS Notification</button></td>
                  
                  <td>
                    <select class="form-control">
                    <option>Select</option>
                    <option>Online</option>
                    <option>Offline</option>
                  </select>
                  </td>
                  
                  </tr>
                   
                </tbody>
                <tfoot>
              <tr>
                  <th>Select</th>
                  <th>Month</th>
                  <th>Paid / Unpaid</th>
                  <th>Paid Date</th>
                  <th>Amount Paid</th>
                  <th>Invoice Download</th>
                  <th>Send SMS Notification</th>
                  
                </tr>
                </tfoot>
              </table>
            </div>
                  
                </div>
             

               
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>
        
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
<!-- AdminLTE App -->
<script src="<?php echo $serverurl ?>bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- bootstrap datepicker -->
<script src="<?php echo $serverurl ?>bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

<script src="<?php echo $serverurl ?>plugins/iCheck/icheck.min.js"></script>

<script src="<?php echo $serverurl ?>dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo $serverurl ?>dist/js/demo.js"></script>
</body>
</html>
<script>
  $(function () {

       $('#datepicker').datepicker({
      autoclose: true
    })
          $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass   : 'iradio_minimal-blue'
    })

            $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass   : 'iradio_minimal-red'
    })
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass   : 'iradio_flat-green'
    })


});
    </script>
