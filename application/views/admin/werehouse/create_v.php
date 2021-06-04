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
    <h3 class="box-title"><i class="fa fa-tag"></i> Tambah Pesanan</h3>
    </div>
     <form id="karyawan" method="post" enctype="multipart/form-data">
    <div class="box-body">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group"> 
  
           <div class="form-group">
            <label for="">ID TRANSAKSI</label>
            <input class="form-control" value="<?php echo $kode; ?>" id="id_transaksi" name="id_transaksi" autocomplete="off" required readonly>
          </div>
          <div class="form-group">  
           
                <label for=""> Pilih Customer</label>
                <select id="pelanggan" name="pelanggan" class="form-control">
                  <option value="" required>Pilih salah satu</option>
                  <?php
                  foreach ($pelanggan as $key => $val) { ?>
      <option value="<?php echo $val->id;?>"><?php echo $val->nama ?></option>
                  <?php }
                  ?>
                </select>
            
            </div>
         
             <div class="form-group">
            <label for="">Pengiriman Via</label>
             <select class="form-control select2" id="kirim_via" name="kirim_via"  required >
                  <option>Pilih salah satu</option>              
                  <option value="Darat">[Darat] Pengiriman Via Darat</option>   
                  <option value="Laut">[Laut] Pengriman Via Laut</option> 
                  <option value="Udara">[Udara] Pengiriman Via Udara</option>
                 
                </select>
          </div>
         <div class="form-group">
            <label for="">Jenis Pengiriman</label>
             <select class="form-control select2" id="jenis_pengiriman" name="jenis_pengiriman"  required >
                  <option>Pilih salah satu</option>              
                  <option value="Dokumen">Dokumen</option>   
                  <option value="Paket">Paket</option> 
                  <option value="Lainnya">Lainnya</option> 
                </select>
          </div>
             <div class="form-group">
            <label for="">Jenis Pembayaran</label>
             <select class="form-control select2" id="jenis_pembayaran" name="jenis_pembayaran"  required >
                  <option>Pilih salah satu</option>              
                  <option value="Cash">Cash</option>   
                  <option value="Kredit">Kredit</option> 
               
                </select>
          </div>
          <div class="form-group">
              <label for="">Harga Barang</label>
      <input class="form-control harga" id="harga_barang" name="harga_barang" autocomplete="off">
          </div>
           
           <div class="form-group">
            <label for="">Jenis Barang</label>
        <textarea cols="4" rows="5" class="form-control" id="jenis_barang" name="jenis_barang"></textarea>            
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
                      echo '<option value="'.$data->kdprop.'">'.$data->nmprop.'</option>';
                      endforeach;
                    ?>
                  </select> 
                </div>
                <div class="col-md-6">
                  <label>-</label>
                  <select class="form-control filter-column fkdkab" id="kdkab" name="kdkab" required>
                      <option value="" selected>Semua Kab / Kota</option>
                  </select>
                </div>           
              </div> 
               <div class="form-group row">
                <div class="col-md-6">
                  <label for="">Tujuan Pengiriman</label> 
                  <select class="form-control filter-column fkdprop" id="kdprop_tujuan" name="kdprop_tujuan" required>
                    <option value="" selected>Semua Provinsi</option>
                    <?php
                      foreach($data_provinsi as $data):
                      echo '<option value="'.$data->kdprop.'">'.$data->nmprop.'</option>';
                      endforeach;
                    ?>
                  </select> 
                </div>
                <div class="col-md-6">
                  <label>-</label>
                  <select class="form-control filter-column fkdkab" id="kdkab_tujuan" name="kdkab_tujuan" required>
                      <option value="" selected>Semua Kab / Kota</option>
                  </select>
                </div>           
              </div> 

           <div class="form-group row">
              <div class="col-md-8">
                  <label for="">Berat Total Perkiraan (Wajib)</label>
               <input class="form-control" id="berat" name="berat" autocomplete="off">
                </div>
                <div class="col-md-4">
                  <label for="">(TON/KG)</label>
               <select class="form-control select2" id="tipe_berat" name="tipe_berat">
                         
                  <option value="KG">KG</option>   
                  <option value="TON">TON</option> 
                  <option value="KOLI">KOLI</option>
                 
                </select>
                </div>
          </div>
            <div class="form-group row">
             <div class="col-md-3">
            <label for="">Ukuran BRG</label>
      <input class="form-control"placeholder="Panjang" id="panjang" name="panjang" autocomplete="off">

                        </div>
                           <div class="col-md-3">
            <label for="">-</label>
      <input class="form-control"placeholder="Lebar" id="lebar" name="lebar" autocomplete="off">

                        </div>
                        <div class="col-md-3">
            <label for="">-</label>
      <input class="form-control"placeholder="Tinggi" id="tinggi" name="tinggi" autocomplete="off">

                        </div>
                        <div class="col-md-3">
            <label for="">-</label>
            <input class="form-control"placeholder="CM" readonly>

                        </div>
          </div>
          <div class="form-group row">
            <div class="col-md-6">
              <label for="">Tambahan Layanan</label> 
            <div class="checkbox">
              <label>
                 <input type="checkbox" value="1" name="packing" id="packing"> 
              Tambah Packaging
              </label>
                </div>
                
            </div>
             <div class="col-md-6">
         <label for="">-</label> 
            <div class="checkbox">
              <label>
                 <input type="checkbox" value="1" name="asuransi" id="asuransi"> 
              Tambah Asuransi
              </label>
                </div>
               
          </div>
         </div>
         <div class="form-group">
            <label for="">Alamat Pick up</label>
        <textarea cols="4" rows="5" class="form-control" id="alamat" name="alamat"></textarea>            
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
         <div class="box-footer">
          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
              <button type="submit" class="btn btn-primary pull-right">Simpan</button>
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