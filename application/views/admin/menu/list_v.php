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
  <div class="box box-bottom">
    <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-tag"></i> Pencarian <?php echo ucwords(str_replace("_"," ",$this->uri->segment(1)))?></h3>
    </div>
    <div class="box-body">
      <div class="row">
       <div class="col-md-12">  
          <div class="form-group row">
            <div class="col-sm-4">
              <label>Cabang</label>
              <select class="form-control filter-column fkdprop" id="cabang">
                <option value="" selected>Pilih</option>
                <?php
                  foreach($cabang as $data):
                  echo '<option value="'.$data->kdcbg.'">[ '.$data->kdcbg.' ] '.$data->nama_cbg.'</option>';
                  endforeach;
                ?>
              </select>
            </div>

            <div class="col-sm-4">
              <label>Kategori</label>
              <select class="form-control filter-column fkdprop" id="kat">
                <option value="" selected>Pilih</option>
                <?php
                  foreach($kategori as $data):
                  echo '<option value="'.$data->nama_kategori.'">'.$data->nama_kategori.'</option>';
                  endforeach;
                ?>
              </select>
            </div>

            <div class="col-sm-4">
              <label>Nama Menu</label>
              <input type="text" id="nama" class="form-control">
            </div>
          </div>
          <div class="form-group row">
            <div class="col-sm-12 text-right"> 
              <button class="btn btn-sm btn-danger" id="reset">Hapus</button>
              <button class="btn btn-sm btn-primary" id="search">Cari</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="box box-default color-palette-box">
    <div class="box-header with-border">
      <h3 class="box-title"><i class="fa fa-tag"></i> <?php echo ucwords(str_replace("_"," ",$this->uri->segment(1)))?></h3>
      <div class="datatableButton pull-right">
          <a href="<?php echo base_url()?>menu/create" class="btn btn-sm btn-primary"><i class='fa fa-plus'></i> Tambah <?php echo ucwords(str_replace("_"," ",$this->uri->segment(1)))?></a>
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
            <div class="alert alert-info">
            <?php   
               print_r($this->session->flashdata('message_error'));
            ?>
            </div>
            <?php }?> 
            <table class="table table-striped" id="table"> 
              <thead>
                <th width="5">No. </th>
                <th>ID Menu</th>
                <th>Cabang</th>
                <th>Nama Menu</th>
                <th>Label Menu</th>
                <th>Jenis Menu</th>
                <th>Kategori</th>
                <th>Tipe</th>
                <th>Satuan</th>
                <th>Harga (Rp)</th>  
                <th width="60">Action</th> 
              </thead>        
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script 
  data-main="<?php echo base_url()?>assets/js/main/main-menu-resto.js" 
  src="<?php echo base_url()?>assets/js/require.js">  
</script>