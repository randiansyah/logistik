<div class="full-width">
  <div class="box mbot-0 full-width">
    <div class="box-header full-width">
      <h2 class="pull-left font-24">Edit Privileges Baru</h2>
    </div>
  </div>
</div>
<div class="full-width padding">
  <div class="padding-top">
    <div class="box">
      <form class="form-horizontal" id="form" method="POST" action="">
      <div class="box-body">
        <?php if(!empty($this->session->flashdata('message_error'))){?>
        <div class="alert alert-danger">
        <?php   
           print_r($this->session->flashdata('message_error'));
        ?>
        </div>
        <?php }?> 
        <div class="form-group row">
          <label class="col-sm-3 form-control-label">Pilih Jabatan</label>
          <div class="col-sm-9">
            <select id="role_id" name="role_id" class="form-control">
                <option value="">Pilih Jabatan</option>
                <?php foreach ($roles as $key => $role) { ?>
                  <option value="<?php echo $role->id ?>" <?php echo $role_id == $role->id ? 'selected' : '' ?>><?php echo $role->name ?></option>
                <?php } ?>
            </select>
          </div>
        </div>
        <div class="box-divider mbot-15"></div>
        <table class="table table-striped">
                <thead>
                  <th style="width:70px"> <label class="mar-0 control control--checkbox"><input type="checkbox" id="checkAll"><div class="control__indicator" style="top:-13px;"></div></label ></th>
                  <th>Menu</th>
                  <th>Fungsi</th>
                </thead>
                <?php  

                function isMenuSelected($menu_selecteds,$menu_id){
                  foreach ($menu_selecteds as $key => $value) {
                    if($menu_id == $value['menu_id'] && count($value['functions']) >= 5){
                      return true;
                    }
                  }
                  return false;
                };  
                function isMenuFunctionSelected($menu_selecteds,$menu_id,$function_id){ 
                  foreach ($menu_selecteds as $key => $menus) {
                    if($menu_id == $menus['menu_id']){ 
                      foreach ($menus['functions'] as $key => $function) {  
                        if($function_id == $function['id']){
                          return true;
                        } 
                      }
                    }
                  }
                  return false;
                }; 

                 
                foreach($menus as $key => $data_menu){?>
                  <tr>
                    <td class="valign-mid"> 
                      <label class="mar-0 control control--checkbox"> 
                        <input type="checkbox" class="cb-element" name="menus[]" 
                        value="<?php echo $data_menu['id'];?>" 
                        <?php echo (isMenuSelected($menu_selecteds,$data_menu['id'])?"checked":"")?>><div class="control__indicator" style="top:4px;"></div>
                      </label  > 
                    </td class="valign-mid">
                    <td> <span class="valign-mid"><?php echo $data_menu['name'];?></span>
                      <div class="btn-group dropdown pull-right padright-15 borright-soft-grey">
                      <button class="btn white dropdown-toggle btn-sm hide-caret" data-toggle="dropdown">Pilih Fungsi</button>
                      <div class="pad-10 dropdown-menu dropdown-menu-form dropdown-menu-scale pull-right">
                        <?php    
                          foreach($data_menu['functions'] as $function){   
                            ?> 
                             <label class="col-12 control control--checkbox">
                              <span class="pull-left fsize-14 padleft-10"><?php echo $function['name']?> </span>
                              <input type="checkbox" class="cb-element-child" 
                              name="functions[<?php echo $data_menu['id'];?>][]" 
                              value="<?php echo $function['id']?>"
                              <?php echo (isMenuFunctionSelected($menu_selecteds,$data_menu['id'],$function['id'])?"checked":"")?>>
                              <div class="control__indicator no-bg-right"></div>
                            </label> 
                          <?php  }?>
                          </div>
                        </div>
                        </td>
                        <td class="valign-mid">
                       <?php    
                          foreach($data_menu['functions'] as $function){   
                              
                            if(
                              (isMenuFunctionSelected($menu_selecteds,$data_menu['id'],$function['id']))
                            ){
                        ?>
                          <span class="label fsize-14 w-normal marright-5 text-black">
                              <?php echo $function['name']?>
                            </span>
                          <?php }?> 
                      <?php  }?>   
                    </td>
                  </tr>
                <?php }?>
              </table>
      </div>
      <div class="box-footer pad-15 full-width bg-softgrey border-top bot-rounded">
        <button type="submit" class="btn btn-primary pull-right mleft-15" id="save-btn">Simpan</button>
        <a href="<?php echo base_url('privileges');?>" class="btn btn-default pull-right">Batal</a>
      </div>
      </form>
    </div>
  </div>
</div>
 <script data-main="<?php echo base_url()?>assets/js/main/main-privilleges" src="<?php echo base_url()?>assets/js/require.js"></script>