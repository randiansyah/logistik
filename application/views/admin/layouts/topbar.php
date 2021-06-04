<header class="main-header">
  <!-- Logo -->
  <a href="<?php echo base_url()?>dashboard" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini" ><img src="<?php echo base_url()?>assets/images/logo3.png" width="60"></span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><img src="<?php echo base_url()?>assets/images/logo3.png" width="60" style="margin-top: -4px;"> <label style="font-size: 18px;font-weight: normal;">iP Logistics</label></span>
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
              <i class="fa fa-user"></i>
                   <span class="hidden-xs"><?php echo $this->data['users']->first_name?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?php echo base_url()?>/assets/images/logo3.png" width="50" class="img-circle" alt="User Image">

                <p>
                  <?php echo $this->data['users']->first_name?>
              
                </p>
              </li>
              <!-- Menu Body -->
              <li class="user-body">
                <div class="row">
                  <div class="col-xs-6 text-center">
                    <a href="<?php echo base_url('profile/gantiEmail')?>">Ganti email</a>
                  </div>
                  <div class="col-xs-6 text-center">
                    <a href="<?php echo base_url('profile')?>">Ganti Password</a>
                  </div>
                 
                </div>
                <!-- /.row -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
            
              <div class="pull-right">
                <a href="<?php echo base_url('auth/logout')?>" class="btn btn-default btn-flat">Sign out</a>
              </div>
            </li>
            </ul>
          </li>
        
        </ul>
      </div>
   
</header>