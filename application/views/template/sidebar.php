<body class="hold-transition skin-blue sidebar-mini">

  <div class="wrapper">

    <header class="main-header">
      <!-- Logo -->
      <a href="index2.html" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b><?php echo $title; ?></b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b><?php echo $title; ?></b></span>
      </a>
      <!-- Header Navbar: style can be found in header.less -->
      <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
          <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="<?php echo base_url() ?>data_uploads/photo_profile/default.png" class="user-image" alt="User Image">
                <span class="hidden-xs"><?php echo $name; ?> </span>
              </a>
              <ul class="dropdown-menu">
                <!-- User image -->
                <li class="user-header">
                    <img src="<?php echo base_url() ?>data_uploads/photo_profile/default.png" class="img-circle" alt="User Image">
                  <p>
                    <?php echo $name; ?>
                    <small><?php echo $userGroup; ?></small>
                  </p>
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                  <div class="pull-left">
                  </div>
                  <div class="pull-right">
                    <a href="<?php echo base_url();?>settings/logout/" class="btn btn-default btn-flat">Logout</a>
                  </div>
                </li>
              </ul>
            </li>
          
          </ul>
        </div>
      </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
          <div class="pull-left image">
              <img src="<?php echo base_url() ?>data_uploads/photo_profile/default.png" class="user-image" alt="User Image">
          </div>
          <div class="pull-left info">
            <p><?php echo $name; ?></p>
            <a href="#"></i><?php echo $userGroup; ?></a>
          </div>
        </div>

        <ul class="sidebar-menu">
          <li class="header">Main Menu</li>
          <li>
            <a href="<?php echo base_url();?>dashboard"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
          </li>
          <li>
            <a href="<?php echo base_url()?>"><i class="fa fa-gear"></i> <span>LKP 1</span></a>
          </li>
          <li>
            <a href="<?php echo base_url()?>welcome/kpl2"><i class="fa fa-gear"></i> <span>LKP 2</span></a>
          </li>
          <li>
            <a href="<?php echo base_url()?>welcome/kpl3"><i class="fa fa-gear"></i> <span>LKP 3</span></a>
          </li>
          <li>
            <a href="<?php echo base_url()?>welcome/kpl4  "><i class="fa fa-gear"></i> <span>LKP 4</span></a>
          </li>
          <li class="header">Action</li>
          <li>
            <a href="<?php echo base_url()?>settings/logout"><i class="fa fa-circle-o text-red"></i> <span>Logout</span></a>
          </li>
        </ul>
      </section>
      <!-- /.sidebar -->
    </aside>
