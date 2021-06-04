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
    <h3 class="box-title"><i class="fa fa-tag"></i>Pencarian <?php echo ucwords(str_replace("_"," ",$this->uri->segment(1)))?></h3>
    </div>
    <div class="box-body">
      <div class="row">
        <div class="col-md-12">  
        <div class="form-group row">
          <div class="col-sm-4">
              <label>Nama Role</label>
              <input type="text" class="form-control" id="name" name="nama_role" value="">
          </div>
           <div class="col-md-4">
            <label>Web</label>
             <select class="form-control" id="web" name="web">
               <option value="">Pilih Akses</option>
               <option value="1">Ya</option>
               <option value="0">Tidak</option>
             </select>
            </div>
            <div class="col-md-4">
            <label>Apps</label>
             <select class="form-control" id="apps" name="apps">
               <option value="">Pilih Akses</option>
               <option value="1">Ya</option>
               <option value="0">Tidak</option>
             </select>
            </div>
        </div> 
        <div class="form-group row">
          <div class="col-sm-12 text-right"> 
            <a class="btn btn-sm btn-primary" id="search">Search</a>
            <a class="btn btn-sm btn-danger" id="reset">Reset</a>
          </div>
        </div>
        </div>
      </div>
    </div>
  </div>
  <div class="box box-default color-palette-box">
    <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-tag"></i> <?php echo ucwords(str_replace("_"," ",$this->uri->segment(1)))?></h3>
    <div class="col-md-2 datatableButton pull-right">
      <div class="row">
        <a href="<?php echo base_url()?>group/create" class="btn btn-sm btn-primary"><i class='fa fa-plus'></i> <?php echo ucwords(str_replace("_"," ",$this->uri->segment(1)))?></a>
      </div>
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
               <th>No Urut</th>
                <!-- <th>Area</th> -->
                <th>Nama Departemen</th> 
                <th>Keterangan</th> 
                <th>Action</th> 
              </thead>        
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script 
  data-main="<?php echo base_url()?>assets/js/main/main-group" 
  src="<?php echo base_url()?>assets/js/require.js">  
</script>