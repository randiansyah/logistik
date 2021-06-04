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
    <h3 class="box-title"><i class="fa fa-plus"></i> Tambah Cabang Baru</h3>
    </div>
     <form method="post" method="post" action="" enctype="multipart/form-data">
        <input type="hidden" id="prop" name="nmprop">
        <input type="hidden" id="kab" name="nmkab">      
        <div class="box-body">
          <div class="row">
            <div class="col-md-6"> 
              <div class="form-group">
                <label for="">Kode Cabang</label>
                <input class="form-control" id="KDCBG" name="kdcbg" autocomplete="off" required style="text-transform: uppercase;">
              </div>          
              <div class="form-group">
                <label for="">Nama Cabang</label>
                <input class="form-control" id="nama" name="nama" autocomplete="off" required>
              </div>
              <div class="form-group row">
                <div class="col-md-6">
                  <label for="">Tipe Cabang</label>
                  <select name="tipe" class="form-control" id="tipe" required>
                    <option value="">Pilih salah satu</option>              
                    <option value="A">[A] Head Office</option>              
                    <option value="F">[F] Swakelola</option>              
                    <option value="G">[G] Gudang</option>              
                    <option value="H">[H] Holding</option>              
                    <option value="M">[M] Mitra</option>              
                    <option value="P">[P] Produksi</option>              
                    <option value="S">[S] Stokis</option>              
                    <option value="V">[V] Supllier</option>              
                  </select>
                </div>
                <div class="col-md-6">
                  <label for="">Stokis Cabang</label>
                  <select name="stokis_cbg" class="form-control" id="stokis">
                    <option value="">Pilih salah satu</option>              
                    <?php
                      if(!empty($stokis)){
                        foreach($stokis as $data):
                        echo '<option value="'.$data->kdcbg.'">'.$data->kdcbg.'</option>';
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
                        echo '<option value="'.$data->kdcbg.'">'.$data->kdcbg.'</option>';
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
                        echo '<option value="'.$data->kdcbg.'">'.$data->kdcbg.'</option>';
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
                  <select class="form-control filter-column fkdprop" id="kdprop" name="kdprop" required>
                    <option value="" selected>Semua Provinsi</option>
                    <?php
                      foreach($data_provinsi as $data):
                      echo '<option value="'.$data->kdprop.'">'.$data->nmprop.'</option>';
                      endforeach;
                    ?>
                  </select> 
                </div>
                <div class="col-md-6">
                  <label>Kab / Kota</label>
                  <select class="form-control filter-column fkdkab" id="kdkab" name="kdkab" required>
                      <option value="" selected>Semua Kab / Kota</option>
                  </select>
                </div>           
              </div>           
              <div class="form-group row">
                <div class="col-md-6">
                  <label for="">Nama Kontak</label>
                  <input class="form-control" id="nama_kontak" name="nama_kontak" autocomplete="off">
                </div>
                <div class="col-md-6">
                  <label for="">Telp Kontak</label>
                  <input class="form-control numeric" id="telp_kontak" name="telp_kontak" autocomplete="off">
                </div>
              </div>
              <div class="form-group">
                <label for="">Alamat</label>
                <textarea class="form-control" name="alamat"></textarea>
              </div>
              <div class="form-group">
                <label class="col-sm-12 control-label row">Status</label>
                <div class="radio" id="status">
                  <label><input type="radio" name="status" value="0" checked>Aktifkan &nbsp;&nbsp;  </label>
                  <label><input type="radio" name="status" value="1">Non-Aktifkan</label>
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


  
