<?php
  include("loginUserDetails.php");
?>
  <header class="main-header">
    <!-- Logo -->
    <a href="<?php echo $serverurl ?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <img src="<?php echo $serverurl ?>sree-broadband-logo.png"  style=" width: 50%;">
      <span class="logo-mini"><b>A</b>LT</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b></b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
        
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?php echo $serverurl ?>dist/img/avatar5.png" class="user-image" alt="User Image">
              <span class="hidden-xs"> <?php echo $row5['lu_name']; ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?php echo $serverurl ?>dist/img/avatar5.png" class="img-circle" alt="User Image">

                <p>
                  <?php echo $row5['lu_name']; ?>
                 
                </p>
              </li>
              <!-- Menu Body -->
             
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-right">
                  <a href="<?php echo $serverurl.'logout.php'; ?>" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
         
        </ul>
      </div>
    </nav>
  </header>