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
  <?php if($this->data['is_can_search']){ ?>
  <div class="box box-bottom">
    <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-tag"></i> Pencarian <?php echo ucwords(str_replace("_"," ",$this->uri->segment(1)))?></h3>
    </div>
    <div class="box-body">
      <div class="row">
       <div class="col-md-12">  
          <div class="form-group row">
            <div class="col-sm-3">
              <label>Provinsi</label>
              <select class="form-control filter-column fkdprop" id="kdprop" name="kdprop">
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
              <label>Kecamatan</label>
              <select   class="form-control filter-column fkdkec" id="kdkec" name="kdkec">
                <option value="" selected>Semua Kecamatan</option>
              </select>
            </div>

            <div class="col-sm-3">
              <label>Kelurahan</label>
              <select   class="form-control filter-column fkddesa" id="kddesa" name="kddesa">
                <option value="" selected>Semua Kelurahan</option>
              </select>
              <input type="hidden" value="" id="getKddesa">
            </div>
          </div>
          <div class="col-md-6">
<input type="text" id="tes_cari" name="tes_cari" class="form-control">
          </div>
          <div class="form-group row">
            <div class="col-sm-12 text-right"> 
              <a href="#" class="btn btn-sm btn-danger" id="reset">Hapus</a>
              <a href="#" class="btn btn-sm btn-primary" id="search">Cari</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
   <?php 
}
?>
  <div class="box box-default color-palette-box">
    <div class="box-header with-border"> 
       <div class="full-width datatableButton pull-right text-right">
             <?php if($this->data['is_can_create']){?>
          <a href="<?php echo base_url('wilayah/exportCSV')?>" class="btn btn-sm btn-warning"><i class="fa fa-download"></i> Export CSV</a>
          <?php 
}
?>
        </div>
    </div>
    <div class="box-body">
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
            <div class="alert alert-danger">
            <?php   
               print_r($this->session->flashdata('message_error'));
            ?>
            </div>
            <?php }?> 
            <table class="table table-striped display nowrap" id="table"> 
              <thead>
                <th>KDWILAYAH</th> 
                <th>KDPROP</th> 
                <th>KDKAB</th>
                <th>KDKEC</th> 
                <th>KDDESA</th> 
                <th>Provinsi</th> 
                <th>Kabupaten</th> 
                <th>Kecamatan</th> 
                <th>Desa</th>  
              </thead>        
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script 
  data-main="<?php echo base_url()?>assets/js/main/main-wilayah" 
  src="<?php echo base_url()?>assets/js/require.js">  
</script>