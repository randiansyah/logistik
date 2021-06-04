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
            <input class="form-control" value="<?php echo $id_transaksi; ?>" id="id_transaksi" name="id_transaksi" autocomplete="off" required readonly>
          </div>
          <div class="form-group">  
           
                <label for="">Customer</label>
                <select id="pelanggan" name="pelanggan" class="form-control">
                  <option value="">Pilih salah satu</option>
                  <?php
                  foreach ($pelanggan as $key => $val) { ?>
      <option value="<?php echo $val->id;?>"  <?php echo $val->id == $vendorData ? 'selected' : '' ?>><?php echo $val->nama ?></option>
                  <?php }
                  ?>
                </select>
            
            </div>
         <div class="form-group">
        <label for="">Catatan Tambahan</label>
        <textarea cols="3" rows="3" value="" class="form-control" id="catatan" name="catatan">
        </textarea>            
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
           <label for="">Tgl Rilis</label>
      <input class="form-control datetime" value="<?php echo $created_at ?>"  type="text" id="tgl_rilis" name="tgl_rilis">
    
          </div>
            <div class="col-md-6">
           <label for="">Tgl Jatuh Tempo</label>
      <input class="form-control datetime" value="" type="text" id="tgl_jatuh_tempo" name="tgl_jatuh_tempo">
  
          </div>
         
          </div>
          
          </div>
        
    </div>
  
  <table id="myTable" class=" table order-list">
    <thead>
        <th width="50">No</th>
                 <th>No Spb</th>
               <th  width="100">Asal</th>
               <th>Tujuan</th>
              <th>Service</th>
               <th width="80">Coli</th>
                <th width="80">Kg</th>
                <th class="btn-info">Opsi Harga</th>
                <th class="btn-info">Harga Satuan </th>
               <th class="btn-info" text-center>Jumlah</th>

   
    </thead>
    <tbody>
      <?php  $i=1; foreach ($spb as $val) {
  
      ?>

        <tr>
      <td class="text-center"><b><?php echo $i; ?></b>
<input type="hidden" name="no[]" class="form-control" value="<?php echo $i; ?>">
<input type="hidden" name="jadwal_delivery[]" class="form-control" value="<?php echo $val->tanggal; ?>">
      </td>
    <td class="text-center"><input type="text" name="spb[]" class="form-control" value="<?php echo $val->SPB ?>"></td>
    <td>
  <input type="text" name="asal[]"   class="form-control" value="<?php echo $val->asal ?>">
      </td>
 <td>
  <input type="text" name="tujuan[]"   class="form-control" value="<?php echo $val->tujuan ?>">
      </td>

       <td>
  <input type="text" name="service[]"   class="form-control" value="<?php echo $val->service ?>">
      </td>
<td><input type="text" class="form-control" id-tr="<?php echo $i-1; ?>" name="coli[]" value="<?php echo $val->jumlah_coli ?>"></td>
<td><input type="text" class="form-control" id-tr="<?php echo $i-1; ?>" name="kg[]" value="<?php echo $val->berat_total ?>"></td>

      
<td>
  <input type="hidden" name="getOption[]" id-tr="<?php echo $i-1; ?>">
   <select class="form-control optionnya" id="opsi_satuan" name="opsi_satuan[]"  id-tr="<?php echo $i-1; ?>">
                  <option>Pilih</option>              
                  <option value="kg" <?php if($val->opsi_satuan == 'kg'){echo "selected";} ?>>KG</option>   
                  <option value="unit"<?php if($val->opsi_satuan  == 'unit'){echo "selected";} ?>>Unit</option> 
                  <option value="coli" <?php if($val->opsi_satuan  == 'coli'){echo "selected";} ?>>Coli</option> 
                  <option value="cu"<?php if($val->opsi_satuan  == 'cu'){echo "selected";} ?>>Coli & Unit</option> 
                  <option value="ku"<?php if($val->opsi_satuan  == 'ku'){echo "selected";} ?>>KG & Unit</option>   
                  <option value="kc"<?php if($val->opsi_satuan  == 'kc'){echo "selected";} ?>>KG & Coli</option>  
                </select>
</td>


<td><input type="text" class="harga_satuan form-control harga" id-tr="<?php echo $i-1; ?>" name="harga_satuan[]"  value="">

</td>

  
  <td><input type="text" id-tr="<?php echo $i-1; ?>"  class="total_harga form-control harga" id="total_harga" name="total_harga[]"  value="">
 <input type="hidden" class="form-control" id-tr="<?php echo $i-1; ?>" name="total_harga_satuan_convert[]">
  </td>    






        </tr>
        <?php
 $i++;
      }
      ?>
    </tbody>

</table>
<br>
  <div class="row">
 <div class="col-md-6">
           
           
           </div>
          <div class="col-md-6 text-right">
       <button type="button" id="hitung_total" class="btn btn-light">Hitung Total</button>
          </div>
 <div class="col-md-12">
             <div class="col-md-3">
       
           </div>
          
              
      <div class="col-md-3">
         <label for="" >Sub Total Harga</label>
          <input class="form-control harga" value="" id="sub_total" name="sub_total" autocomplete="off">
           </div>

              <div class="col-md-3">
         <label for="" >Pajak</label>
          <input class="form-control harga pajak" value="0" id="pajak" name="pajak" autocomplete="off">
            <input  type="hidden" value="0" id="pajak_convert" name="pajak_convert" autocomplete="off">
           </div>
           <div class="col-md-3">
         <label for="">Total</label>
          <input class="form-control harga" value="" id="total" name="total" autocomplete="off">

           </div>
         </div>
         <div class="col-md-12">
          <div class="col-md-3">
            
          </div>
           <div class="col-md-3">
            <br>
         <label for="" >Harga Packing</label>
     <input class="form-control harga packing" value="0" id="harga_packing" name="harga_packing" autocomplete="off">
        <input  type="hidden" value="" id="harga_packing_convert" name="harga_packing_convert" autocomplete="off">
           </div>

              <div class="col-md-3">
                 <br>
         <label for="" >Harga Asuransi</label>
          <input class="form-control harga asuransi" value="0" id="harga_asuransi" name="harga_asuransi" autocomplete="off">
            <input  type="hidden" value="" id="harga_asuransi_convert" name="harga_asuransi_convert" autocomplete="off">
           </div>
       <div class="col-md-3">
           <br>
         <label for="">Grand Total</label>
          <input class="form-control harga"   value="" id="grand_total" name="grand_total" autocomplete="off">
           </div>
      
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
  data-main="<?php echo base_url()?>assets/js/main/main-invoice_cs.js" 
  src="<?php echo base_url()?>assets/js/require.js">
</script>