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
    <h3 class="box-title"><i class="fa fa-tag"></i> Tambah Customer</h3>
    </div>
     <form id="karyawan" method="post" enctype="multipart/form-data">
    <div class="box-body">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group"> 
  
        
           <div class="form-group">
            <label for="">Nama</label>
            <input class="form-control" id="nama" name="nama" autocomplete="off" required>
          </div>  
           <div class="form-group">
            <label for="">Email</label>
            <input class="form-control" id="email" name="email" autocomplete="off" required>
          </div> 
           <div class="form-group">
            <label for="">Telp</label>
            <input class="form-control" id="no_hp" name="no_hp" autocomplete="off" required>
          </div> 
         
          
              <div class="form-group">
            <label for="">Alamat</label>
 <textarea cols="3" rows="4"  class="form-control" id="alamat" name="alamat" required></textarea>
                    
          </div> 
          
        </div>
      </div>
      <div class="col-md-6">
 
    
      
          <div class="form-group">
            <label for="">Jenis Kelamin</label>
           <select name="jenis_kelamin" class="form-control" id="jenis_kelamin" required>
                  <option>Pilih salah satu</option>              
                  <option value="Laki-laki">Laki-laki</option>   
                  <option value="Perempuan">Perempuan</option>             
                            
                </select>
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
  <div class="form-group">
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