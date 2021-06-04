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
    <h3 class="box-title"><i class="fa fa-tag"></i>Manifest Create</h3>
       
    </div>
     <form id="karyawan" method="post" enctype="multipart/form-data">
    <div class="box-body">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group"> 
           <div class="form-group">
            <label for="">Manifest ID</label>
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
     <div class="form-group">
       <label for="">Keterangan</label>
        <textarea cols="3" rows="5" value="" class="form-control" id="catatan" name="catatan"></textarea>            
    
           </div>
           
         
     
        </div>
      </div>
      <div class="col-md-6">
   
            <div class="form-group">  
           
                <label for=""> Pilih Vendor</label>
                <select id="vendor" name="vendor" class="form-control">
                  <option value="" required>Pilih salah satu</option>
                  <?php
                  foreach ($vendor as $key => $val) { ?>
      <option value="<?php echo $val->id;?>"><?php echo $val->nama ?></option>
                  <?php }
                  ?>
                </select>
            
            </div>
              
          <div class="form-group row">          
            <div class="col-sm-6">
                <label>Dari Tanggal</label>
                <input type="text" id="periode_start" name="periode_start" class="form-control date" data-provide="datepicker" data-date-format="yyyy-mm-dd" placeholder="Dari Tanggal">
            </div>
            <div class="col-sm-6">
                <label>Sampai Tanggal</label>
                <input type="text" id="periode_end" name="periode_end" class="form-control date" data-provide="datepicker" data-date-format="yyyy-mm-dd" placeholder="Sampai Tanggal">
            </div>
          </div>
     <div class="form-group">
            <label for="">Asal</label>
            <input class="form-control" value="" id="asal" name="asal" autocomplete="off" required>
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
                <th width="5">#</th>
                <th>NO SPB</th>
                <th>Tujuan</th>
                <th>Service</th>
                <th>Coli</th> 
                <th>KG</th> 
              </thead>        
            </table>
          </div>
        </div>

    </div>
    <br>
       <div class="col-sm-12"> 
 
          <div class="form-group text-right">
              <a href="#" class="btn btn-sm btn-default" id="jumlah"><i class="fa fa-calculator"></i> Jumlahkan</a>    
             
          </div>
     
        </div>
   
      <div class="col-md-8">
      </div>
      <div class="col-md-2">
       <input class="form-control" placeholder="coli" type="text" value="" id="jcoli" name="jcoli">
</div>
      <div class="col-md-2">
       <input class="form-control" placeholder="kg" type="text" value="" id="jkg" name="jkg">
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
  data-main="<?php echo base_url()?>assets/js/main/main-manifest.js" 
  src="<?php echo base_url()?>assets/js/require.js">
</script>