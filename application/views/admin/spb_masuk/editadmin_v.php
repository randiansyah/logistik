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
    <h3 class="box-title"><i class="fa fa-tag"></i>UBAH SPB BARANG MASUK</h3>
        <input type="hidden" id="kdprop_asal_selected" value="<?php echo $KDPROP_asal?>">
        <input type="hidden" id="kdkab_asal_selected" value="<?php echo $KDKAB_asal?>">     
        <input type="hidden" id="kdprop_tujuan_selected" value="<?php echo $KDPROP_tujuan?>">
        <input type="hidden" id="kdkab_tujuan_selected" value="<?php echo $KDKAB_tujuan?>"> 
        <input class="form-control" type="hidden" value="<?php echo $sales?>" id="sales" name="sales">
 
   
    </div>
     <form id="karyawan" method="post" enctype="multipart/form-data">
    <div class="box-body">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group"> 
  
           <div class="form-group">
            <label for="">ID TRANSAKSI</label>
            <input class="form-control" value="<?php echo $delivery; ?>" id="delivery" name="delivery" autocomplete="off" required readonly>
          </div>
           <div class="form-group">
            <label for="">Kode Pickup</label>
            <input class="form-control" value="<?php echo $pickup; ?>" id="pickup" name="pickup" autocomplete="off" required readonly>
          </div>
           <div class="form-group">
            <label for="">Kode Delivery</label>
            <input class="form-control" value="<?php echo $id_transaksi; ?>" id="id_transaksi" name="id_transaksi" autocomplete="off" required readonly>
          </div>
          <div class="form-group">  
           
                <label for=""> Pilih Customer</label>
                <select id="pelanggan" name="pelanggan" class="form-control">
                  <option value="" required>Pilih salah satu</option>
                  <?php
                  foreach ($pelanggan as $key => $val) { ?>
      <option value="<?php echo $val->id;?>"  <?php echo $val->id == $kode_pelanggan ? 'selected' : '' ?>><?php echo $val->nama ?></option>
                  <?php }
                  ?>
                </select>
            
            </div>
         
             <div class="form-group">
            <label for="">Pengiriman Via</label>
             <select class="form-control select2" id="kirim_via" name="kirim_via"  required >
                  <option>Pilih salah satu</option>              
                  <option value="Darat" <?php if($kirim_via == 'Darat'){echo "selected";} ?>>[Darat] Pengiriman Via Darat</option>   
                  <option value="Laut" <?php if($kirim_via == 'Laut'){echo "selected";} ?>>[Laut] Pengriman Via Laut</option> 
                  <option value="Udara" <?php if($kirim_via == 'Udara'){echo "selected";} ?>>[Udara] Pengiriman Via Udara</option>
                 
                </select>
          </div>
         <div class="form-group">
            <label for="">Jenis Pengiriman</label>
             <select class="form-control select2" id="jenis_pengiriman" name="jenis_pengiriman"  required >
                  <option>Pilih salah satu</option>              
                  <option value="Dokumen" <?php if($jenis_pengiriman == 'Dokumen'){echo "selected";} ?>>Dokumen</option>   
                  <option value="Paket" <?php if($jenis_pengiriman == 'Paket'){echo "selected";} ?>>Paket</option> 
                  <option value="Lainnya" <?php if($jenis_pengiriman == 'Lainnya'){echo "selected";} ?>>Lainnya</option> 
                </select>
          </div>
             <div class="form-group">
            <label for="">Jenis Pembayaran</label>
             <select class="form-control select2" id="jenis_pembayaran" name="jenis_pembayaran"  required >
                  <option>Pilih salah satu</option>              
                  <option value="Cash" <?php if($jenis_pembayaran == 'Cash'){echo "selected";} ?>>Cash</option>   
                  <option value="Kredit" <?php if($jenis_pembayaran == 'Kredit'){echo "selected";} ?>>Kredit</option> 
               
                </select>
          </div>
         
            <div class="form-group">
            <label for="">Jadwal Pick up</label>
             <input class="form-control" value="<?php echo $jadwal_pickup ?>" id="waktu_input" name="waktu_input" autocomplete="off" readonly="">  
          </div>
          <div class="form-group">
            <label for="">Catatan Tambahan</label>
             <textarea class="form-control" value="" id="catatan" name="catatan" autocomplete="off"></textarea> 
          </div>
     
        </div>
      </div>
      <div class="col-md-6">
   <div class="form-group row">
                <div class="col-md-6">
                  <label for="">Asal Pengiriman</label> 
                  <select class="form-control filter-column fkdprop" id="kdprop" name="kdprop" required>
                    <option value="" selected>Semua Provinsi</option>
                    <?php
                      foreach($data_provinsi as $data):
                        if($KDPROP_asal == $data->kdprop){
                          echo '<option value="'.$data->kdprop.'" selected>'.$data->nmprop.'</option>';
                        }else{
                          echo '<option value="'.$data->kdprop.'">'.$data->nmprop.'</option>';
                        }
                      endforeach;
                    ?>
                  </select> 
                </div>
                <div class="col-md-6">
                  <label>-</label>
                  <select class="form-control filter-column fkdkab" id="kdkab" name="kdkab" >
                      <option value="" selected>Semua Kab / Kota</option>
                     
                    ?>
                  </select>
                </div>           
              </div> 
               <div class="form-group row">
                <div class="col-md-6">
                  <label for="">Tujuan Pengiriman</label> 
                  <select class="form-control filter-column fkdprop" id="kdprop_tujuan" name="kdprop_tujuan" >
                    <option value="" selected>Semua Provinsi</option>
                    <?php
                      foreach($data_provinsi as $data):
                     if($KDPROP_tujuan == $data->kdprop){
                          echo '<option value="'.$data->kdprop.'" selected>'.$data->nmprop.'</option>';
                        }else{
                          echo '<option value="'.$data->kdprop.'">'.$data->nmprop.'</option>';
                        }
                      endforeach;
                    ?>
                  </select> 
                </div>
                <div class="col-md-6">
                  <label>-</label>
                  <select class="form-control filter-column fkdkab" id="kdkab_tujuan" name="kdkab_tujuan" >
                      <option value="" selected>Semua Kab / Kota</option>
                  </select>
                </div>           
              </div> 

         <div class="form-group">
            <label for="">Alamat Tujuan</label>
        <textarea cols="4" rows="5" vlaue="<?php echo $alamat_tujuan ?>" class="form-control" id="alamat_tujuan" name="alamat_tujuan"><?php echo $alamat_tujuan ?></textarea>            
          </div>
         <div class="form-group">
            <label for="">Alamat Pick up</label>
        <textarea cols="4" rows="5" vlaue="<?php echo $alamat ?>" class="form-control" id="alamat" name="alamat"><?php echo $alamat ?></textarea>            
          </div>
           

               <div class="form-group row">
                <div class="col-md-6">
           <label for="">User input</label>
      <input class="form-control" type="hidden" value="<?php echo $this->data['users']->id;?>" id="user_input" name="user_input">

          <input class="form-control" value="<?php echo $this->data['users']->first_name;?>"autocomplete="off" readonly>
          </div>
           <div class="col-md-6">
              <label for="">Waktu input</label>
          <input class="form-control datetime" value="<?php echo date('Y-m-d'); ?>" id="waktu_input" name="waktu_input" autocomplete="off">
           </div>
          </div>
             <div class="form-group">  
           
                <label for=""> Pilih Vendor</label>
                <select id="vendor" name="vendor" class="form-control" required>
                  <option value="" >Pilih salah satu</option>
                  <?php
                  foreach ($vendor as $key => $val) { ?>
      <option value="<?php echo $val->id;?>" <?php echo $val->id==$kode_vendor ? 'selected' : '' ?>><?php echo $val->nama ?></option>
                  <?php }
                  ?>
                </select>
            
            </div>
           <div class="form-group">
            
           <label for="">Waktu Delivery</label>
      <input class="form-control datetime"  type="text" id="jadwal_delivery" name="jadwal_delivery">

         
         
          </div>
          
          </div>
        
    </div>
    <div class="form-group row">
                <div class="col-md-12">
                  <label>Barang</label>
   <div class="box-body table-responsive no-padding">
 <table id="" class="table table-hover">
    <thead>
        <th width="50">No</th>
                 <th class="text-center">Jenis Barang</th>
                <th class="text-center">Harga Barang</th>
                 <th  width="">Jumlah Coli</th>
                 <th  width="">Berat /KG</th>
                  <th  width="">Total /KG</th>
                 <th  width="">Panjang /cm</th>
                 <th  width="">Lebar /cm</th>
                 <th  width="">Tinggi /cm</th>
                 <th>Tambahan Layanan</th>
   
    </thead>
    <tbody>
      <?php $total_berat=0; $i=1; foreach ($barang as $val) {
        # code...
        $total_berat = $total_berat + $val->berat;
      ?>

        <tr>
      <td class="text-center"><?php echo $i; ?>
      </td>
      <td><input type="text" class="form-control" value="<?php echo $val->jenis_barang?>"></td>

      <td class="text-center"><input type="text" name="" class="form-control" value="<?php echo "Rp.".number_format($val->harga_barang, 0, ".", ".") ?>" >
      </td>
<td class="text-center">
      <input type="text" name=""  id-tr="<?php echo $i-1; ?>" class="form-control" value="<?php echo $val->jumlah_coli ?>">
    </td>
   
   
    <td class="text-center">
      <input type="text" name=""  id-tr="<?php echo $i-1; ?>" class="berat form-control" value="<?php echo $val->berat ?>">
    </td>
    <td>
      <input type="text" name=""  id-tr="<?php echo $i-1; ?>" class="form-control" value="<?php echo $val->berat_total ?>">

    </td>

      <td class="text-center"><input type="text" name="" class="form-control" value="<?php echo $val->panjang ?>"></td>     
      <td class="text-center"><input type="text" name="" class="form-control" value="<?php echo $val->lebar ?>"></td>  
      <td class="text-center"><input type="text" name="" class="form-control" value="<?php echo $val->tinggi ?>"></td>     
      <td>
    <input type="checkbox"  value="1" name="" id="" <?php if($val->packing == '1'){echo "checked";} ?>> 
            packing
            <br>
           
      
  <input type="checkbox"  value="" name="" id="asuransi" <?php if($val->asuransi == '1'){echo "checked";} ?>> 
             Asuransi
         
      </td>
               
        </tr>
        <?php
 $i++;
      }
      ?>
    </tbody>

