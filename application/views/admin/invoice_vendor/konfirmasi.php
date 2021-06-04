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
    <h3 class="box-title"><i class="fa fa-tag"></i>Invoice Vendor</h3>
       
 
   
    </div>
     <form id="karyawan" method="post" enctype="multipart/form-data">
    <div class="box-body">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group"> 
  
           <div class="form-group">
            <label for="">ID Invoice</label>
       <input class="form-control" value="<?php echo $kode; ?>" id="kode" name="kode" autocomplete="off" required readonly>
          </div>
           
           <div class="form-group">
            <label for="">ID Manifest</label>
            <input class="form-control" value="<?php echo $id_transaksi; ?>" id="id_transaksi" name="id_transaksi" autocomplete="off" required readonly>
          </div>
          <div class="form-group">  
           
                <label for=""> Pilih Vendor</label>
                <select id="pelanggan" name="pelanggan" class="form-control">
                  <option value="">Pilih salah satu</option>
                  <?php
                  foreach ($vendor as $key => $val) { ?>
      <option value="<?php echo $val->id;?>"  <?php echo $val->id == $vendorData ? 'selected' : '' ?>><?php echo $val->nama ?></option>
                  <?php }
                  ?>
                </select>
            
            </div>
         
        
          
         
         
     
        </div>
      </div>
      <div class="col-md-6">

             

        
       
           

               <div class="form-group row">
                <div class="col-md-6">
           <label for="">User input</label>
      <input class="form-control" type="hidden" value="<?php echo $this->data['users']->id;?>" id="user_input" name="user_input">

          <input class="form-control" value="<?php echo $this->data['users']->first_name;?>"autocomplete="off" readonly>
          </div>
           <div class="col-md-6">
              <label for="">Waktu input</label>
          <input class="form-control" value="<?php echo $waktu_input; ?>" id="waktu_input" name="waktu_input" autocomplete="off" readonly="">
           </div>
          </div>
          
      

           <div class="form-group row">
             <div class="col-md-6">
           <label for="">Tgl Pengajuan</label>
      <input class="form-control datetime"  type="text" id="tgl_rilis" name="tgl_rilis">
    
          </div>
            <div class="col-md-6">
           <label for="">Tgl Jatuh Tempo</label>
      <input class="form-control datetime"  type="text" id="tgl_jatuh_tempo" name="tgl_jatuh_tempo">
  
          </div>
         
          </div>
          
          </div>
        
    </div>
<style type="text/css">
  .w-auto{
  width: 95px;
}
</style>
  <div class="box-body table-responsive no-padding">
  <table id="" class="table table-striped dataTable no-footer">
    <thead>
        <th >No</th>
           <th>No Spb</th>
            <th>Asal</th>
               <th>Tujuan</th>
              <th>Service</th>
               <th >Coli</th>
                <th>Kg</th>
                <th class="btn-info">Harga Satuan Coli</th>
                <th class="btn-info">Harga Satuan Kg</th>
               <th class="btn-info" text-center>Total</th>

   
    </thead>
    <tbody>
      <?php  $i=1; foreach ($spb as $val) {
  
      ?>

        <tr>
      <td class="text-center"><b><?php echo $i; ?></b>
<input type="hidden" name="no[]" class="form-control" value="<?php echo $i; ?>">

      </td>
    <td class="text-center"><input type="text" name="spb[]" class="form-control w-auto" value="<?php echo $val->SPB ?>"></td>
    <td>
  <input type="text" name="asal[]"   class="form-control w-auto" value="<?php echo $val->asal ?>">
      </td>
 <td>
  <input type="text" name="tujuan[]"   class="form-control w-auto" value="<?php echo $val->tujuan ?>">
      </td>

       <td>
  <input type="text" name="service[]"   class="form-control w-auto" value="<?php echo $val->service ?>">
      </td>
<td><input type="text" class="form-control w-auto" id-tr="<?php echo $i-1; ?>" name="coli[]" value="<?php echo $val->jumlah_coli ?>"></td>
<td><input type="text" class="form-control w-auto" id-tr="<?php echo $i-1; ?>" name="kg[]" value="<?php echo $val->berat ?>"></td>

      
<td><input type="text" class="harga_coli form-control harga w-auto" id-tr="<?php echo $i-1; ?>" name="harga_coli[]" value="">
<input type="hidden" class="form-control" id-tr="<?php echo $i-1; ?>" name="total_harga_coli_convert[]">
</td>
<td><input type="text" class="harga_kg form-control harga w-auto" id-tr="<?php echo $i-1; ?>" name="harga_kg[]" value="">
<input type="hidden" class="form-control" id-tr="<?php echo $i-1; ?>" name="total_harga_kg_convert[]" value="">
</td>

  
  <td><input type="text" id-tr="<?php echo $i-1; ?>"  class="total_harga form-control harga w-auto" id="total_harga" name="total_harga[]" value="">
 <input type="hidden" class="form-control " name="total_harga_convert[]">
  </td>    






        </tr>
        <?php
 $i++;
      }
      ?>
    </tbody>

</table>
</div>
<br>
  <div class="row">
 <div class="col-md-6">
           
           
           </div>
          <div class="col-md-6 text-right">
       <button type="button" id="hitung_total" class="btn btn-light">Hitung Total</button>
          </div>
             <div class="col-md-6">
       <label for="">Catatan</label>
        <textarea cols="3" rows="3" value="" class="form-control" id="catatan" name="catatan"></textarea>            
    
           </div>
          
              
      <div class="col-md-3">
         <label for="" >Sub Total Harga Coli</label>
          <input class="form-control harga" value="" id="total_harga_coli" name="total_harga_coli" autocomplete="off">
           </div>
           <div class="col-md-3">
         <label for="">Sub Total Harga Kg</label>
          <input class="form-control harga" value="" id="total_harga_kg" name="total_harga_kg" autocomplete="off">

           </div>
        
            <div class="col-md-6">

          
           </div>
         <div class="col-md-3">
        
           </div>
          <div class="col-md-3">
             <br>
         <label for="">Total Tagihan</label>
          <input class="form-control harga"  value="" id="total" name="total" autocomplete="off">
           </div>
           
          </div>
 
  

         <div class="box-footer">
          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
              <button type="submit" class="btn btn-primary">Konfirmasi</button>
                 <a href="<?php echo base_url($this->uri->segment(1))?>" class="btn btn-default"> BATAL</a>
            </div>
          </div>
      </div>
    </form>
  </div>
</section>

              

<script 
  data-main="<?php echo base_url()?>assets/js/main/main-invoice_vendor.js" 
  src="<?php echo base_url()?>assets/js/require.js">
</script>