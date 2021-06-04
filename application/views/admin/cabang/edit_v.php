<?php if(!empty($this->session->flashdata('message_error'))){?>
<div class="alert alert-danger">
<?php   
   print_r($this->session->flashdata('message_error'));
?>
</div>
<?php } ?> 
<section class="content">
  <div class="box box-default color-palette-box">
    <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-plus"></i> Edit Cabang <?php echo $nama; ?></h3>
    </div>
     <form method="post" method="post" action="" enctype="multipart/form-data">
        <input type="hidden" id="kdprop_selected" value="<?php echo $KDPROP?>">
        <input type="hidden" id="kdkab_selected" value="<?php echo $KDKAB?>">      
        <div class="box-body">
          <div class="row">
            <div class="col-md-6"> 
              <div class="form-group">
                <label for="">Kode Cabang</label>
                <input class="form-control" id="KDCBG" value="<?php echo $kdcbg ?>" autocomplete="off" required style="text-transform: uppercase;" disabled>
              </div>          
              <div class="form-group">
                <label for="">Nama Cabang</label>
                <input class="form-control" id="nama" name="nama" value="<?php echo $nama ?>" autocomplete="off" required>
              </div>
              <div class="form-group row">
                <div class="col-md-6">
                  <label for="">Tipe Cabang</label>
                  <select name="tipe" class="form-control" id="tipe">
                    <option value="">Pilih salah satu</option>              
                    <option value="A" <?php echo ($tipe == 'A'? 'selected':'')?>>[A] Head Office</option>              
                    <option value="F" <?php echo ($tipe == 'F'? 'selected':'')?>>[F] Swakelola</option>              
                    <option value="G" <?php echo ($tipe == 'G'? 'selected':'')?>>[G] Gudang</option>              
                    <option value="H" <?php echo ($tipe == 'H'? 'selected':'')?>>[H] Holding</option>              
                    <option value="M" <?php echo ($tipe == 'M'? 'selected':'')?>>[M] Mitra</option>              
                    <option value="P" <?php echo ($tipe == 'P'? 'selected':'')?>>[P] Produksi</option>              
                    <option value="S" <?php echo ($tipe == 'S'? 'selected':'')?>>[S] Stokis</option>              
                    <option value="V" <?php echo ($tipe == 'V'? 'selected':'')?>>[V] Supllier</option>              
                  </select>
                </div>
                <div class="col-md-6">
                  <label for="">Stokis Cabang</label>
                  <select name="stokis_cbg" class="form-control" id="stokis">
                    <option value="">Pilih salah satu</option>              
                    <?php
                      if(!empty($stokis)){
                        foreach($stokis as $data):
                        if($stokis_cbg == $data->kdcbg){
                          echo '<option value="'.$data->kdcbg.'" selected>'.$data->kdcbg.'</option>';
                        }else{
                          echo '<option value="'.$data->kdcbg.'">'.$data->kdcbg.'</option>';
                        }
                        endforeach;
                      }
                    ?>              
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-md-6">
                  <label for="">Produksi Cabang</label>
                  <select name="produksi_cbg" class="form-control" id="produksi">
                    <option value="">Pilih salah satu</option>              
                    <?php
                      if(!empty($produksi)){
                        foreach($produksi as $data):
                        if($produksi_cbg == $data->kdcbg){
                          echo '<option value="'.$data->kdcbg.'" selected>'.$data->kdcbg.'</option>';
                        }else{
                          echo '<option value="'.$data->kdcbg.'">'.$data->kdcbg.'</option>';
                        }
                        endforeach;
                      }
                    ?>              
                  </select>
                </div>
                <div class="col-md-6">
                  <label for="">Gudang Pusat</label>
                  <select name="gudang_pusat" class="form-control" id="gudang">
                    <option value="">Pilih salah satu</option>              
                    <?php
                      if(!empty($gudang)){
                        foreach($gudang as $data):
                        if($gudang_pusat == $data->kdcbg){
                          echo '<option value="'.$data->kdcbg.'" selected>'.$data->kdcbg.'</option>';
                        }else{
                          echo '<option value="'.$data->kdcbg.'">'.$data->kdcbg.'</option>';
                        }
                        endforeach;
                      }
                    ?>               
                  </select>
                </div>                                       
              </div>                                       
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-md-6">
                  <label for="">Provinsi</label> 
                  <select class="form-control filter-column fkdprop" id="kdprop" name="kdprop">
                    <option value="" selected>Semua Provinsi</option>
                    <?php
                      foreach($data_provinsi as $data):
                        if($KDPROP == $data->kdprop){
                          echo '<option value="'.$data->kdprop.'" selected>'.$data->nmprop.'</option>';
                        }else{
                          echo '<option value="'.$data->kdprop.'">'.$data->nmprop.'</option>';
                        }
                      endforeach;
                    ?>
                  </select> 
                </div>
                <div class="col-md-6">
                  <label>Kab / Kota</label>
                  <select class="form-control filter-column fkdkab" id="kdkab" name="kdkab">
                      <option value="" selected>Semua Kab / Kota</option>
                  </select>
                </div>           
              </div>           
              <div class="form-group row">
                <div class="col-md-6">
                  <label for="">Nama Kontak</label>
                  <input class="form-control" id="nama_kontak" name="nama_kontak" value="<?php echo $nama_kontak?>" autocomplete="off">
                </div>
                <div class="col-md-6">
                  <label for="">Telp Kontak</label>
                  <input class="form-control numeric" id="telp_kontak" name="telp_kontak" value="<?php echo $telp_kontak?>" autocomplete="off">
                </div>
              </div>
              <div class="form-group">
                <label for="">Alamat</label>
                <textarea class="form-control" name="alamat"><?php echo $alamat?></textarea>
              </div>
              <div class="form-group">
                <label class="col-sm-12 control-label row">Status</label>
                <div class="radio" id="status">
                  <label><input type="radio" name="status" value="0" <?php echo ($status == '0'? 'checked':'')?>>Aktifkan &nbsp;&nbsp;  </label>
                  <label><input type="radio" name="status" value="1" <?php echo ($status == '1'? 'checked':'')?>>Non-Aktifkan</label>
                </div>
              </div>                     
            </div>
          </div>
        </div>
         <div class="box-footer">
          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
              <button type="submit" class="btn btn-primary">SIMPAN</button>
              <a href="<?php echo base_url($this->uri->segment(1))?>" class="btn btn-default"> BATAL</a>
            </div>
          </div>
      </div>
    </form>
  </div>
</section>
              
<script data-main="<?php echo base_url()?>assets/js/main/main-cabang" 
src="<?php echo base_url()?>assets/js/require.js"></script>


  
