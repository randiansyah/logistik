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
    <h3 class="box-title"><i class="fa fa-tag"></i> Tambah Departemen Baru</h3>
    </div>
     <form id="form" method="post">
    <div class="box-body">
      <div class="row">
        <div class="col-md-12"> 
        <div class="form-group">
          <label for="">Nama Departemen</label>
            <input class="form-control" id="name" name="name" autocomplete="off" required>
          </div>
          <div class="form-group">
            <label for="">Deskripsi</label>
            <textarea class="form-control" id="description" name="description" autocomplete="off"></textarea>
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

              
<script data-main="<?php echo base_url()?>assets/js/main/main-group" src="<?php echo base_url()?>assets/js/require.js"></script>


  
