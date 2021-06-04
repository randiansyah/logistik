<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>iP Logistics | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/fonts/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/fonts/Ionicons/css/ionicons.min.css"> 
  <!-- Theme style -->


  <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/datatables.net-bs/css/dataTables.bootstrap.min.css">

  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/admin.min.css"> 

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <img src="<?php echo base_url()?>assets/images/logo3.png" width="250"><br>
    <a href="<?php echo base_url()?>"><b>iP</b> Logistics</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>
    <?php if(!empty($this->session->flashdata('message_error'))){?>
          <div class="alert alert-danger">
            <?php   
               print_r($this->session->flashdata('message_error'));
           
            ?>
            </div>
          <?php }?>
            <?php if(!empty($this->session->flashdata('message'))){?>
          <div class="alert alert-success">
            <?php   
  
               print_r($this->session->flashdata('message'));
            ?>
            </div>
          <?php }?>
    <form action="<?php echo base_url();?>auth/login" method="post" id="form-login">
      <div class="form-group has-feedback">
        <input type="email" class="form-control" name="username" placeholder="Email">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" name="password" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <!-- /.col -->
        <div class="col-xs-12">
          <button type="submit" class="btn btn-primary btn-block btn-flat" id="btn-login">Sign In</button>
        </div>

        <!-- /.col -->
      </div>
    </form>
    <!-- /.social-auth-links -->
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
<center>
<p style="color:white">&copy; Copyright <?php echo date('Y');?> <b>iP Logistics</b> - Powered By <a href="https://manggadingin.com" target="_blank" style="color: white">Mangga Dingin</a> <br> Full Version</p>
</center>
<script data-main="<?php echo base_url()?>assets/js/main/main-login" src="<?php echo base_url()?>assets/js/require.js"></script>
  <input type="hidden" id="base_url" value="<?php echo base_url();?>">
</body>
</html>
