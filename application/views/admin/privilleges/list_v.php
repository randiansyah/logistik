<section class="content">
  <div class="box box-default color-palette-box">
    <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-tag"></i> Privilleges</h3>
    </div>
    <div class="box-body">
      <div class="row">
        <div class="col-md-12"> 
        <div class="table-responsive">
        <?php if(!empty($this->session->flashdata('message'))){?>
        <div class="alert alert-info">
        <?php   
           print_r($this->session->flashdata('message'));
        ?>
        </div>
        <?php }?> 
        <table class="table table-striped" id="table"> 
          <thead>
            <th>No Urut</th>
            <th>Role</th>  
            <th>Action</th> 
          </thead>        
        </table>
      </div>
        </div>
      </div>
    </div>
  </div>
</section>


<script 
  data-main="<?php echo base_url()?>assets/js/main/main-privilleges" 
  src="<?php echo base_url()?>assets/js/require.js">  
</script>

