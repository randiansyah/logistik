<div class="form-group">
 <div class="col-md-8">
      <!-- AREA CHART -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <div class="form-group row">
          <div class="col-md-4">
            <div class="form-group">
          <h2 class="box-title"><i class="fa fa-line-chart"></i> Tren Penjualan Per Hari<small></small>

          </h2>
</div>
</div>
 <div class="col-md-3">
 <div class="form-group">
                <select id="pelanggan" name="pelanggan" class="form-control select2">
                  <option value="" selected></option>
                  <?php
                  foreach ($pelanggan as $key => $val) { ?>
      <option value="<?php echo $val->id;?>"><?php echo $val->nama ?></option>
                  <?php }
                  ?>
                </select>
       </div>
     </div>
            <div class="col-md-3">
          <div class="form-group">
               <button type="button" class="btn btn-default " id="daterange-btn">
            Periode <i class="fa fa-calendar"></i>
            <span>
               Date range picker
            </span>
            <i class="fa fa-caret-down"></i>
          </button>
        
 </div>
</div>

         
 
            
         
          <input type="hidden" id="periode_start">
          <input type="hidden" id="periode_end">
          
        </div>
      </div>
        <div class="box-body chart-responsive">
          <div class="chart" id="per_hari" style="height: 300px;"></div>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>

    <div class="col-md-4">
            <div class="info-box bg-aqua">
            <span class="info-box-icon"><i class="fa fa-money"></i></span>

            <div class="info-box-content">
              <span class="info-box-text"><b>Total Omset</b></span>
             <h3><div id="totalHarga"></div></h3>
            </div>
          </div>
        

   <section class="content">
  <div class="box box-default color-palette-box">
    <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-line-chart"></i> Transaksi Tertinggi</h3>
    <div class="pull-right"><a href="#" id="transaksiTinggiData"><b>Tampilkan Data</b></a></div>
    </div>
    <div class="box-body">
    <div class="box-header">
      
    </div>
      <div class="row hide" id="transaksi_tertinggi">
        <div class="col-md-12"> 
            <div class="table-responsive">
           
            <div id="totalHargaCS"></div>       
           
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
    </div>
  </div>

 <div class="col-md-6">
<div class="small-box bg-red">
        <div class="inner">
         <label>Tracking</label> 
         <h3>
          <div class="input-group input-group-sm" >
           <input type="text" id="inv" class="form-control">
                    <span class="input-group-btn">
                      <button type="button" id="search" class="btn btn-success btn-flat"><i class="fa fa-search"> cari</i></button>
                    </span>
              </div>
              </h3>
        </div>  
  <div class="box-footer no-padding " style="color:#333;">
              <ul class="nav nav-stacked">
              <div id="hasilTracking"></div>
              </ul>
            </div>
      </div>
    </div>
 <div class="col-md-6">
<div class="small-box bg-red">
 <div class="nav-tabs-custom">
            <ul class="nav nav-tabs bg-yellow">
              <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true"><i class="fa fa-truck"></i> Darat</a></li>
              <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false" style=""><i class="fa fa-ship"></i> Laut</a></li>
              <li><a href="#tab_3" data-toggle="tab"><i class="fa fa-plane"></i> Udara</a></li>
            
              <li class="pull-right"><a href="#" class="text-muted" style="color:#ffffff;"><b>Daftar Harga</b></a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
              <div class="input-group input-group-sm" >
           <input type="text" id="tujuan_darat" nama="tujuan_darat" class="form-control">
                    <span class="input-group-btn">
                      <button type="button" id="cari_tujuan_darat" class="btn btn-success btn-flat"><i class="fa fa-search"> cari</i></button>
                    </span>
              </div>
           
      
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2">
        <div class="input-group input-group-sm" >
           <input type="text" id="tujuan_laut" nama="tujuan_laut" class="form-control">
                    <span class="input-group-btn">
                      <button type="button" id="cari_tujuan_laut" class="btn btn-success btn-flat"><i class="fa fa-search"> cari</i></button>
                    </span>
              </div>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_3">
           <div class="input-group input-group-sm" >
           <input type="text" id="tujuan_udara" nama="tujuan_udara" class="form-control">
                    <span class="input-group-btn">
                      <button type="button" id="cari_tujuan_udara" class="btn btn-success btn-flat"><i class="fa fa-search"> cari</i></button>
                    </span>
              </div>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
      </div>
    </div>
    <div id="tableDaftarHarga" class="hide">
     <div class="col-md-12">
    
   <section class="content">
  <div class="box box-default color-palette-box">
    <div class="box-header with-border">
    <h3 class="box-title"><div id="head_tujuan"></div></h3>
    
    </div>
    <div class="box-body">
    <div class="box-header">
      
    </div>
      <div class="row">
        <div class="col-md-12"> 
            <div class="table-responsive">
            <table class="table table-bordered" id="table"> 
              <thead>

<tr>
<th>Tujuan</th>
<th>KG</th>
<th>Min</th>
<th>Coli A (1-10Kg)</th>
<th>Coli B (10-20Kg)</th>
<th>Coli C (20-30Kg)</th>
<th>Lead Time</th>
<th>Keterangan</th>
                 
    </tr>          </thead>        
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
    </div>
    </div>

 <div class="col-lg-3 col-xs-6">
  <div class="small-box bg-aqua">
        <div class="inner">
       <h3>  <?php print_r($pesanan);?></h3>

          <p>Total Order</p>
        </div>
        <div class="icon">
          <i class="fa fa-shopping-cart"></i>
        </div>
        <a href="<?php echo base_url('/pesanan')?>" class="small-box-footer">Jumlah Order</a>
      </div>
    </div>