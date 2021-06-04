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
    <h3 class="box-title"><i class="fa fa-tag"></i>Manifest Detail</h3>
         <div class="datatableButton pull-right">
   <a href="<?php echo base_url('Manifest/pdf/'.$id_transaksi)?>" target="blank" id="pdf" class="btn btn-sm btn-success"><i class="fa fa-download"></i>&nbsp;Cetak Manifest</a>      
   </div> 
    </div>
     <form id="karyawan" method="post" enctype="multipart/form-data">
    <div class="box-body">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group"> 
           <div class="form-group">
            <label for="">Manifest ID</label>
            <input class="form-control" value="<?php echo $id_transaksi; ?>" id="id_transaksi" name="id_transaksi" autocomplete="off" required readonly>
          </div>
         
        <div class="form-group row">
                <div class="col-md-6">
           <label for="">User input</label>
      <input class="form-control" type="hidden" value="<?php echo $this->data['users']->id;?>" id="user_input" name="user_input">
       
          <input class="form-control" value="<?php echo $this->data['users']->first_name;?>"autocomplete="off" readonly>
          </div>
           <div class="col-md-6">
              <label for="">Waktu input</label>
          <input class="form-control" value="<?php echo date('Y-m-d'); ?>" id="waktu_input" name="waktu_input" autocomplete="off" readonly="">
           </div>
          </div>
    
           
         
     
        </div>
      </div>
      <div class="col-md-6">
   
          <div class="form-group">  
           
                <label for=""> Pilih Vendor</label>
                <select id="pelanggan" name="pelanggan" class="form-control">
                  <option value="">Pilih salah satu</option>
                  <?php
                  foreach ($vendor as $key => $val) { ?>
      <option value="<?php echo $val->id;?>"  <?php echo $val->id == $vendorData ? 'selected' : '' ?>><?php echo $val->nama ?></option>
                  <?php }
                  ?>
                </select>
            
            </div>
              
          <div class="form-group row">          
            <div class="col-sm-6">
                <label>Dari Tanggal</label>
                <input type="text" id="periode_start" value="<?php echo $tgl_rilis ?>" name="periode_start" class="form-control date" data-provide="datepicker" data-date-format="yyyy-mm-dd" placeholder="Dari Tanggal">
            </div>
            <div class="col-sm-6">
                <label>Sampai Tanggal</label>
                <input type="text" id="periode_end" name="periode_end" class="form-control date" data-provide="datepicker" data-date-format="yyyy-mm-dd" placeholder="Sampai Tanggal">
            </div>
          </div>
     <div class="form-group">
            <label for="">Asal</label>
            <input class="form-control"  id="asal" name="asal" autocomplete="off" >
          </div>
  
          

          </div>
          <div class="col-md-12"> 
            <div class="table-responsive">
            <?php if(!empty($this->session->flashdata('message'))){?>
            <div class="alert alert-info">
            <?php   
               print_r($this->session->flashdata('message'));
            ?>
            </div>
            <?php }?> 
             <?php if(!empty($this->session->flashdata('message_error'))){?>
            <div class="alert alert-info">
            <?php   
               print_r($this->session->flashdata('message_error'));
            ?>
            </div>
            <?php }?> 
            <table class="table table-striped"  > 
              <thead>
                <th width="5">#</th>
                <th class="text-center">NO SPB</th>
                <th class="text-center">Tujuan</th>
                <th class="text-center">Service</th>
                <th class="text-center">Coli</th> 
                <th class="text-center">KG</th> 
              </thead>   
              <tbody>
                   <?php $i=1; foreach ($spb as $val) {
      
      ?>

        <tr>
      <td class="text-center"><?php echo $i; ?></td>
        <td class="text-center"><?php echo $val->SPB; ?></td>
          <td class="text-center"><?php echo $val->tujuan; ?></td>
            <td class="text-center"><?php echo $val->service; ?></td>
              <td class="text-center"><?php echo $val->jumlah_coli; ?></td>
              <td class="text-center"><?php echo $val->berat; ?></td>
             
    </tr>
    <?php
    $i++;
  }
    ?>
              </tbody>     
            </table>
          </div>
        </div>

    </div>
    <br>
       <div class="col-sm-12"> 
 
          <div class="form-group text-right">
              <a href="#" class="btn btn-sm btn-default" id="jumlah"><i class="fa fa-calculator"></i> Total</a>    
             
          </div>
     
        </div>
   
      <div class="col-md-8">
      </div>
      <div class="col-md-2">
       <input class="form-control" value="<?php echo $coli ?>" placeholder="coli" type="text" value="" id="jcoli" name="jcoli">
</div>
      <div class="col-md-2">
       <input class="form-control" value="<?php echo $berat_total ?>"  placeholder="kg" type="text" value="" id="jkg" name="jkg">
</div>

 



         <div class="box-footer">
          <div class="row">
            <br>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
              <br>
  
                 <a href="<?php echo base_url($this->uri->segment(1))?>" class="btn btn-default"> Kembali</a>
            </div>
          </div>
      </div>
    </form>
  </div>
</section>

              

<script 
  data-main="<?php echo base_url()?>assets/js/main/main-manifest.js" 
  src="<?php echo base_url()?>assets/js/require.js">
</script>