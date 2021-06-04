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
      <a id="print-pdf" target="blank" class="btn btn-sm btn-success"><i class="fa fa-download"></i>&nbsp;Cetak Laporan</a> 
    </div>
</div>
</div>
<div class="col-md-12">

         <div class="col-md-2">
          <div class="form-group">
            <label>[ T ] KREDIT TAGIHAN</label>
            <div class="btn btn-danger"><div id="total_kredit"></div></div>
             <div class="form-group"><br>
            <label>JATUH TEMPO</label>
            <div class="btn btn-danger"><div id="jatuh_tempo"></div></div>
        </div>
        </div>
      </div>
       <div class="col-md-2">
          <div class="form-group">
            <label>[ T ] CASH TAGIHAN</label>
            <div class="btn btn-danger"><div id="total_cash"></div></div>
        </div>
      </div>

       <div class="col-md-2">
          <div class="form-group">
            <label>TOTAL TAGIHAN</label>
            <div class="btn btn-danger"><div id="grand_total"></div></div>
        </div>
      </div>
       <div class="col-md-2">
          <div class="form-group">
            <label>[ T ] KREDIT TERTAGIH</label>
            <div class="btn btn-info"><div id="bayar_kredit"></div></div>
        </div>
      </div>
      <div class="col-md-2">
          <div class="form-group">
            <label>[ T ] CASH TERTAGIH</label>
            <div class="btn btn-info"><div id="bayar_cash"></div></div>
        </div>
      </div>
      <div class="col-md-2">
          <div class="form-group">
            <label>TOTAL TERTAGIH</label>
            <div class="btn btn-info"><div id="total_bayar"></div></div>
        </div>
      </div>
</div>
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
            <table class="table table-striped tab" id="table"> 
              <thead>
              <th>#</th>
              <th>NAMA CS</th> 
            <th>[ KREDIT ] TAGIHAN</th> 
            <th>[ CASH ] TAGIHAN</th> 
             <th>[ TOTAL ] TAGIHAN</th>
             <th>JATUH TEMPO</th>  
                   <th class="bg-primary text-white">[ KREDIT ] TERTAGIH</th>
                 <th class="bg-primary text-white">[ CASH ] TERTAGIH</th>
         
                   <th class="bg-primary text-white">[ TOTAL ] TERTAGIH</th>
              </thead> 
              <tbody>
                
              </tbody>  
              <tfoot>
                <tr>
  <th></th>
              <th></th> 
            <th ></th> 
             <th></th>
             <th></th>  
                <th></th> 
                <th></th> 
                <th></th> 
                <th></th> 
                </tr>
              </tfoot>     
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
