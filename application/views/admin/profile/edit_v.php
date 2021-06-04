
<section class="content">

  <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div role="tabpanel">
  <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
              <li role="presentation" class="active">
                <a href="#home" aria-controls="home" role="tab" data-toggle="tab">Ganti Password</a>
              </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane active" id="home">
                <input type="hidden" id="user_id" value="">
                <form class="form-horizontal" id="form" method="POST" action="">
                  <div class="box-body">
                    <?php if(!empty($this->session->flashdata('message_error'))){?>
                    <div class="alert alert-danger">
                    <?php   
                       print_r($this->session->flashdata('message_error'));
                    ?>
                    </div>
                    <?php }?> 
                    <?php if(!empty($this->session->flashdata('message'))){?>
                    <div class="alert alert-success">
                    <?php   
                       print_r($this->session->flashdata('message'));
                    ?>
                    </div>
                    <?php }?> 
                    <input type="hidden" name="id" value="<?php echo $id;?>">
                
              
                    <div class="form-group row">
                      <label for="inputEmail3" class="col-sm-3 control-label">Password Lama</label> 
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="old_password"  name="old_password" value="<?php echo $real_password;?>">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="inputEmail3" class="col-sm-3 control-label">Password Baru</label> 
                      <div class="col-sm-7">
                        <input type="password" class="form-control" id="new_password" name="new_password">
                      </div>
                       <div class="col-sm-2">
            <div class="checkbox">
                  <label>
                    <input type="checkbox" name="cekpas" id="cekpas"> Lihat Password
                  </label>
                </div>
            </div>
                    </div>
                    <div class="form-group row">
                      <label for="inputPassword3" class="col-sm-3 control-label">Konfirmasi Password Baru</label> 
                      <div class="col-sm-9">
                      <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                      </div>
                    </div>  
                  </div> 
                  <div class="box-footer">
                      <div class="col-sm-12 text-right">
                        <a href="<?php echo base_url();?>dashboard" class="btn btn-sm btn-default ">Batal</a>
                        <button type="submit" class="btn btn-sm btn-info" name="profil_pengguna" value="1" id="save-btn">Simpan</button>
                      </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>  
      </div>
    </div>
</section>
 <script data-main="<?php echo base_url()?>assets/js/main/main-profile.js" src="<?php echo base_url()?>assets/js/require.js"></script>
