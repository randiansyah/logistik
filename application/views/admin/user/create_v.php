<section class="content">
<div class="full-width padding">
  <div class="box box-default color-palette-box">
    <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-tag"></i> Tambah Pengguna Baru</h3>
    </div>
      <form class="form-horizontal" id="form" method="POST" action="" enctype="multipart/form-data">
      <input type="hidden" name="id" id="id" value="">
        <div class="box-body">
          <?php if(!empty($this->session->flashdata('message_error'))){?>
          <div class="alert alert-danger">
          <?php   
             print_r($this->session->flashdata('message_error'));
          ?>
          </div>
          <?php }?>  
           <div class="form-group row">
            <label for="inputEmail3" class="col-sm-3 control-label">Nama</label> 
            <div class="col-sm-9">
              <input type="name" class="form-control" id="first_name" placeholder="Nama" name="first_name">
            </div>
          </div> 
          <!-- <div class="form-group row">
            <label for="inputEmail3" class="col-sm-3 control-label">Photo</label> 
              <div class="col-sm-9">
                <input type="file" class="form-control" id="photo" placeholder="Photo" name="photo">
              </div> 
            </div> -->
         
          <div class="form-group row">
            <label for="inputPassword3" class="col-sm-3 control-label">Email</label> 
            <div class="col-sm-9">
             <input type="email" class="form-control" id="email" placeholder="Email" name="email">
            </div>
          </div> 

          <hr> 
          <div class="form-group row">
            <label for="inputPassword3" class="col-sm-3 control-label">Role</label> 
            <div class="col-sm-9">
               <select id="role_id" name="role_id" class="form-control">
                <option value="">Pilih Role</option>
                <?php
                foreach ($roles as $key => $role) { ?>
                  <option value="<?php echo $role->id;?>"><?php echo $role->name;?></option>
                <?php }
                ?>
              </select>
            </div>
          </div>  
         
          <div class="form-group row">
            <label for="inputPassword3" class="col-sm-3 control-label">Username</label> 
            <div class="col-sm-9">
             <input type="name" class="form-control" id="username" placeholder="Username" name="username">
            </div>
          </div>  
          <div class="form-group row">
            <label for="inputPassword3" class="col-sm-3 control-label">Password</label> 
            <div class="col-sm-9">
             <input type="password" class="form-control" id="password"  name="password">
            </div>
          </div>  
          <div class="form-group row">
            <label for="inputPassword3" class="col-sm-3 control-label">Ulangi Password</label> 
            <div class="col-sm-9">
             <input type="password" class="form-control" id="password_confirm" name="password_confirm">
            </div>
          </div>   
        </div> 
        <div class="box-footer pad-15 full-width bg-softgrey border-top bot-rounded text-right">
          <button type="submit" class="btn btn-primary mleft-15" id="save-btn">Simpan</button>
          <a href="<?php echo base_url();?>user" class="btn btn-default">Batal</a>
        </div>
      </form>
    </div>  
</section>
 
<script data-main="<?php echo base_url()?>assets/js/main/main-user" src="<?php echo base_url()?>assets/js/require.js"></script>