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
     <form id="form" method="post"  enctype="multipart/form-data">
    <div class="box-body">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group"> 
   <div class="form-group row">
              <div class="col-md-6"> 
            <label for="">ID TRANSAKSI</label>
     <input class="form-control" value="<?php echo $kode; ?>" id="id_transaksi" name="id_transaksi" autocomplete="off" required="required"></div>
            <div class="col-md-6"><label for="">--</label><button type="button" id="cekSPB" class="form-control">CEK</button></div>
            <div class="col-md-12">
            
<p class="text-danger" id="dangerSPB"></p>
<p class="text-green" id="suksesSPB"></p>   
 </div>
          </div>
          <div class="form-group">  
           
                <label for=""> Pilih Customer</label>
                <select id="pelanggan" name="pelanggan" class="form-control select2" required="required">
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
             <select class="form-control select2" id="kirim_via" name="kirim_via"  required="required">
                  <option>Pilih salah satu</option>              
                  <option value="Darat">[Darat] Pengiriman Via Darat</option>   
                  <option value="Laut">[Laut] Pengriman Via Laut</option> 
                  <option value="Udara">[Udara] Pengiriman Via Udara</option>
                 
                </select>
          </div>
         <div class="form-group">
            <label for="">Jenis Pengiriman</label>
             <select class="form-control select2" id="jenis_pengiriman" name="jenis_pengiriman"  required="required">
                  <option>Pilih salah satu</option>              
                  <option value="Dokumen">Dokumen</option>   
                  <option value="Paket">Paket</option> 
                  <option value="Lainnya">Lainnya</option> 
                </select>
          </div>
             <div class="form-group">
            <label for="">Jenis Pembayaran</label>
             <select class="form-control select2" id="jenis_pembayaran" name="jenis_pembayaran"  required="required">
                  <option>Pilih salah satu</option>              
                  <option value="Cash">Cash</option>   
                  <option value="Kredit">Kredit</option> 
               
                </select>
          </div>
             <div class="form-group">
            <label for="">Catatan Tambahan</label>
        <textarea cols="4" rows="5" class="form-control" id="catatan" name="catatan" required></textarea>            
          </div>
          
     
        </div>
      </div>
      <div class="col-md-6">
      <div class="form-group">

      <div class="col-md-12">
     
      </div>
      
      </div>
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
            <label for="">Alamat Tujuan / Pengiriman</label>
        <textarea cols="4" rows="5" class="form-control" id="alamat_tujuan" name="alamat_tujuan" required></textarea>            
          </div>
          
        
         <div class="form-group">
            <label for="">Alamat Pick up</label>
        <textarea cols="4" rows="5" class="form-control" id="alamat" name="alamat" required></textarea>            
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
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
     <div class="box-body table-responsive no-padding">
 <table id="" class="table table-hover">
    <thead>
        <th width="50">No</th>
                <th >Jenis Barang</th>
                <th >Harga Barang</th>
              <th>Jumlah Coli</th>
              <th>Berat/ Kg</th>
              
               
                  <th>Tambahan Layanan</th>
                 <th>Aksi</th>
   
    </thead>
    <tbody>
        <tr>
            
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
               
        </tr>
    </tbody>

</table>
            </div>


      <div class="box-body">

        <div class="row">
          <div class="col-md-12">
          <div class="responsive">
            



   
 <div class="box-footer">
          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
               <input type="button" class="btn btn-success" id="addrow" value="Tambah Barang" />
              <button id="konfirmasi" type="submit" class="btn btn-primary ">Simpan</button>
            </div>
          </div>
          </div>
        </div>
          </div>
      </div>
    </form>
  </div>
</section>

              

<script 
  data-main="<?php echo base_url()?>assets/js/main/main-transaksi.js" 
  src="<?php echo base_url()?>assets/js/require.js">
</script>