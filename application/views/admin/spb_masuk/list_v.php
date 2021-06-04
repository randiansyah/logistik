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
  <div class="col-md-6">
 <div class="box box-bottom">
    <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-tag"></i> Pencarian <?php echo ucwords(str_replace("_"," ",$this->uri->segment(1)))?></h3>
    </div>
    <div class="box-body">
      <div class="row">
       <div class="col-md-12">  
          <div class="form-group row">
         
   <div class="col-md-12">
              <label>NO SPB</label>
         <input type="text" name="kode_delivery" id="kode_delivery" class="form-control" value="">
            </div>

           
             
            
          
         
          </div>
          <div class="form-group row">
            <div class="col-sm-12 text-right"> 
              <a href="#" class="btn btn-md btn-danger" id="reset">Reset</a>
              <a href="#" class="btn btn-md btn-primary" id="search">Cari</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</section>
<section class="content">
  <div class="box box-default color-palette-box">
    <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-tag"></i> <?php echo ucwords(str_replace("_"," ",$this->uri->segment(1)))?></h3>
    
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
               <th width="100">ID Transaksi</th> 
                <th width="100">NO SPB</th> 
                
                <th>Nama</th> 
              <th width="100">Pengiriman Via</th> 
            <th>Asal</th> 
            <th>Tujuan</th> 
             <th>Jadwal Delivery</th> 
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
  data-main="<?php echo base_url()?>assets/js/main/main-spb.js" 
  src="<?php echo base_url()?>assets/js/require.js">  
</script>