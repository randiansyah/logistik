<section class="content">
  <div class="full-width padding">
  <div class="padding-top">
    <div class="row"> 
      <div class="col-md-12"> 
        <div class="box box-primary">
          <form class="form-horizontal" id="form" method="POST" action="" enctype="multipart/form-data">
          <input type="hidden" name="id" id="id" value="<?php echo $id?>">
            <div class="box-body">
              <?php if(!empty($this->session->flashdata('message_error'))){?>
                <div class="alert alert-danger">
                <?php   
                   print_r($this->session->flashdata('message_error'));
                ?>
                </div>
                <?php }?> 
                <input type="hidden" name="id" id="user_id" value="<?php echo $id;?>"> 
                <input type="hidden" id="role_id_selected" value="<?php echo $role_id;?>">
                   <input type="hidden" id="username" name="username" value="<?php echo $username;?>">  
                <?php if(!empty($foto)){?>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label"></label> 
                  <div class="col-sm-9">
                   <img width="100px" src="<?php echo base_url()."assets/images/foto/".$foto;?>">
                  </div>
                </div>
                <?php }?>
                  <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Name</label> 
                  <div class="col-sm-9">
                    <input type="name" class="form-control" id="name" placeholder="Name" name="name" value="<?php echo $username?>">
                  </div>
                </div>
              
              
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-3 control-label">Email</label> 
                  <div class="col-sm-9">
                   <input type="email" class="form-control" id="email" placeholder="Email" name="email" value="<?php echo $email;?>">
                  </div>
                </div> 
                   <div class="form-group">
                      <label for="inputEmail3" class="col-sm-3 control-label">Password Lama</label> 
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="old_password"  name="old_password" value="<?php echo $real_password;?>" readonly>
                      </div>
                    </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-3 control-label">Password Baru</label> 
                  <div class="col-sm-9">
                   <input type="text" class="form-control" id="new_password" placeholder="" name="new_password">
                  </div>
                </div> 
              
              <div class="form-group">
                <label for="inputPassword3" class="col-sm-3 control-label">Role</label> 
                <div class="col-sm-9">
                   <select id="role_id" name="role_id" class="form-control">
                    <option value="">Pilih Role</option>
                    <?php
                    foreach ($roles as $key => $role) { ?>
                      <option value="<?php echo $role->id;?>" <?php echo $role->id == $role_id ? 'selected' : '' ?>><?php echo $role->name;?></option>
                    <?php }
                    ?>
                  </select>
                </div>
              </div>   

              
            </div> 
            <div class="box-footer pad-15 full-width bg-softgrey border-top bot-rounded">
              <button type="submit" class="btn btn-primary pull-right mleft-15" id="save-btn">Update</button>
              <a href="<?php echo base_url();?>user" class="btn btn-default pull-right">Batal</a>
            </div>
          </form>
        </div>  
      </div> 
    </div>
  </div>
</div>
</section>

 <script data-main="<?php echo base_url()?>assets/js/main/main-user" src="<?php echo base_url()?>assets/js/require.js"></script>