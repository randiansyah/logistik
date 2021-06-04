<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Log in</title>
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
    <a href="<?php echo base_url()?>"><b>Admin</b>LTE</a>
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

    <form action="<?php echo base_url();?>auth/create_user" method="post" id="form-login">
      <div class="form-group has-feedback">
        <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Nama Depan">
        <span class="glyphicon glyphicon-people form-control-feedback"></span>
      </div>

      <div class="form-group has-feedback">
        <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Nama Belakang">
        <span class="glyphicon glyphicon-people form-control-feedback"></span>
      </div>

      <div class="form-group has-feedback">
        <input type="email" class="form-control" id="email" name="email" placeholder="Email">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>

      <div class="form-group has-feedback">
        <input type="text" class="form-control number" id="phone" name="phone" placeholder="No. Telepon/Hp">
        <span class="glyphicon glyphicon-phone form-control-feedback"></span>
      </div>

      <div class="form-group has-feedback">
        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>

      <div class="form-group has-feedback">
        <input type="password" class="form-control" id="password_confirm" name="password_confirm" placeholder="Password Konfrim">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <!-- /.col -->
        <div class="col-xs-6">
          <button type="submit" class="btn btn-primary btn-block btn-flat" id="btn-login">Daftar</button>
        </div>

        <!-- /.col -->
      </div>
      <hr>
      <div class="separator">
        <p class="change_link">Sudah memiliki akun?
          <a href="<?php echo base_url()?>login/register" class="to_register"> Daftar Akun </a>
        </p>
      </div>
    </form>
    <!-- /.social-auth-links -->
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<script data-main="<?php echo base_url()?>assets/js/main/main-login" src="<?php echo base_url()?>assets/js/require.js"></script>
  <input type="hidden" id="base_url" value="<?php echo base_url();?>">
</body>
</html>
