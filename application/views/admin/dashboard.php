 <section class="content-header">
  <h1>
    Dashboard
    <small></small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Dashboard</li>
  </ol>
</section>


<!-- Main content -->
<section class="content">
  
  <div class="row">
<?php if($this->data['users']->roles == 9){
  include 'dashboard/support_v.php';

 }else if($this->data['users']->roles == 1){
  include 'dashboard/admin_v.php';
 
 }else if($this->data['users']->roles == 11){
  include 'dashboard/werehouse_v.php';

 }else if($this->data['users']->roles == 10){
  include 'dashboard/pickadel_v.php';

 }else if($this->data['users']->roles == 8){
  include 'dashboard/br_v.php';

  }else if($this->data['users']->roles == 12){
   include 'dashboard/finansial_v.php';
    
 }else{ 
   include 'dashboard/all_v.php';
 }

?>
  </div>




</section>
 <script data-main="<?php echo base_url()?>assets/js/main/main-dashboard.js" src="<?php echo base_url()?>assets/js/require.js"></script>