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
    <h3 class="box-title"><i class="fa fa-tag"></i> Tambah Vendor</h3>
    </div>
     <form id="karyawan" method="post" enctype="multipart/form-data">
    <div class="box-body">
      <div class="row">
        <div class="col-md-4">
          <div class="form-group"> 
  
           <div class="form-group">
            <label for="">Kode Vendor</label>
            <input class="form-control" value="<?php echo $k_vendor ?>" id="k_vendor" name="k_vendor" autocomplete="off" required>
          </div>  
           <div class="form-group">
            <label for="">Nama</label>
            <input class="form-control" value="<?php echo $nama ?>" id="nama" name="nama" autocomplete="off" required>
          </div>  
           <div class="form-group">
            <label for="">No HP</label>
            <input class="form-control" value="<?php echo $no_hp ?>" id="no_hp" name="no_hp" autocomplete="off" required>
          </div> 
           <div class="form-group">
            <label for="">No KTP</label>
            <input class="form-control" value="<?php echo $KTP ?>"id="KTP" name="KTP" autocomplete="off" required>
          </div>
 
          
              <div class="form-group">
            <label for="">Alamat sesuai KTP</label>
 <textarea cols="3" rows="4" value="<?php echo $alamat ?>"  class="form-control" id="alamat" name="alamat" required><?php echo $alamat ?></textarea>
                    
          </div> 
          
        </div>
      </div>
      <div class="col-md-4">
    <div class="form-group">
            <label for="">Tempat Lahir</label>
            <input class="form-control" value="<?php echo $tempat_lahir ?>" id="tempat_lahir" name="tempat_lahir" autocomplete="off" required>
          </div>
           <div class="form-group">
            <label for="">Tanggal Lahir</label>
            <input class="form-control datepicker" value="<?php echo $tgl_lahir ?>" id="tgl_lahir" autocomplete="off" name="tgl_lahir" autocomplete="off" required>
          </div>
            <div class="form-group">
            <label for="">Agama</label>
             <select name="agama" class="form-control" id="agama" required>
<option value="Islam" <?php if('Islam'==$agama) { echo "selected"; } ?>>Islam</option>   
<option value="Kristen" <?php if('Kristen'==$agama) { echo "selected"; } ?>>Kristen</option>  
<option value="Hindu" <?php if('Hindu'==$agama) { echo "selected"; } ?>>Hindu</option>
<option value="Buddha" <?php if('Buddha'==$agama) { echo "selected"; } ?>>Buddha</option> 
<option value="Katholik" <?php if('Katholik'==$agama) { echo "selected"; } ?>>Katholik</option>
                </select>
          </div>
         <div class="form-group">
            <label for="">Jenis Kelamin</label>
           <select name="jenis_kelamin" class="form-control" id="jenis_kelamin" required>
                  <option>Pilih salah satu</option>  
<option value="Laki-laki" <?php if('Laki-laki'==$jenis_kelamin) { echo "selected"; } ?>>Laki-laki</option> 
<option value="Perempuan" <?php if('Perempuan'==$jenis_kelamin) { echo "selected"; } ?>>Perempuan</option>                        
           </select>
          </div>

               
           
          
            <div class="form-group">
            <label for="">Kategori Usaha</label>
           <select name="kategori_usaha" class="form-control" id="kategori_usaha" required>
                  <option>Pilih salah satu</option>              
<option value="Perusahaan" <?php if('Perusahaan'==$kategori_usaha) { echo "selected"; } ?>>Perusahaan</option>
<option value="CV"  <?php if('CV'==$kategori_usaha) { echo "selected"; } ?>>CV</option>
<option value="Koperasi"  <?php if('Koperasi'==$kategori_usaha) { echo "selected"; } ?>>Koperasi</option>
<option value="Firma"  <?php if('Firma'==$kategori_usaha) { echo "selected"; } ?>>Firma</option>
<option value="Individu"  <?php if('Individu'==$kategori_usaha) { echo "selected"; } ?>>Individu (Truck)</option>
<option value="Broker"  <?php if('Broker'==$kategori_usaha) { echo "selected"; } ?>>Broker(perorangan)</option>                
                </select>
          </div>
          </div>
          <div class="col-md-4">
             
          <div class="form-group">
           <label for="">Jumlah Kendaraan</label>
          <input class="form-control" value="<?php echo $jumlah_kendaraan ?>" id="jumlah_kendaraan" name="jumlah_kendaraan" autocomplete="off" required>
          </div>
       
           
        

           
        <div class="form-group">
            <label for="">Status</label>
          <div class="radio" id="status" name="status" required>
 <label><input type="radio" name="status" value="1"  <?php if('1'==$status) { echo "checked='checked'"; } ?>>Aktif &nbsp;&nbsp;  </label>
 <label><input type="radio" name="status" value="0"  <?php if('0'==$status) { echo "checked='checked'"; } ?>>Tidak Aktif</label>
                </div>
          </div>
           <div class="form-group">
           <label for="">User input</label>
      <input class="form-control" type="hidden" value="<?php echo $this->data['users']->id;?>" id="user_input" name="user_input">

          <input class="form-control" value="<?php echo $this->data['users']->first_name;?>"autocomplete="off" readonly>
          </div>
           <div class="form-group">
           <label for="">Waktu input</label>
          <input class="form-control" value="<?php echo $waktu_input; ?>" id="waktu_input" name="waktu_input" autocomplete="off" readonly="">
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

              

<script 
  data-main="<?php echo base_url()?>assets/js/main/main-karyawan" 
  src="<?php echo base_url()?>assets/js/require.js">
</script>