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
    <h3 class="box-title"><i class="fa fa-tag"></i> Input Tracking</h3>
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
            <input class="form-control" value="<?php echo $delivery; ?>" id="delivery" name="delivery" autocomplete="off" required readonly>
          </div>
           <div class="form-group">
            <label for="">Kode Delivery</label>
            <input class="form-control" value="<?php echo $id_transaksi; ?>" id="id_transaksi" name="id_transaksi" autocomplete="off" required readonly>
          </div>
          <div class="form-group">  
           
                <label for=""> Pilih Customer</label>
                <select id="pelanggan" name="pelanggan" class="form-control" readonly>
                  <option value="" required>Pilih salah satu</option>
                  <?php
                  foreach ($pelanggan as $key => $val) { ?>
      <option value="<?php echo $val->id;?>"  <?php echo $val->id == $kode_pelanggan ? 'selected' : '' ?>><?php echo $val->nama ?></option>
                  <?php }
                  ?>
                </select>
            
            </div>
           <div class="form-group">
            
           <label for="">Waktu Delivery</label>
      <input class="form-control" value="<?php echo $jadwal_delivery ?>" type="text" id="jadwal_delivery" name="jadwal_delivery">

         
         
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
    <div class="col-md-12">
 

              
                  <label>History Terkini</label>
 <table id="myTable" class=" table order-list">
   <thead>
<th width="20" text-center>No</th>
     <th text-center>Tanggal</th>
     <th text-center>Status Pengiriman</th>
       <th>Keterangan Kota / Tujuan</th>
   </thead>
<tbody>
  <?php $i=1;
if(!empty($tracking)){
   foreach ($tracking as $val) { ?>
    <tr>
   <td><input type="hidden" name="no[]" class="form-control" value="<?php echo $i; ?>"><?php echo $i ?></td> 
      <td><input type="text" name="tanggal[]" class="form-control datetime"   value="<?php echo $val->tanggal ?>">


      </td>

      <td>
       <select  name="status_pengiriman[]" class="form-control">
     <option value="">Pilih Salah Satu</option>

    <option value="Berangkat dari" <?php if($val->status_pengiriman == "Berangkat dari"){ echo 'selected';}else{ '';} ?> >Berangkat dari</option>

     <option value="Tiba di" <?php if($val->status_pengiriman == "Tiba di"){ echo 'selected';}else{ '';} ?> >Tiba di</option>

    <option value="Menuju Alamat" <?php if($val->status_pengiriman == "Menuju Alamat"){ echo 'selected';}else{ '';} ?> >Menuju Alamat</option>

      <option value="Diterima Oleh" <?php if($val->status_pengiriman == "Diterima Oleh"){ echo 'selected';}else{ '';} ?> >Diterima Oleh</option>

                   </select>

      </td>
         <td><input type="text" name="pengiriman[]" class="form-control" value="<?php echo $val->pengiriman?>"></td>

    </tr>
  <?php
  $i++;
}
}
?>

</tbody>
 </table>
  
</div>


         <div class="box-footer">
          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
              <button type="submit" class="btn btn-primary">Edit</button>
                 <a href="<?php echo base_url($this->uri->segment(1))?>" class="btn btn-default"> BATAL</a>
            </div>
          </div>
      </div>
    </form>
  </div>
</section>

              

<script 
  data-main="<?php echo base_url()?>assets/js/main/main-tracking.js" 
  src="<?php echo base_url()?>assets/js/require.js">
</script>