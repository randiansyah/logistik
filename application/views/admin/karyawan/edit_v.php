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
    <h3 class="box-title"><i class="fa fa-tag"></i> Ubah data Karyawan</h3>
    </div>
     <form id="form" method="post" enctype="multipart/form-data"> 
      <input type="hidden" id="filephoto" name="filephoto" value="<?php echo $photo;?>"> 
    <div class="box-body">
      <div class="row">
        <div class="col-md-4">
          <div class="form-group">
          
         
           <div class="form-group">
            <label for="">Kode Karyawan</label>
            <input class="form-control" id="KDPGW" name="KDPGW" value="<?php echo $KDPGW;?>" autocomplete="off">
          </div>  
           <div class="form-group">
            <label for="">Nama</label>
            <input class="form-control" value="<?php echo $nama;?>" id="nama" name="nama" autocomplete="off" required>
          </div>   
           <div class="form-group">
            <label for="">Nickname</label>
            <input class="form-control" id="nickname" value="<?php echo $nickname;?>"   name="nickname" autocomplete="off" required>
          </div>  
           <div class="form-group">
            <label for="">Mulai Bekerja</label>
          <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right datepicker" id="mulai_bekerja" name="mulai_bekerja" value="<?php echo $mulai_bekerja;?>"  required="">
                </div>
          </div>   
              <div class="form-group">
            <label for="">Alamat sesuai KTP</label>
 <textarea cols="4" rows="5" value="<?php echo $alamat;?>"   class="form-control" id="alamat" name="alamat" required><?php echo $alamat;?></textarea>
                    
          </div> 
           <div class="form-group">
            <label for="">Alamat sekarang</label>
        <textarea cols="4" rows="5" value="<?php echo $alamat_saat_ini; ?>" class="form-control" id="alamat_saat_ini" name="alamat_saat_ini" required><?php echo $alamat_saat_ini;?></textarea>            
          </div>
     
        </div>
      </div>
      <div class="col-md-4">
    <div class="form-group">
            <label for="">No KTP</label>
            <input class="form-control" id="KTP" name="KTP" value="<?php echo $KTP; ?>" autocomplete="off" required>
          </div>
  <div class="form-group">
            <label for="">Tempat Lahir</label>
            <input class="form-control" id="tempat_lahir" name="tempat_lahir" value="<?php echo $tempat_lahir; ?>" autocomplete="off" required>
          </div>
           <div class="form-group">
            <label for="">Tanggal Lahir</label>
            <input class="form-control datepicker" id="tgl_lahir" name="tgl_lahir" value="<?php echo $tgl_lahir; ?>" autocomplete="off" required>
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
            <label for="">No HP</label>
            <input class="form-control" value="<?php echo $no_hp;?>" id="no_hp" name="no_hp" autocomplete="off" required>
          </div>
                <div class="form-group">
            <label for="">Golongan Darah</label>
           <select name="golongan_darah" class="form-control" id="golongan_darah" required>
                  <option>Pilih salah satu</option> 
<option value="A" <?php if('A'==$golongan_darah) { echo "selected"; } ?>>A</option>
<option value="B" <?php if('B'==$golongan_darah) { echo "selected"; } ?>>B</option>
<option value="AB" <?php if('AB'==$golongan_darah) { echo "selected"; } ?>>AB</option>
<option value="O" <?php if('O'==$golongan_darah) { echo "selected"; } ?>>O</option>
                </select>
          </div>
            <div class="form-group">
            <label for="">SIM</label>
           <select name="sim" class="form-control" id="sim" required>
                  <option>Pilih salah satu</option>
                   <option value="A" <?php if('A'==$sim) { echo "selected"; } ?>>A</option>   
                   <option value="D" <?php if('D'==$sim) { echo "selected"; } ?>>D</option>
                   <option value="C" <?php if('C'==$sim) { echo "selected"; } ?>>C</optiion>
                </select>
          </div>
          
            <div class="form-group">
            <label for="">Status Pernikahan</label>
           <select name="status_pernikahan" class="form-control" id="status_pernikahan" required>
                  <option>Pilih salah satu</option>
