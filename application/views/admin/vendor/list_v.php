<section class="content-header">
  <h1>
    <?php echo ucwords(str_replace("_"," ",$this->uri->segment(1)))?>
    <small></small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active"><?php echo ucwords(str_replace("_"," ",$this->uri->segment(1)))?></li>
  </ol>
</section>

<section class="content">
  <div class="box box-default color-palette-box">
    <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-tag"></i> <?php echo ucwords(str_replace("_"," ",$this->uri->segment(1)))?></h3>
    <div class="col-sm-1 datatableButton pull-right">
      <div class="row">
      <?php if($this->data['is_can_create']){
      ?>
        <a href="<?php echo $this->uri->segment(1)?>/create" class="btn btn-sm btn-primary"><i class='fa fa-plus'></i> <?php echo ucwords(str_replace("_"," ",$this->uri->segment(1)))?></a>

        <?php
      }
      ?>
      </div>
    </div>
    </div>
    <div class="box-body">
    <div class="box-header">
      
    </div>
      <div class="row">
        <div class="col-md-12"> 
            <div class="table-responsive">
            <?php if(!empty($this->session->flashdata('message'))){?>
            <div class="alert alert-info">
            <?php   
               print_r($this->session->flashdata('message'));
            ?>
            </div>
            <?php }?> 
             <?php if(!empty($this->session->flashdata('message_error'))){?>
            <div class="alert alert-info">
            <?php   
               print_r($this->session->flashdata('message_error'));
            ?>
            </div>
            <?php }?> 
            <table class="table table-striped" id="table"> 
              <thead>
              <th>#</th>
               <th>Kode Vendor</th> 
               <th>Nama</th> 
               <th>Kategori Usaha</th> 
               <th>Jumlah Kendaraan</th> 
               <th>ALamat</th> 
               <th>No Telp</th> 
               <th width="20%">Status</th>
                 
              </thead>        
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script 
  data-main="<?php echo base_url()?>assets/js/main/main-vendor" 
  src="<?php echo base_url()?>assets/js/require.js">  
</script>