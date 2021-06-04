<?php if(!empty($this->session->flashdata('message_error'))){?>
<div class="alert alert-danger">
<?php   
   print_r($this->session->flashdata('message_error'));
?>
</div>
<?php }?> 
<section class="content">
  <div class="box box-default color-palette-box">
    <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-tag"></i>Invoice Create</h3>
       
    </div>
     <form id="karyawan" method="post" enctype="multipart/form-data">
    <div class="box-body">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group"> 
           <div class="form-group">
            <label for="">Invoice ID</label>
            <input class="form-control" value="<?php echo $id_transaksi; ?>" id="id_transaksi" name="id_transaksi" autocomplete="off" required readonly>
          </div>
         
        <div class="form-group row">
                <div class="col-md-6">
           <label for="">User input</label>
      <input class="form-control" type="hidden" value="<?php echo $this->data['users']->id;?>" id="user_input" name="user_input">
       
          <input class="form-control" value="<?php echo $this->data['users']->first_name;?>"autocomplete="off" readonly>
          </div>
           <div class="col-md-6">
              <label for="">Waktu input</label>
          <input class="form-control" value="<?php echo date('Y-m-d'); ?>" id="waktu_input" name="waktu_input" autocomplete="off" readonly="">
           </div>
             
          </div>
        <div class="form-group row">
          <div class="col-md-6">
   <label for="">pajak %</label>
          <input class="form-control" value="" id="pajak" name="pajak" autocomplete="off" >
          </div>
            <div class="col-md-6">
   <label for="">Tgl Jatuh Tempo</label>
          <input class="form-control datetime" value="" id="jatuh_tempo" name="jatuh_tempo" autocomplete="off" >
          </div>
           
           </div>
           
         
     
        </div>
      </div>
      <div class="col-md-6">
   
            <div class="form-group row">  
             <div class="col-sm-6">
                <label for=""> Pilih Costumer</label>
                <select id="vendor" name="vendor" class="form-control">
                  <option value="" selected>Pilih salah satu</option>
                  <?php
                  foreach ($cs as $key => $val) { ?>
      <option value="<?php echo $val->id;?>"><?php echo $val->nama ?></option>
                  <?php }
                  ?>
                </select>
            </div>
            <div class="col-sm-6">
                 <label for="">Jenis Pembayaran</label>
             <select class="form-control select2" id="jenis_pembayaran" name="jenis_pembayaran">
                  <option value="" selected>Pilih salah satu</option>              
                  <option value="Cash">Cash</option>   
                  <option value="Kredit">Kredit</option> 
               
                </select>
            </div>
            </div>
              
          <div class="form-group row">          
            <div class="col-sm-6">
                <label>Dari Tanggal</label>
                <input type="text" id="periode_start" name="periode_start" class="form-control date" data-provide="datepicker" data-date-format="dd-mm-yyyy" placeholder="Dari Tanggal">
            </div>
            <div class="col-sm-6">
                <label>Sampai Tanggal</label>
                <input type="text" id="periode_end" name="periode_end" class="form-control date" data-provide="datepicker" data-date-format="dd-mm-yyyy" placeholder="Sampai Tanggal">
            </div>
          </div>

  
           <div class="col-sm-12"> 
          <div class="form-group text-right">
              <a href="#" class="btn btn-sm btn-primary" id="search"><i class="fa fa-search"></i> Cari</a>    
              <a href="#" class="btn btn-sm btn-danger" id="reset"><i class="fa fa-refresh"></i> RESET</a>
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
            <table class="table table-striped" id="table"> 
              <thead>
                <th ></th>
                 <th>Nama</th>
                   <th>Jenis Pembayaran</th>
                <th>Tanggal</th>
                 <th>NO SPB</th>
                <th>Asal</th>
                <th>Tujuan</th>
                <th>Service</th>
                <th>Qty</th> 
                <th>Harga Satuan</th> 
               <th>Total Harga Satuan</th> 
               <th>Total Harga Packing</th> 
                <th>Total Harga Asuransi</th> 
                <th>Tandai Semua [<input type="checkbox" class="flat" id="allcetak">]</th> 

              </thead>        
            </table>
          </div>
        </div>

    </div>
   
   
     
 



         <div class="box-footer">
          <div class="row">
            <br>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
              <br>
              <button type="submit" class="btn btn-primary">Simpan</button>
                 <a href="<?php echo base_url($this->uri->segment(1))?>" class="btn btn-default"> BATAL</a>
            </div>
          </div>
      </div>
    </form>
  </div>
</section>

              

<script 
  data-main="<?php echo base_url()?>assets/js/main/main-invoice_cs.js" 
  src="<?php echo base_url()?>assets/js/require.js">
</script>