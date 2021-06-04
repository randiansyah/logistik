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
    <h3 class="box-title"><i class="fa fa-tag"></i> List Pickup</h3>
        <input type="hidden" id="kdprop_asal_selected" value="<?php echo $KDPROP_asal?>">
        <input type="hidden" id="kdkab_asal_selected" value="<?php echo $KDKAB_asal?>">     
        <input type="hidden" id="kdprop_tujuan_selected" value="<?php echo $KDPROP_tujuan?>">
        <input type="hidden" id="kdkab_tujuan_selected" value="<?php echo $KDKAB_tujuan?>">  
   
    </div>
     <form id="karyawan" method="post" enctype="multipart/form-data">
    <div class="box-body">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group"> 
  
           <div class="form-group">
            <label for="">ID TRANSAKSI</label>
            <input class="form-control" value="<?php echo $pickup; ?>" id="id_transaksi" name="id_transaksi" autocomplete="off" required readonly>
          </div>
            <div class="form-group">
            <label for="">Kode Pickup</label>
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
          <input class="form-control" value="<?php echo $waktu_input; ?>" id="waktu_input" name="waktu_input" autocomplete="off" readonly="">
           </div>
          </div>
          
          
          </div>
        
    </div>
    <table id="myTable" class=" table order-list">
    <thead>
        <th width="50">No</th>
           <th class="text-center">Jenis Paket</th>
                <th class="text-center">Nama Barang</th>
                <th class="text-center">Harga Barang</th>
                <th class="text-center">Jenis Barang</th>
                 <th  width="90">Berat /KG</th>
                 <th  width="90">Panjang /cm</th>
                 <th  width="90">Lebar /cm</th>
                 <th  width="90">Tinggi /cm</th>
                 <th class="text-center">Tambahan Layanan</th>
   
    </thead>
    <tbody>
      <?php $total_berat=0; $i=1; foreach ($barang as $val) {
        # code...
        $total_berat = $total_berat + $val->berat;
      ?>

        <tr>
      <td class="text-center"><?php echo $i; ?></td>
      <td class="text-center"><input type="text" class="form-control" value="<?php echo $val->jenis_paket ?>"></td>
      <td class="text-center"><input type="text" class="form-control" value="<?php echo $val->nama_barang ?>"></td>
       <td class="text-center"><input type="text" class="form-control" value="<?php echo "Rp.".number_format($val->harga_barang, 0, ".", ".") ?>"></td>
      <td class="text-center"><input type="text" class="form-control" value="<?php echo $val->jenis_barang ?>"></td>
      <td class="text-center"><input type="text" id="beratnya" id-tr="<?php echo $i-1; ?>" name="beratnya[]" class="form-control" value="<?php echo $val->berat ?>"></td>
      <td class="text-center"><input type="text" class="form-control" value="<?php echo $val->panjang ?>"></td>     
      <td class="text-center"><input type="text" class="form-control" value="<?php echo $val->lebar ?>"></td>  
      <td class="text-center"><input type="text" class="form-control" value="<?php echo $val->tinggi ?>"></td>     
      <td class="text-center">
    <input type="checkbox"  value="1" name="packing" id="packing" <?php if($val->packing == '1'){echo "checked";} ?>> 
             Packing
              </label><br>
  <input type="checkbox"  value="1" name="packing" id="packing" <?php if($val->asuransi == '1'){echo "checked";} ?>> 
             Asuransi
              </label>
      </td>
               
        </tr>
        <?php
 $i++;
      }
      ?>
    </tbody>
<tfoot>
  <tr>
    <td></td>
     <td></td>
      <td></td>
       <td></td>

      <td class="text-center"><input type="text" class="form-control" value="Berat Total"></td>
       <td><input type="text" class="form-control" name="total_berat" readonly value="<?php echo $total_berat ?>"></td>
        <td></td>
  </tr>

</tfoot>
</table>
         <div class="box-footer">
          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
   
                 <a href="<?php echo base_url($this->uri->segment(1))?>" class="btn btn-default"> Kembali</a>
            </div>
          </div>
      </div>
    </form>
  </div>
</section>

              

<script 
  data-main="<?php echo base_url()?>assets/js/main/main-transaksi" 
  src="<?php echo base_url()?>assets/js/require.js">
</script>