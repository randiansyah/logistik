
<form id="form" method="POST" class="form-horizontal" action="">
<input type="hidden" name="role_id" value="<?php echo $id?>">
  <section class="content">
  <div class="box box-default color-palette-box">
    <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-tag"></i> <?php echo ucwords(str_replace("_"," ",$role_name));?></h3>
    </div>
    <div class="box-body">
      <div role="tabpanel">
  <!-- Nav tabs -->

  <!-- Tab panes -->
        <div class="tab-content">
          <div role="tabpanel" class="tab-pane active" id="home">
            <table id="tabweb" class="table table-striped">
                <thead>
                  <th style="width:70px"> <label class="mar-0 control control--checkbox"><input type="checkbox" id="checkAll"><div class="control__indicator" style="top:-15px;"></div></label ></th>
                  <th>Menu</th>
                  <th>Fungsi</th>
                </thead>
                <?php  
                
                function isMenuSelected($menu_selecteds,$menu_id){
                  foreach ($menu_selecteds as $key => $value) {
                    if($menu_id == $value['menu_id'] && count($value['functions']) >= 100){
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
                        <?php echo (isMenuSelected($menu_selecteds,$data_menu['id'])?"checked":"")?>><div class="control__indicator" style="top:-8px;"></div>
                      </label  > 
                    </td class="valign-mid">
                    <td> <span class="valign-mid"><?php echo $data_menu['name'];?></span>
                      <div class="btn-group dropdown pull-right padright-15 borright-soft-grey">
                      <button class="btn white dropdown-toggle btn-sm hide-caret" data-toggle="dropdown">Pilih Fungsi</button>
                      <div class="dropdown-menu dropdown-menu-form dropdown-menu-scale pull-right">
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
          <div role="tabpanel" class="tab-pane" id="tab">
            <table id="tabapps" class="table table-striped table-hover">
              <thead>
                <tr>
                  <th><input type="checkbox" class="select-cb"></th>
                  <th>Access</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if(!empty(($feature[0]))){
                  foreach($feature as $key =>$value){
                    ?>
                    <tr>
                      <td width="10">
                          <input id="<?php echo $value->ID?>" class="cb-apps" <?php echo in_array($value->ID,$list_feature) ? 'checked' : '';?> type="checkbox" name="aplikasi[]" value="<?php echo $value->ID?>">
                      </td>
                      <td>
                        <label for="<?php echo $value->ID?>">Pilih <?php echo $value->DESCRIPTION;?></label>
                      </td>
                    </tr>
                    <?php
                   }
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
     <div class="box-footer">  
      <div class="form-group row m-t-md">
        <div class="col-sm-12 text-right">
          <button type="submit" class="btn btn-sm btn-info uppercase" id="save-btn">Simpan</button>
          <a href="<?php echo base_url();?>privileges" class="btn btn-sm btn-danger uppercase">Batal</a>
        </div>
      </div>
    </div>
  </div>
</div>

</section>
</form>
 <script data-main="<?php echo base_url()?>assets/js/main/main-privilleges" src="<?php echo base_url()?>assets/js/require.js"></script>