</table>
</div>
</div>
</div>

 <label>Rincian Harga</label>
 <div class="box-body table-responsive no-padding">
 <table id="" class="table table-hover">
    <thead>
        <th width="50">No</th>
     <th>Jml Packing </th>
               <th>Harga Packing </th>
               
              <th>Asuransi </th>
            <th >Jumlah</th>
               <th width="15%">opsi satuan</th>
                <th>Harga satuan</th>
                <th class="btn-info">Total Biaya Packing </th>
                <th class="btn-info">Total Biaya Asuransi </th>
               <th class="btn-info">Total Biaya satuan</th>

   
    </thead>
    <tbody>
      <?php $total_berat=0; $i=1; foreach ($barang as $val) {
        # code...
        $total_berat = $total_berat + $val->berat;
      ?>

<input type="hidden" name="harga_barang[]" id-tr="<?php echo $i-1; ?>" value="<?php echo $val->harga_barang ?>"> 
<input type="hidden" name="jenis_barang[]" value="<?php echo $val->jenis_barang ?>"> 
<input type="hidden" name="berat[]" value="<?php echo $val->berat ?>"> 
<input type="hidden" name="panjang[]" value="<?php echo $val->panjang ?>" id-tr="<?php echo $i-1; ?>"> 
<input type="hidden" name="lebar[]" value="<?php echo $val->lebar ?>" id-tr="<?php echo $i-1; ?>"> 
<input type="hidden" name="tinggi[]" value="<?php echo $val->tinggi ?>" id-tr="<?php echo $i-1; ?>"> 
<input type="hidden" id="jumlah_coli" name="jumlah_coli[]" id-tr="<?php echo $i-1; ?>"  class="form-control" value="<?php echo $val->jumlah_coli ?>">
<input type="hidden" name="berat_total[]"  id-tr="<?php echo $i-1; ?>" value="<?php echo $val->berat_total ?>"> 
<input type="checkbox" style="opacity:0"  value="<?php echo $val->packing ?>" name="packing[]" id-tr="<?php echo $i-1; ?>" <?php if($val->packing == '1'){echo "checked";} ?>> 
<input type="checkbox" style="opacity:0"  value="<?php echo $val->asuransi ?>" name="asuransi[]" id-tr="<?php echo $i-1; ?>" <?php if($val->asuransi == '1'){echo "checked";} ?>> 
<input type="checkbox" id-tr="<?php echo $i-1; ?>" style="opacity:0"  value="<?php echo $val->packing_k ?>" name="packing_kayu[]" id="" <?php if($val->packing_k == '1'){echo "checked";} ?>> 

<input type="checkbox" style="opacity:0"  id-tr="<?php echo $i-1; ?>" value="<?php echo $val->packing ?>" name="packing_s[<?php echo $i-1; ?>]"  <?php if($val->packing == '1'){echo "checked";} ?>> 
<input type="checkbox" style="opacity:0" id-tr="<?php echo $i-1; ?>" value="<?php echo $val->asuransi ?>" name="asuransi_s[<?php echo $i-1; ?>]"  <?php if($val->asuransi == '1'){echo "checked";} ?>> 

        <tr>
      <td class="text-center"><b><?php echo $i; ?></b>
<input type="hidden" name="no[]" value="<?php echo $i ?>">  
      </td>
<td>
  <input type="text" class="form-control jumlah_packing" id-tr="<?php echo $i-1; ?>" name="jumlah_packing[]"  value="<?php echo $val->jumlah_coli_cs ?>" autocomplete="off">
</td>

  <td><input type="text" class="harga_packing form-control harga" id-tr="<?php echo $i-1; ?>" name="harga_packing[]" id="harga_packing" value="<?php echo "Rp. ".number_format($val->harga_packing, 0, ".", ".") ?>" autocomplete="off"></td>

<td><input type="text" class="harga_asuransi form-control harga" id-tr="<?php echo $i-1; ?>" name="harga_asuransi[]" id="harga_asuransi" value="<?php echo "Rp. ".number_format($val->harga_asuransi, 0, ".", ".") ?>" autocomplete="off"></td>  
<td><input type="text" class="jumlah form-control" id-tr="<?php echo $i-1; ?>" name="jumlah[]" id="jumlah" value="<?php echo $val->jumlah ?>" autocomplete="off"></td>  
<td>

  <input type="hidden" name="getOption[]" id-tr="<?php echo $i-1; ?>">
 <select class="form-control select2 optionnya" id="opsi_satuan" name="opsi_satuan[]"  id-tr="<?php echo $i-1; ?>">
                  <option>Pilih</option>              
                  <option value="kg" <?php if($val->opsi_satuan == 'kg'){echo "selected";} ?>>KG</option>   
                  <option value="unit"<?php if($val->opsi_satuan  == 'unit'){echo "selected";} ?>>Unit</option> 
                  <option value="coli" <?php if($val->opsi_satuan  == 'coli'){echo "selected";} ?>>Coli</option> 
                  <option value="cu"<?php if($val->opsi_satuan  == 'cu'){echo "selected";} ?>>Coli & Unit</option> 
                  <option value="ku"<?php if($val->opsi_satuan  == 'ku'){echo "selected";} ?>>KG & Unit</option>   
                  <option value="kc"<?php if($val->opsi_satuan  == 'kc'){echo "selected";} ?>>KG & Coli</option>  
                </select>

</td>
<td ><input type="text" id-tr="<?php echo $i-1; ?>" class="harga_satuan form-control harga" name="harga_satuan[]"  value="<?php echo "Rp. ".number_format($val->harga_satuan, 0, ".", ".") ?>" autocomplete="off"></td>    
  <td><input type="text" id-tr="<?php echo $i-1; ?>"  class="total_harga_packing form-control harga" id="total_harga_packing" name="total_harga_packing[]"  value="<?php echo "Rp. ".number_format($val->total_harga_packing, 0, ".", ".") ?>">
 <input type="hidden" class="form-control " name="total_harga_packing_convert[]">
  </td>    
  <td><input type="text" id-tr="<?php echo $i-1; ?>"  class="total_harga_asuransi form-control harga" id="total_harga_asuransi" name="total_harga_asuransi[]"  value="<?php echo "Rp. ".number_format($val->total_harga_asuransi, 0, ".", ".") ?>" autocomplete="off">
 <input type="hidden" class="total_harga_asuransi_convert form-control " name="total_harga_asuransi_convert[]">
  </td> 
  <td>
    <input type="text" id-tr="<?php echo $i-1; ?>" class="total_harga_satuan form-control harga" name="total_harga_satuan[]" value="<?php echo "Rp. ".number_format($val->total_harga_satuan, 0, ".", ".") ?>"  autocomplete="off">
    <input type="hidden" class="total_harga_satuan_convert form-control " name="total_harga_satuan_convert[]" >


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
               <button type="button" id="hitung" class="btn btn-success">Hitung</button>
         <button type="button" id="resetData" class="btn btn-danger">Reset</button>
      
       <button type="button" id="hitung_total" style="width: 237px;" class="btn btn-info">Hitung Total</button>
          </div>
          
      <div class="col-md-2" >
        <br>
         <label for="" >Sub Total Harga</label>
          <input  class="form-control harga" value="<?php echo "Rp. ".number_format($total_harga, 0, ".", ".") ?>" id="total_harga" name="total_harga" autocomplete="off">
           </div>
         <div class="col-md-2">
       <br>
         <label for="">Pajak</label>
          <input class="form-control harga pajak" value="<?php echo "Rp. ".number_format($pajak, 0, ".", ".") ?>" id="pajak" name="pajak" autocomplete="off">
            <input class="form-control" type="hidden" value="0" name="pajak_convert" autocomplete="off">
           </div>
<div class="col-md-2">
           <br>
         <label for="">Total</label>
          <input class="form-control harga" value="<?php echo "Rp. ".number_format($total, 0, ".", ".") ?>" id="total" name="total" autocomplete="off">
           </div>
           <div class="col-md-2">
            <br>
         <label for="" >Total Harga Packing</label>
          <input class="form-control harga" value="<?php echo "Rp. ".number_format($total_harga_packing, 0, ".", ".") ?>" id="sum_harga_packing" name="sum_harga_packing" autocomplete="off">
           </div>
           <div class="col-md-2">
            <br>
         <label for="">Total Harga Asuransi</label>
          <input class="form-control harga" value="<?php echo "Rp. ".number_format($total_harga_asuransi, 0, ".", ".") ?>" id="sum_harga_asuransi" name="sum_harga_asuransi" autocomplete="off">
           </div>
           <div class="col-md-2">
            <br>
         <label for=""><b><center>Grand Total</center></b></label>
          <input class="form-control harga" value="<?php echo "Rp. ".number_format($total_harga_global, 0, ".", ".") ?>" id="total_harga_global" name="total_harga_global" autocomplete="off">

           </div>
        
           
         
          
           
          </div>
 
  

         <div class="box-footer">
          <div class="row">
            <br>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
              <button type="submit" class="btn btn-primary">Simpan</button>
                 <a href="<?php echo base_url($this->uri->segment(1))?>" class="btn btn-default"> BATAL</a>
            </div>
          </div>
      </div>
    </form>
  </div>
</section>

              

<script 
  data-main="<?php echo base_url()?>assets/js/main/main-input-harga-spb.js" 
  src="<?php echo base_url()?>assets/js/require.js">
</script>