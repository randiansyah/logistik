<section class="content">
  <div class="box box-bottom">
    <div class="box-header with-border">
    <h3 class="box-title"> Pencarian <?php echo ucwords(str_replace("_"," ",$this->uri->segment(1)))?></h3>
    </div>
    <div class="box-body">
      <div class="row">
       <div class="col-md-12">  
          <div class="form-group row">
            <div class="col-sm-3">
              <label>Provinsi</label>
              <select class="form-control filter-column fkdprop"  id="kdprop" name="kdprop">
                <option value="" selected>Semua Provinsi</option>
                <?php
                  foreach($data_provinsi as $data):
                  echo '<option value="'.$data->kdprop.'">'.$data->nmprop.'</option>';
                  endforeach;
                ?>
              </select>
            </div>

            <div class="col-sm-3">
              <label>Kab / Kota</label>
              <select  class="form-control filter-column fkdkab" id="kdkab" name="kdkab">
                  <option value="" selected>Semua Kab / Kota</option>
              </select>
            </div>

            <div class="col-sm-3">
              <label>Tipe</label>
              <select name="tipe" class="form-control" id="tipe">
                <option value="">Pilih salah satu</option>              
                <option value="A">[A] Head Office</option>              
                <option value="F">[F] Swakelola</option>              
                <option value="G">[G] Gudang</option>              
                <option value="H">[H] Holding</option>              
                <option value="M">[M] Mitra</option>              
                <option value="P">[P] Produksi</option>              
                <option value="S">[S] Stokis</option>              
                <option value="V">[V] Supllier</option>              
              </select>
            </div>

            <div class="col-md-3">  
              <div class="form-group">
                <label>Nama Cabang</label>
                <input type="text" class="form-control" id="nama" name="nama" value="">
              </div>
            </div> 

          </div>
          <div class="form-group row">
            <div class="col-sm-12 text-right"> 
              <a href="#" class="btn btn-sm btn-primary" id="search"><i class="fa fa-search"></i> PENCARIAN</a>              
              <a href="#" class="btn btn-sm btn-danger" id="reset"><i class="fa fa-refresh"></i> RESET</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="box box-default color-palette-box">
    <div class="box-header with-border">
       <div class="full-width datatableButton text-right">
          <a href="<?php echo base_url()?>cabang/create" class="btn btn-sm btn-primary pull-right"><i class='fa fa-plus'></i> DATA BARU</a>
        </div>
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
                <th width="5">No. </th>
                <th>KODE</th> 
                <th>ID</th>                
                <th>PROP</th>
                <th>KOTA/KAB</th> 
                <th>NAMA</th> 
                <th>TIPE</th> 
                <th>STOKIS</th> 
                <th>PRODUKSI</th> 
                <th>GUDANG</th> 
                <th>STATUS</th> 
              </thead>        
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script 
  data-main="<?php echo base_url()?>assets/js/main/main-cabang.js" 
  src="<?php echo base_url()?>assets/js/require.js">  
</script>