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
    
    </div>
    <div class="box-body">
    <div class="box-header">
      
    </div>
      <div class="row">
      <div class="col-md-7"></div>
        <div class="col-md-3">
          <div class="form-group">
               <input type="hidden" id="periode_start" name="periode_start">
               <input type="hidden" id="kode_pelanggan" name="kode_pelanggan" value="<?php echo $this->uri->segment(3)?>">
          <input type="hidden" id="periode_end">
               <button type="button" class="btn btn-default " id="daterange-btn">
            Periode <i class="fa fa-calendar"></i>
            <span>
               Date range picker
            </span>
            <i class="fa fa-caret-down"></i>
          </button>
        
 </div>
</div>
<div class="col-md-2">
  <div class="form-group">
  <div class="datatableButton">
      <a id="print-pdf-rincian" target="blank" class="btn btn-sm btn-success"><i class="fa fa-download"></i>&nbsp;Cetak Laporan</a> 
    </div>
</div>
</div>
        <div class="col-md-12"> 
          <input type="hidden" id="id" name="id" value="<?php echo $id ?>">
        
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
            <table class="table table-striped " id="tableRincian"> 
              <thead>
              <th>#</th>
               <th width="100">ID Invoice</th> 
                <th width="100">Kode Delivery</th> 
                <th>Nama</th> 
            <th>Grand Total</th> 
            <th>Tgl Sekarang</th> 
             <th>Tgl Jatuh Tempo</th>
             <th>Status Pembayaran</th> 

              </thead>        
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script 
  data-main="<?php echo base_url()?>assets/js/main/main-laporan-transaksi.js" 
  src="<?php echo base_url()?>assets/js/require.js">  
</script>