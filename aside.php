<?php
  include("loginUserDetails.php");
?>

  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo $serverurl ?>dist/img/avatar5.png" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $row5['lu_name']; ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
  
      <ul class="sidebar-menu" data-widget="tree">
        <?php if($row5['lu_role'] == 1){ ?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>Operator Management</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li ><a href="<?php echo $serverurl ?>operator/add-operator.php"><i class="fa fa-plus"></i> Add Operator</a></li>
            <li><a href="<?php echo $serverurl ?>view.php?list=operator"><i class="fa fa-check"></i> View Operator</a></li>
            <li><a href="#"><i class="fa fa-search"></i> Search Operator</a></li>
          </ul>
        </li>
        <?php } ?>
        
        <?php if($row5['lu_role'] == 1 || $row5['lu_role'] == 2){ ?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-money"></i> <span>Branch Management</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li ><a href="<?php echo $serverurl ?>branch/add-branch.php"><i class="fa fa-search"></i> Add Branch</a></li>
            <li><a href="<?php echo $serverurl ?>branch/view.php"><i class="fa fa-list"></i> View Branchs</a></li>
          
          </ul>
        </li>
        <?php } ?>
        
        <?php if($row5['lu_role'] == 3 || $row5['lu_role'] == 1 || $row5['lu_role'] == 4 || $row5['lu_role'] == 2){ ?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-group"></i> <span>Users Management</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li ><a href="<?php echo $serverurl ?>user/add-user.php"><i class="fa fa-plus"></i> Add User</a></li>
         <?php if($row5['lu_role'] == 1 || $row5['lu_role'] == 2){ ?>

            <li><a href="<?php echo $serverurl ?>user/user_bulk.php"><i class="fa fa-upload"></i> Upload Users list</a></li>
            <li><a href="<?php echo $serverurl ?>user/view.php"><i class="fa fa-check"></i> View Users</a></li>
        <?php } ?>
            <li><a href="<?php echo $serverurl ?>user/user-search.php"><i class="fa fa-search"></i> Search Users</a></li>
          </ul>
        </li>
        <?php } ?>

        <?php if($row5['lu_role'] == 1 || $row5['lu_role'] == 2){ ?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-user-circle-o"></i> <span>Employee  Management</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li ><a href="<?php echo $serverurl ?>collection-boy/add-collection-boy.php"><i class="fa fa-plus"></i> Add Employee</a></li>
            <li><a href="<?php echo $serverurl ?>collection-boy/view.php"><i class="fa fa-check"></i> View Employee</a></li>
          </ul>
        </li>
        <?php } ?>
        
        
        <?php if($row5['lu_role'] == 1 || $row5['lu_role'] == 2){ ?>
           <li class="treeview">
          <a href="#">
            <i class="fa fa-square"></i> <span>Packages Management</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li ><a href="<?php echo $serverurl ?>package/add-package.php"><i class="fa fa-plus"></i> Add Packages</a></li>
            <li><a href="<?php echo $serverurl ?>package/view.php"><i class="fa fa-check"></i> View Packages</a></li>
          </ul>
        </li>
        <?php } ?>
        
        
        <?php if($row5['lu_role'] == 1 || $row5['lu_role'] == 4 || $row5['lu_role'] == 2){ ?>
         <li class="treeview">
          <a href="#">
            <i class="fa fa-money"></i> <span>Payments Management</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li ><a href="<?php echo $serverurl ?>user/user-search.php"><i class="fa fa-search"></i>Make Payment</a></li>
          <!--  <li ><a href="<?php echo $serverurl ?>payment/user-payment-history.php"><i class="fa fa-search"></i>User Payment Histroy</a></li>
            
            <li><a href="<?php echo $serverurl ?>view.php?list=payments"><i class="fa fa-list"></i> List Paid/Unpaid Users</a></li>
           <li ><a href="<?php echo $serverurl ?>view.php?list=payments"><i class="fa fa-search"></i> Search Paid/Unpaid Users</a></li>
           <li ><a href="<?php echo $serverurl ?>view.php?list=payments"><i class="fa fa-search"></i> Search Paid/Unpaid Users by year</a></li>
            <li><a href="<?php echo $serverurl ?>view.php?list=payments"><i class="fa fa-mobile"></i> Send SMS to User</a></li>
           -->
           <li ><a href="<?php echo $serverurl ?>payment/pay-search.php"><i class="fa fa-search"></i> Search Payments</a></li>
           
          </ul>
        </li>
        <?php } ?>

      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>