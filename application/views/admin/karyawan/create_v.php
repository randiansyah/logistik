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
    <h3 class="box-title"><i class="fa fa-tag"></i> Tambah Karyawan</h3>
    </div>
     <form id="karyawan" method="post" enctype="multipart/form-data">
    <div class="box-body">
      <div class="row">
        <div class="col-md-4">
          <div class="form-group"> 
  
           <div class="form-group">
            <label for="">Kode Karyawan</label>
            <input class="form-control" id="KDPGW" name="KDPGW" autocomplete="off" required>
          </div>  
           <div class="form-group">
            <label for="">Nama</label>
            <input class="form-control" id="nama" name="nama" autocomplete="off" required>
          </div>   
           <div class="form-group">
            <label for="">Nickname</label>
            <input class="form-control" id="nickname" name="nickname" required>
          </div>  
           <div class="form-group">
            <label for="">Mulai Bekerja</label>
          <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right datepicker" autocomplete="off" id="mulai_bekerja" name="mulai_bekerja" required="">
                </div>
          </div>   
              <div class="form-group">
            <label for="">Alamat sesuai KTP</label>
 <textarea cols="4" rows="5"  class="form-control" id="alamat" name="alamat" required></textarea>
                    
          </div> 
           <div class="form-group">
            <label for="">Alamat sekarang</label>
        <textarea cols="4" rows="5" class="form-control" id="alamat_saat_ini" name="alamat_saat_ini" required></textarea>            
          </div>
     
        </div>
      </div>
      <div class="col-md-4">
    <div class="form-group">
            <label for="">No KTP</label>
            <input class="form-control" id="KTP" name="KTP" autocomplete="off" required>
          </div>
  <div class="form-group">
            <label for="">Tempat Lahir</label>
            <input class="form-control" id="tempat_lahir" name="tempat_lahir" autocomplete="off" required>
          </div>
           <div class="form-group">
            <label for="">Tanggal Lahir</label>
            <input class="form-control datepicker" id="tgl_lahir" autocomplete="off" name="tgl_lahir" autocomplete="off" required>
          </div>
            <div class="form-group">
            <label for="">Agama</label>
             <select class="form-control select2" id="agama" name="agama"  required >
                  <option>Pilih salah satu</option>              
                  <option value="Islam">Islam</option>   
                  <option value="Kristen">Kristen</option> 
                  <option value="Hindu">Hindu</option>
                  <option value="Katholik">Katholik</option> 
                  <option value="Buddha">Buddha</option>     
                </select>
          </div>
          <div class="form-group">
            <label for="">Jenis Kelamin</label>
           <select name="jenis_kelamin" class="form-control" id="jenis_kelamin" required>
                  <option>Pilih salah satu</option>              
                  <option value="Laki-laki">Laki-laki</option>   
                  <option value="Perempuan">Perempuan</option>             
                            
                </select>
          </div>
 <div class="form-group">
            <label for="">No HP</label>
            <input class="form-control" id="no_hp" name="no_hp" autocomplete="off" required>
          </div>
                <div class="form-group">
            <label for="">Golongan Darah</label>
           <select name="golongan_darah" class="form-control" id="golongan_darah" required>
                  <option>Pilih salah satu</option>              
                  <option value="A">A</option>   
                  <option value="B">B</option> 
                  <option value="AB">AB</option> 
                  <option value="O">O</option>             
                            
                </select>
          </div>
            <div class="form-group">
            <label for="">SIM</label>
           <select name="sim" class="form-control" id="sim" required>
                  <option>Pilih salah satu</option>              
                  <option value="A">A</option>   
                  <option value="D">D</option> 
                  <option value="C">C</option> 
                             
                </select>
          </div>
          
            <div class="form-group">
            <label for="">Status Pernikahan</label>
           <select name="status_pernikahan" class="form-control" id="status_pernikahan" required>
                  <option>Pilih salah satu</option>              
