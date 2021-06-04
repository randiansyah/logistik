<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/Admin_Controller.php';
class Jatuh_tempo extends Admin_Controller {
  public function __construct()
  {
    parent::__construct();
    $this->load->model('customer_model'); 
    $this->load->model('transaksi_model');
    $this->load->model('transaksi_ukuran_model');
    $this->load->model('wilayah_model');
    $this->load->model('vendor_model');
  }
  public function index()
  {
    $this->load->helper('url');
    if($this->data['is_can_read']){
      $this->data['content'] = 'admin/jatuh_tempo/list_v';   
    }else{
      $this->data['content'] = 'errors/html/restrict'; 
    }
    
    $this->load->view('admin/layouts/page',$this->data);  
  }

  public function dataList()
  {
    $columns = array( 
            0 => 'id', 
            1 => 'id_transaksi',
            2 => 'nama',
            3 => 'telp',
            4 => 'kirim_via',
            5 => 'asal',
            6 => 'tujuan',
        );

      $order = $columns[$this->input->post('order')[0]['column']];
      $dir = $this->input->post('order')[0]['dir'];
      $search = array();
      $limit = 0;
      $start = 0;
      
 
      $where = "tipe = 'transaksi' and tgl_jatuh_tempo <= CURDATE()";

  $send = "";    
      $totalData = $this->transaksi_model->getCountAllBy($limit,$start,$search,$order,$dir,$where);       

        $searchColumn = $this->input->post('columns');
        $isSearchColumn = false;
        

      if($isSearchColumn){
        $totalFiltered = $this->transaksi_model->getCountAllBy($limit,$start,$search,$order,$dir,$where); 
      }else{
        $totalFiltered = $totalData;
      }  
       
    $limit = $this->input->post('length');
    $start = $this->input->post('start');
     
  

    $datas = $this->transaksi_model->getAllBy($limit,$start,$search,$order,$dir,$where);
    $suburl = $this->uri->segment(1);
     
        $new_data = array();
        if(!empty($datas))
        {
            foreach ($datas as $key=>$data)
            {   

             
          
             $posting="";
           
              if($this->data['is_superadmin']){
              $adminAct = "<a href='#' 
                  url='".base_url().$suburl."/destroy/".$data->id_transaksi."'
                  class='delete' 
                   ><i class='fa fa-trash'></i>&nbsp;Hapus
                  </a>";
               }else{
        $adminAct = "";
               }
              

              if($data->posting >= 1){
                $posting = '<i class="fa fa-check-circle"></i> Posted';
              }if($data->posting == 4){
                $posting = '<i class="fa fa-thumbs-up"></i> Selesai';
              }

             
           if($data->status == 2){
                $status = '<i class="fa fa-spinner"></i> Selesai di Konfirmasi';
                 if($this->data['is_can_edit']){
             $action = "<a href='".base_url().$suburl."/proses/".$data->id_transaksi."'><i class='fa fa-check'></i>Revisi</a>&nbsp;&nbsp;&nbsp;<a href='#' 
                  url='".base_url()."Transaksi/selesai/".$data->id_transaksi."'
                  class='selesai' 
                   ><i class='fa fa-check'></i>&nbsp;Selesai
                  </a><br>".$adminAct;
               }else{
        $action = "";
               }
              

              } else if($data->status == 3){
                $status = '<i class="fa fa-check "></i> Finish';
              $action = $adminAct;
              } else if($data->status == 4){
                $status = '<i class="fa fa-check "></i> Finish';
              $action = $adminAct;
             
              }else{
                $status = '<i class="fa fa-spinner"></i>Belum di proses';
                if($this->data['is_can_edit']){
             $action = "<a href='".base_url().$suburl."/proses/".$data->id_transaksi."'><i class='fa fa-check'></i>Konfirmasi</a><br>".$adminAct;
               }else{
        $action = "";
               }
               
              }
              
              $id_transaksi = "<a href='Transaksi/detail/".$data->id_transaksi."'><i class='fa fa-search'></i> ".$data->id_transaksi."</a>";  
           
            $nestedData['id']   = $start+$key+1;
            $nestedData['nama'] = $data->nama;
            $nestedData['id_transaksi']  =   $id_transaksi ;
            $nestedData['telp']  = $data->telp;
            $nestedData['kirim_via']  = 'Jalur '.$data->kirim_via;
            $nestedData['asal']  = $data->asal;
            $nestedData['tujuan']  = $data->tujuan;
            $nestedData['posting']  = $posting;
            $nestedData['status']  = $status;
            $nestedData['tgl_sekarang'] = date('d-m-Y');
    $nestedData['tgl_jatuh_tempo'] = date('d-m-Y', strtotime($data->tgl_jatuh_tempo));
        $nestedData['hari_terlewati'] = $data->selisih; 
            $nestedData['total_harga']  = "Rp.".number_format($data->total_harga_global,0,',','.');
            $nestedData['jadwal_pickup']  = date('d-m-Y H:i:s', strtotime($data->jadwal_pickup));
           $nestedData['jadwal_delivery']  = date('d-m-Y H:i:s', strtotime($data->jadwal_delivery));
            $nestedData['pickup']  = $data->delivery;
            $nestedData['action']  = $action;
            
         
            $new_data[] = $nestedData; 
        }
    }
      
    $json_data = array(
                "draw"            => intval($this->input->post('draw')),  
                "recordsTotal"    => intval($totalData),  
                "recordsFiltered" => intval($totalFiltered), 
                "data"            => $new_data   
                );
        
    echo json_encode($json_data); 
  }
  

}
?>