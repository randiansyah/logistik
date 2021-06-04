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
    <h3 class="box-title"><i class="fa fa-tag"></i> Tambah Resto Baru</h3>
    </div>
    <form id="form" method="post">
      <div class="box-body">
        <div class="row">
          <div class="col-md-6">

            <div class="form-group">
              <label>Kode Cabang</label>
              <select class="form-control filter-column" id="id_cabang" name="id_cabang" required>
                <option value="" selected>Pilih salah satu</option>
                <?php
                  foreach($cabang as $data):
                  echo '<option value="'.$data->kdcbg.'">[ '.$data->kdcbg.' ] '.$data->nama_cbg.'</option>';
                  endforeach;
                ?>
              </select>
            </div>

            <div class="form-group row">
              <div class="col-md-6">
                <label for="">Nama Menu</label>
                <input class="form-control" id="nama_menu" name="nama_menu" autocomplete="off" required>
              </div>

              <div class="col-md-6">
                <label for="">Label Menu</label>
                <input class="form-control" id="label_menu" name="label_menu" autocomplete="off" required>
              </div>
            </div>

            <div class="form-group row">
              <div class="col-md-6">
                <label for="">Kelas Menu</label>
                <select class="form-control filter-column" id="kelas_menu" name="kelas_menu" required>
                  <option value="" selected>Pilih salah satu</option>
                  <option value="DI">[DI] Dine In</option>
                  <option value="GB">[GB] Grab Food</option>
                  <option value="GF">[GF] Go Food</option>
                  <option value="TA">[TA] Take Away</option>                  
                </select>
              </div>

              <div class="col-md-6">
                <label>Kategori</label>
                <select class="form-control filter-column" id="kategori_menu" name="kategori_menu" required>
                  <option value="" selected>Pilih salah satu</option>
                  <?php
                    foreach($kategori as $data):
                    echo '<option value="'.$data->nama_kategori.'">'.$data->nama_kategori.'</option>';
                    endforeach;
                  ?>
                </select>
              </div>
            </div>

          </div>
          <div class="col-md-6"> 

            <div class="form-group row">
              <div class="col-md-6">
                <label for="">Tipe Menu</label>
                <select class="form-control filter-column" id="tipe_menu" name="tipe_menu" required>
                  <option value="" selected>Pilih salah satu</option>
                  <option value="DRINK">[DRINK] Minuman</option>
                  <option value="FOOD">[FOOD] Makanan</option>
                  <option value="PAKET">[PAKET] Paket</option>                 
                </select>
              </div>

              <div class="col-md-6">
                <label>Satuan</label>
                <select id="satuan" name="satuan" class="form-control">
                    <option value="">Pilih salah satu</option>
                    <?php
                    foreach ($stn as $key => $val) { ?>
                      <option value="<?php echo $val->tag;?>"><?php echo '['.$val->tag.'] '.$val->label?></option>
                    <?php }
                    ?>
                  </select>
              </div>
            </div>

            <div class="form-group">
              <label for="">Harga Jual (Rp)</label>
              <input class="form-control numeric" id="harga_jual" name="harga_jual" autocomplete="off" required>
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
      <div class="box-footer pad-15 full-width bg-softgrey border-top bot-rounded text-right">
        <button type="submit" name="submit" class="btn btn-primary mleft-15" id="save-btn">Simpan</button>
        <a href="<?php echo base_url('menu');?>" class="btn btn-default">Batal</a>
      </div>
      <div class="box-body">

        <div class="row">
          <div class="col-md-12">
            <table class="table table-striped table-bordered table-hover dataTable no-footer"> 
              <thead>
                <th width="5">No. </th>
                <th class="text-center">Kode Barang</th>
                <th class="text-center">Nama Barang</th>
                <th class="text-center">Satuan Pakai</th>
                <th class="text-center btn-info" width="50" >Jml. Pakai</th> 
              </thead> 
              <tbody>
                <?php $i= 1; foreach($barang as $val){?>
                <tr>
                  <td class="text-center"><?php echo $i; ?></td>
                  <td class="text-center"><?php echo $val->id_barang ?></td>
                  <td><?php echo $val->nama_barang ?></td>
                  <td class="text-center"><?php echo $val->stn_pesan_barang ?></td>
                  <td>
                    <input type="hidden" name="barang[]" value="<?php echo $val->id_barang ?>">
                    <input type="text" class="d_qty numeric" name="jml[]" style="text-align:center">

                  </td> 
                </tr>
                <?php $i++; } ?>
              </tbody>      
            </table>
          </div>
        </div>
      </div>
    </form>
  </div>
</section>

              
<script data-main="<?php echo base_url()?>assets/js/main/main-menu-resto" src="<?php echo base_url()?>assets/js/require.js"></script>


  