<option value="BM">[BM] Belum Menikah</option>
<option value="M0">[M0] Menikah belum ada anak</option>
<option value="M1">[M1] Menikah memiliki 1(satu) anak</option>
<option value="M2">[M2] Menikah memiliki 2(dua) anak</option>
<option value="M3">[M3] Menikah memiliki 3(tiga) anak</option>
<option value="JD">[JD] Janda</option>
<option value="DD">[DD] Duda</option>                 
                </select>
          </div>
          </div>
          <div class="col-md-4">
             <div class="form-group">
            <label for="">Pendidikan Terakhir</label>
           <select name="pendidikan_terakhir" class="form-control" id="pendidikan_terakhir" required>
                  <option>Pilih salah satu</option>              
<option value="SMP">[SMP] Sekolah Menengah Pertama</option>
<option value="SMA">[SMA] Sekolah Menengah Atas</option>
<option value="SMK">[SMK] Sekolah Menengah Kejuruan</option>
<option value="D1">[D1] Diploma 1</option>
<option value="D2">[D2] Diploma 2</option>
<option value="D3">[D3] Diploma 3</option>
<option value="S1">[S1] Strata 1</option>
<option value="S2">[S2] Strata 2</option>
<option value="S3">[S3] Strata 3</option>                
                </select>
          </div>
          <div class="form-group">
           <label for="">Instansi Pendidikan</label>
          <input class="form-control" id="instansi_pendidikan" name="instansi_pendidikan" autocomplete="off" required>
          </div>
          <div class="form-group">
           <label for="">Karyawan Level</label>
          <select name="staff_level" class="form-control" id="staff_level" required>
                  <option>Pilih salah satu</option>              
                  <option value="ACTMGR">[ACTMGR] Acting Manager</option>
<option value="ASTMGR">[ASTMGR] Assisten Manager</option>
<option value="CREW">[CREW] Crew</option>
<option value="EKSMGR">[EKSMGR] Eksekutif Manager</option>
<option value="JNRSPV">[JNRSPV] Junior Supervisor</option>
<option value="JNRSTAFF">[JNRSTAFF] Junior Staff</option>
<option value="MGR">[MGR] Manager</option>
<option value="SNRMGR">[SNRMGR] Senior Manager</option>
<option value="SPV">[SPV] Supervisor</option>
<option value="STAFF">[STAFF] Staff</option>
<option value="TRAINEE">[TRAINEE] Trainee</option>
                         
                </select>
          </div>
           <div class="form-group">
           <label for="">Divisi</label>
          <select name="divisi" class="form-control" id="divisi" required>
<option value="" selected="">Pilih salah satu</option>              
<option value="ALL">[ALL] Kantor</option>
<option value="AUD">[AUD] Audit</option>
<option value="BDV">[BDV] Bussiness Development</option>
<option value="BOA">[BOA] Board Of Adviser</option>
<option value="BOD">[BOD] Board Of Director</option>
<option value="FIN">[FIN] Finance</option>
<option value="GAF">[GAF] GA</option>
<option value="HRD">[HRD] HRD</option>
<option value="ITE">[ITE] IT</option>
<option value="LOG">[LOG] Logistik</option>
<option value="MKT">[MKT] Marketing</option>
<option value="OPM">[OPM] Operational Manager</option>
<option value="PRJ">[PRJ] Project</option>
<option value="PRO">[PRO] Produksi</option>
<option value="PUR">[PUR] Purchasing</option>
<option value="REC">[REC] Receiving</option>
<option value="SLS">[SLS] Sales</option>
<option value="SPV">[SPV] Supervisor</option>
<option value="TRO">[TRO] Training Officer</option>  
                </select>
          </div>
          <div class="form-group">
           <label for="">Status Karyawan</label>
          <select name="status_karyawan" class="form-control" id="status_karyawan" required>
                  <option>Pilih salah satu</option>              
                  <option value="Kontrak">Kontrak</option>   
                  <option value="Tetap">Tetap</option> 
                         
                </select>
          </div>

             <div class="form-group">
            <label for="">Photo Karyawan</label>
            <input class="form-control" id="photo" name="photo" type="file" autocomplete="off" required>
          </div>
           <div class="form-group">
            <label for="">Status</label>
          <div class="radio" id="status" name="status" required>
                  <label><input type="radio" name="status" value="1" checked='checked'>Aktif &nbsp;&nbsp;  </label>
                  <label><input type="radio" name="status" value="0">Tidak Aktif</label>
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
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
              <button type="submit" class="btn btn-primary pull-right">Simpan</button>
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