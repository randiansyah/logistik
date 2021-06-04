<section class="content-header">
  <h1>
    <?php echo ucwords(str_replace("_"," ",$this->uri->segment(1)))?>
    <small></small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active"><?php echo ucwords(str_replace("_"," ",$this->uri->segment(1)))?></li>
  </ol>
</section>
<section class="content">
  <div class="col-md-12">
 <div class="box box-bottom">
    <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-tag"></i> Pencarian <?php echo ucwords(str_replace("_"," ",$this->uri->segment(1)))?></h3>
    </div>
    <div class="box-body">
      <div class="row">
       <div class="col-md-12">  
          <div class="form-group row">
            <div class="col-sm-3">
              <label>NAMA</label>
              <select class="form-control" id="nama_cs" name="nama_cs" >
                <option value="" selected>Nama Customer</option>
                <?php
                  foreach($pelanggan as $data):
                  echo '<option value="'.$data->id.'">'.$data->nama.'</option>';
                  endforeach;
                ?>
              </select>
            </div>
   <div class="col-sm-3">
            <label for="">JENIS PEMBAYARAN</label>
            <select value="" class="form-control select2" id="jenis_pembayaran" name="jenis_pembayaran"   >
                  <option value="" selected>Pilih salah satu</option>              
                  <option value="Cash">Cash</option>   
                  <option value="Kredit">Kredit</option> 
               
                </select>
          </div>
         
  <div class="col-sm-3">
             <label for="">JALUR PENGIRIMAN</label>
             <select class="form-control select2" id="kirim_via" name="kirim_via" value="">
                  <option value="" selected>Pilih salah satu</option>              
                  <option value="Darat">[Darat] Pengiriman Via Darat</option>   
                  <option value="Laut">[Laut] Pengriman Via Laut</option> 
                  <option value="Udara">[Udara] Pengiriman Via Udara</option>
                 
                </select>
            </div>
   <div class="col-sm-3">
              <label>ID TRANSAKSI</label>
         <input type="text" name="kode_delivery" id="kode_delivery" class="form-control" value="">
            </div>

                <div class="col-sm-3">
                  <label for=""><br>Asal Pengiriman</label> 
                  <select class="form-control filter-column fkdprop" id="kdprop" name="kdprop" value="">
                    <option value="" selected>Semua Provinsi</option>
                    <?php
                      foreach($data_provinsi as $data):
                      echo '<option value="'.$data->kdprop.'">'.$data->nmprop.'</option>';
                      endforeach;
                    ?>
                  </select> 
                </div>
                <div class="col-sm-3">
                  <label><br>-</label>
                  <select class="form-control filter-column fkdkab" id="kdkab" name="kdkab" value="">
                      <option value="" selected>Semua Kab / Kota</option>
                  </select>
                </div>           
   
             
                <div class="col-sm-3">
                  <label for=""><br>Tujuan Pengiriman</label> 
                  <select class="form-control filter-column fkdprop" id="kdprop_tujuan" name="kdprop_tujuan" value="">
                    <option value="" selected>Semua Provinsi</option>
                    <?php
                      foreach($data_provinsi as $data):
                      echo '<option value="'.$data->kdprop.'">'.$data->nmprop.'</option>';
                      endforeach;
                    ?>
                  </select> 
                </div>
                <div class="col-sm-3">
                  <label><br>-</label>
                  <select class="form-control filter-column fkdkab" id="kdkab_tujuan" name="kdkab_tujuan" value="">
                      <option value="" selected>Semua Kab / Kota</option>
                  </select>
                </div>           
        
          
          
         
          </div>
          <div class="form-group row">
            <div class="col-sm-12 text-right"> 
              <a href="#" class="btn btn-md btn-danger" id="reset">Reset</a>
              <a href="#" class="btn btn-md btn-primary" id="search">Cari</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</section>
<section class="content">
  <div class="box box-default color-palette-box">
    <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-tag"></i> <?php echo ucwords(str_replace("_"," ",$this->uri->segment(1)))?></h3>
    
    </div>
    <div class="box-body">
    <div class="box-header">
      
    </div>
      <div class="row">
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
              <th>#</th>
               <th width="15%">ID Transaksi</th> 
                <th>Nama</th> 
                 <th>Telp</th> 
                  <th>Pengiriman Via</th> 
            <th>Asal</th> 
            <th>Tujuan</th> 
             <th>posting</th> 
             <th>status</th>
            
                 
              </thead>        
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script 
  data-main="<?php echo base_url()?>assets/js/main/main-transaksi" 
  src="<?php echo base_url()?>assets/js/require.js">  
</script>