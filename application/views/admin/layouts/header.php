<!DOCTYPE html>
<html style="height: auto;min-height: 100%;">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo ucwords(str_replace("_"," ",$this->uri->segment(1)))?> - IP LOGISTIK</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/fonts/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/fonts/Ionicons/css/ionicons.min.css"> 
  <!-- Theme style -->

  <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/bootstrap-daterangepicker/daterangepicker.css"> 
  <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/select2/select2.min.css">
  <!-- Theme style -->

  <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/datatables.net-bs/css/dataTables.bootstrap.min.css">

  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/admin.min.css"> 
   <link rel="stylesheet" href="<?php echo base_url();?>assets/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
 <style type="text/css">
tfoot {
    display: table-header-group;
}
.dataTables_filter, .dataTables_info { display: none; }
 </style>
 <script type="text/javascript" href="https://cdn.datatables.net/plug-ins/1.10.20/sorting/numeric-comma.js"></script>
</head>