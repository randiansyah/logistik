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
              <label>Jabatan</label>
              <select id="role" name="role" class="form-control">
                <option value="">Pilih Jabatan</option>
                <?php
                foreach ($roles as $key => $role) { ?>
                  <option value="<?php echo $role->name;?>"><?php echo $role->name;?></option>
                <?php }
                ?>
              </select>
            </div>

            <div class="col-sm-4">
              <label>Nama</label>
              <input type="text" class="form-control" id="first_name" placeholder="Nama" name="first_name">
            </div>


          <div class="col-sm-4">
            <label>Status</label>
            <select class="form-control filter-column" id="status" name="status">
              <option value="" selected>Status</option>
              <option value="1">Non Aktif</option>
              <option value="0">Aktif</option>
            </select>

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
       <div class="full-width datatableButton text-right">
          <a href="<?php echo base_url()?>user/create" class="btn btn-sm btn-primary pull-right"><i class='fa fa-plus'></i> Tambah Pengguna</a>
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
                <th width="5">No. </th> 
                <th>Jabatan</th> 
                <th>Nama</th>
                <th>Email</th>  
              <th>Aksi</th> 
              </thead>        
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script 
  data-main="<?php echo base_url()?>assets/js/main/main-user" 
  src="<?php echo base_url()?>assets/js/require.js">  
</script>