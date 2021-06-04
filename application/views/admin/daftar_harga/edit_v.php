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
    <h3 class="box-title"><i class="fa fa-tag"></i> Edit</h3>
    </div>
     <form id="karyawan" method="post"  enctype="multipart/form-data">
             
     <input type="hidden" id="kdprop_tujuan_selected" value="<?php echo $KDPROP_tujuan?>">
        <input type="hidden" id="kdkab_tujuan_selected" value="<?php echo $KDKAB_tujuan?>">  
    <div class="box-body">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
         <label for="">ID</label>
         <input type="text" class="form-control" name="id_daftar" id="id_daftar" value="<?php echo $nomor ?>" readonly>
          </div>
          <div class="form-group"> 
         
             <div class="form-group">
            <label for="">Pengiriman Via</label>
             <select class="form-control select2" id="kirim_via" name="kirim_via"  required >
                <option>Pilih salah satu</option>              
                  <option value="Darat" <?php if($kirim_via == 'Darat'){echo "selected";} ?>>[Darat] Pengiriman Via Darat</option>   
                  <option value="Laut" <?php if($kirim_via == 'Laut'){echo "selected";} ?>>[Laut] Pengriman Via Laut</option> 
                  <option value="Udara" <?php if($kirim_via == 'Udara'){echo "selected";} ?>>[Udara] Pengiriman Via Udara</option>
                 
                </select>
          </div>
        </div>
      </div>
      <div class="col-md-6"> <!--
   <div class="form-group row">
      
                <div class="col-md-6">
                  <label for="">Asal Pengiriman</label> 
                  <select class="form-control filter-column fkdprop" id="kdprop" name="kdprop" required>
                    <option value="" selected>Semua Provinsi</option>
                    <?php
                    //  foreach($data_provinsi as $data):
                    //  echo '<option value="'.$data->kdprop.'">'.$data->nmprop.'</option>';
                    //  endforeach;
                    ?>
                  </select> 
                </div>
              
                <div class="col-md-6">
                  <label>-</label>
                  <select class="form-control filter-column fkdkab" id="kdkab" name="kdkab" required>
                      <option value="" selected>Semua Kab / Kota</option>
                  </select>
                </div> 

              </div> -->  
               <div class="form-group row">
                <div class="col-md-6">
                  <label for="">Tujuan Pengiriman</label> 
                  <select class="form-control filter-column fkdprop" id="kdprop_tujuan" name="kdprop_tujuan" required>
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
                  <select class="form-control filter-column fkdkab" id="kdkab_tujuan" name="kdkab_tujuan" required>
                      <option value="" selected>Semua Kab / Kota</option>
                  </select>
                </div>           
              </div> 
              <!--
<div class="form-group row">
  <div class="col-md-6">
  </div>

  <div class="col-md-6">
    <label>Keterangan Kota</label>
<input type="text" class="form-control" name="tujuan" id="tujuan">
</div>       
</div>
      -->

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

     <div class="box-body table-responsive no-padding">
 <table id="" class="table table-hover">
    <thead>
        <th width="50">No</th>
              <th>kg</th>
              <th>Min</th>
              <th>Coli A [1-10 KG]</th>
              <th>Coli B [10-20 KG]</th>
              <th>Coli C [20-30 KG]</th>
              <th>Lead Time</th>
              <th>Keterangan</th>

   
    </thead>
    <tbody>
      <?php  $i=1; foreach ($daftar_harga as $val) {?>
        <tr>
<td class="text-center">
  <input type="text" name="no[]" class="form-control" value="<?php echo $i ?>" readonly>
</td>
<td class="text-center">
  <input type="text" name="kg[]" class="form-control" value="<?php echo $val->kg ?>" >
</td>
<td class="text-center">
  <input type="text" name="min[]" class="form-control" value="<?php echo $val->min ?>" >
</td>
<td class="text-center">
  <input type="text" name="coliA[]" class="form-control harga" value="<?php echo 'Rp. '.number_format($val->coli_a,0,'.','.') ?>" >
</td>
<td class="text-center">
  <input type="text" name="coliB[]" class="form-control harga" value="<?php echo 'Rp. '.number_format($val->coli_b,0,'.','.') ?>" >
</td>
<td class="text-center">
  <input type="text" name="coliC[]" class="form-control harga" value="<?php echo 'Rp. '.number_format($val->coli_c,0,'.','.') ?>" >
</td>
<td class="text-center">
  <input type="text" name="leadtime[]" class="form-control" value="<?php echo $val->lead_time ?>" >
</td>
<td class="text-center">
  <input type="text" name="ket[]" class="form-control" value="<?php echo $val->keterangan ?>" >
</td>

              
               
        </tr>

        <?php 
      }
      ?>
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
              
              <button type="submit" class="btn btn-primary ">Update</button>
                 <a href="<?php echo base_url($this->uri->segment(1))?>" class="btn btn-default"> BATAL</a>

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
  data-main="<?php echo base_url()?>assets/js/main/main-daftar-harga.js" 
  src="<?php echo base_url()?>assets/js/require.js">
</script>