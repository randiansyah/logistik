<section class="content-header">
  <h1>
   Transaksi
    <small></small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Transaksi</li>
  </ol>
</section>

<section class="content">
  <div class="box box-default color-palette-box">
    <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-tag"></i> Transaksi</h3>
    
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
            <table class="table table-striped " id="table"> 
              <thead>
              <th>#</th>
               <th width="100">ID Manifest</th> 
                <th width="100">PR No</th> 
                <th width="100">Tanggal</th> 
                <th>Vendor</th> 
              <th width="100">Jumlah Coli</th> 
            <th>Jumlah Kg</th> 
             <th>Status</th>
             <th width="100">Action</th>
                 
              </thead>        
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script 
  data-main="<?php echo base_url()?>assets/js/main/main-invoice_vendor.js" 
  src="<?php echo base_url()?>assets/js/require.js">  
</script>