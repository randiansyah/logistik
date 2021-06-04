<section class="content">
  <div class="box box-default color-palette-box">
    <div class="box-header with-border">
      <h3 class="box-title"> <?php echo ucwords(str_replace("_"," ",$this->uri->segment(1)))?></h3>
       <div class="datatableButton pull-right">
        <!--
       <a href="<?php //echo base_url('Pelanggan/exportCSV')?>" class="btn btn-sm btn-warning" ><i class="fa fa-download"></i> Export CSV</a>
     -->
       
             <?php if($this->data['is_can_create']){
             ?>
        <a href="<?php echo $this->uri->segment(1)?>/create" class="btn btn-sm btn-primary">Tambah Customer</a>
        <?php 
}
?>
    </div></div>
    <div class="box-body">
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
                <th width="5">No. </th>
                <th>Nama</th> 
                <th>Email</th> 
                <th>Jenis Kelamin</th> 
               <th>Telp</th> 
               <th>Alamat</th> 
                <th>Action</th>
              </thead>        
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script 
  data-main="<?php echo base_url()?>assets/js/main/main-pelanggan.js" 
  src="<?php echo base_url()?>assets/js/require.js">  
</script>