<option value="BM"  <?php if('BM'==$status_pernikahan) { echo "selected"; } ?>>[BM] Belum Menikah</option>
<option value="M0"  <?php if('M0'==$status_pernikahan) { echo "selected"; } ?>>[M0] Menikah belum ada anak</option>
<option value="M1"  <?php if('M1'==$status_pernikahan) { echo "selected"; } ?>>[M1] Menikah memiliki 1(satu) anak</option>
<option value="M2"  <?php if('M2'==$status_pernikahan) { echo "selected"; } ?>>[M2] Menikah memiliki 2(dua) anak</option>
<option value="M3"  <?php if('M3'==$status_pernikahan) { echo "selected"; } ?>>[M3] Menikah memiliki 3(tiga) anak</option>
<option value="JD"  <?php if('JD'==$status_pernikahan) { echo "selected"; } ?>>[JD] Janda</option>
<option value="DD"  <?php if('DD'==$status_pernikahan) { echo "selected"; } ?>>[DD] Duda</option>                
                              
                </select>
          </div>
          </div>
          <div class="col-md-4">
             <div class="form-group">
            <label for="">Pendidikan Terakhir</label>
           <select name="pendidikan_terakhir" class="form-control" id="pendidikan_terakhir" required>
                  <option>Pilih salah satu</option>
<option value="SMP" <?php if('SMP'==$pendidikan_terakhir) { echo "selected"; } ?>>[SMP] Sekolah Menengah Pertama</option>
<option value="SMA" <?php if('SMA'==$pendidikan_terakhir) { echo "selected"; } ?>>[SMA] Sekolah Menengah Atas</option>
<option value="SMK" <?php if('SD'==$pendidikan_terakhir) { echo "selected"; } ?>>[SMK] Sekolah Menengah Kejuruan</option> 
<option value="D1" <?php if('D1'==$pendidikan_terakhir) { echo "selected"; } ?>>[D1] Diploma 1</option> 
<option value="D2" <?php if('D2'==$pendidikan_terakhir) { echo "selected"; } ?>>[D2] Diploma 2</option> 
<option value="D3" <?php if('D3'==$pendidikan_terakhir) { echo "selected"; } ?>>[D3] Diploma 3</option> 
<option value="S1" <?php if('S1'==$pendidikan_terakhir) { echo "selected"; } ?>>[S1] Strata 1</option>
<option value="S2" <?php if('S2'==$pendidikan_terakhir) { echo "selected"; } ?>>[S2] Strata 2</option> 
<option value="S3" <?php if('S3'==$pendidikan_terakhir) { echo "selected"; } ?>>[S3] Strata 3</option>                     

                             
                </select>
          </div>
          <div class="form-group">
           <label for="">Instansi Pendidikan</label>
          <input class="form-control" value="<?php echo $instansi_pendidikan; ?>" id="instansi_pendidikan" name="instansi_pendidikan" autocomplete="off" required>
          </div>
          <div class="form-group">
           <label for="">Staff Level</label>
          <select name="staff_level" class="form-control" id="staff_level" required>
                  <option>Pilih salah satu</option>
<option value="ACTMGR" <?php if('ACTMGR'==$staff_level) { echo "selected"; } ?>>[ACTMGR] Acting Manager</option>
<option value="ASTMGR" <?php if('ASTMGR'==$staff_level) { echo "selected"; } ?>>[ASTMGR] Assisten Manager</option>
<option value="CREW" <?php if('CREW'==$staff_level) { echo "selected"; } ?>>[CREW] Crew</option>
<option value="EKSMGR" <?php if('EKSMGR'==$staff_level) { echo "selected"; } ?>>[EKSMGR] Eksekutif Manager</option>      
<option value="JNRSPV" <?php if('JNRSPV'==$staff_level) { echo "selected"; } ?>>[JNRSPV] Junior Supervisor</option>
<option value="JNRSTAFF" <?php if('JNRSTAFF'==$staff_level) { echo "selected"; } ?>>[JNRSTAFF] Junior Staff</option>
<option value="MGR" <?php if('MGR'==$staff_level) { echo "selected"; } ?>>[MGR] Manager</option>
<option value="SNRMGR" <?php if('SNRMGR'==$staff_level) { echo "selected"; } ?>>[SNRMGR] Senior Manager</option>
<option value="SPV" <?php if('SPV'==$staff_level) { echo "selected"; } ?>>[SPV] Supervisor</option>
<option value="STAFF" <?php if('STAFF'==$staff_level) { echo "selected"; } ?>>[STAFF] Staff</option>
<option value="TRAINEE" <?php if('TRAINEE'==$staff_level) { echo "selected"; } ?>>[TRAINEE] Trainee</option>                       
                </select>
          </div>
           <div class="form-group">
           <label for="">Divisi</label>
          <select name="divisi" class="form-control" id="divisi" required>
                  <option value="" selected="">Pilih salah satu</option>              
 <option value="ALL" <?php if('ALL'==$divisi) { echo "selected"; } ?>>[ALL] Kantor</option>
 <option value="AUD" <?php if('AUD'==$divisi) { echo "selected"; } ?>>[AUD] Audit</option>
 <option value="BDV" <?php if('BDV'==$divisi) { echo "selected"; } ?>>[BDV] Bussiness Development</option>
 <option value="BOA" <?php if('BOA'==$divisi) { echo "selected"; } ?>>[BOA] Board Of Adviser</option>
 <option value="BOD" <?php if('BOD'==$divisi) { echo "selected"; } ?>>[BOD] Board Of Director</option>
 <option value="FIN" <?php if('FIN'==$divisi) { echo "selected"; } ?>>[FIN] Finance</option>     
 <option value="GAF" <?php if('GAF'==$divisi) { echo "selected"; } ?>>[GAF] GA</option>
 <option value="HRD" <?php if('HRD'==$divisi) { echo "selected"; } ?>>[HRD] HRD</option>
<option value="ITE" <?php if('ITE'==$divisi) { echo "selected"; } ?>>[ITE] IT</option>
<option value="HRD" <?php if('HRD'==$divisi) { echo "selected"; } ?>>[HRD] HRD</option>
<option value="LOG" <?php if('LOG'==$divisi) { echo "selected"; } ?>>[LOG] Logistik</option>
<option value="MKT" <?php if('MKT'==$divisi) { echo "selected"; } ?>>[MKT] Marketing</option>
<option value="OPM" <?php if('OPM'==$divisi) { echo "selected"; } ?>>[OPM] Operational Manager</option>
<option value="PRJ" <?php if('PRJ'==$divisi) { echo "selected"; } ?>>[PRJ] Project</option>
<option value="PRO" <?php if('PRO'==$divisi) { echo "selected"; } ?>>[PRO] Produksi</option>
<option value="PUR" <?php if('PUR'==$divisi) { echo "selected"; } ?>>[PUR] Purchasing</option>
<option value="REC" <?php if('REC'==$divisi) { echo "selected"; } ?>>[REC] Receiving</option>
<option value="SLS" <?php if('SLS'==$divisi) { echo "selected"; } ?>>[SLS] Sales</option>
<option value="SPV" <?php if('SPV'==$divisi) { echo "selected"; } ?>>[SPV] Sales</option>
<option value="TRO" <?php if('TRO'==$divisi) { echo "selected"; } ?>>[TRO] raining Officer</option>
</select>
          </div>
          <div class="form-group">
           <label for="">Status Karyawan</label>
          <select name="status_karyawan" class="form-control" id="status_karyawan" required>
                  <option>Pilih salah satu</option> 
<option value="Kontrak" <?php if('Kontrak'==$status_karyawan) { echo "selected"; } ?>>Kontrak</option>   
<option value="Tetap" <?php if('Tetap'==$status_karyawan) { echo "selected"; } ?>>Tetap</option>
         </select>
          </div>
 <div class="form-group">
            <label for="">Photo Karyawan</label>
            <img class="img-responsive" src="<?php echo base_url('assets/upload/image/').$photo; ?>" alt="Photo">
          </div>
             <div class="form-group">
            <label for="">Photo Karyawan</label>
            <input class="form-control" id="photo" name="photo" type="file" autocomplete="off" >
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