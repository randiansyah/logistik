<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/Admin_Controller.php';
class Laporan_transaksi extends Admin_Controller {
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
      $this->data['content'] = 'admin/laporan_transaksi/list_v';   
    }else{
      $this->data['content'] = 'errors/html/restrict'; 
    }
    
    $this->load->view('admin/layouts/page',$this->data);  
  }

  public function dataList()
  {
    $columns = array( 
            0 => 'id', 
            1 => 'nama',
            2 => 'tgl_jatuh_tempo',
            3 => '',
            4 => '',
            5 => '',
            6 => '',
            8 => '',
            9 => '',
        );

      $order = $columns[$this->input->post('order')[0]['column']];
      $dir = $this->input->post('order')[0]['dir'];
      $search = array();
      $limit = 0;
      $start = 0;
      
   $where = array();
    // $where = 'transaksi'; 

  $send = "";    
      $totalData = $this->transaksi_model->getCountAllBySUM($limit,$start,$search,$order,$dir,$where);       

        $searchColumn = $this->input->post('columns');
        $isSearchColumn = false;
        
if(!empty($searchColumn[1]['search']['value'])){
            $value = $searchColumn[1]['search']['value'];
            $isSearchColumn = true;
            $where['created_at >='] = $value;
        }else{
          $isSearchColumn = false;
        }  

        if(!empty($searchColumn[2]['search']['value'])){
            $value = $searchColumn[2]['search']['value'];
            $isSearchColumn = true;
               $where['created_at <='] = $value;
        }else{
$isSearchColumn = false;
        } 
      if($isSearchColumn){
        $totalFiltered = $this->transaksi_model->getCountAllBySUM($limit,$start,$search,$order,$dir,$where); 
      }else{
        $totalFiltered = $totalData;
      }  
       
    $limit = $this->input->post('length');
    $start = $this->input->post('start');
     
  

   $datas = $this->transaksi_model->getAllBySUM($limit,$start,$search,$order,$dir,$where);
    $suburl = $this->uri->segment(1);
     
        $new_data = array();
        if(!empty($datas))
        {
            foreach ($datas as $key=>$data)
            {   
  $namaCS = $this->customer_model->getAllById(array('id' => $data->kode_pelanggan));   
  $CS = (!empty($namaCS))?$namaCS[0]->nama:"";
        $where['kode_pelanggan'] = $data->kode_pelanggan;
        $total_kredit = $this->transaksi_model->getSumKredit($where);
        $total_cash = $this->transaksi_model->getSumCash($where);   
        $jatuh_tempo = $this->transaksi_model->getSumJatuhTempo($where); 
        //bayar
        $total_kredit_bayar = $this->transaksi_model->getSumKreditBayar($where);
        $total_cash_bayar = $this->transaksi_model->getSumCashBayar($where);   
       $total_bayar = $this->transaksi_model->getSumBayar($where);  
       $grand_total = $this->transaksi_model->getSumbelumBayar($where); 
         $action = "<a href='".base_url().$suburl."/rincian/".$data->kode_pelanggan."'><i class='fa fa-search'></i>".$CS."</a> "; 

            $nestedData['id']   = $start+$key+1;
            $nestedData['nama'] = $action;
        $nestedData['total_kredit'] = (!empty($total_kredit))?$total_kredit[0]->grand_total:"";
           $nestedData['total_cash'] = (!empty($total_cash))?$total_cash[0]->grand_total:"";
            $nestedData['jatuh_tempo'] = (!empty($jatuh_tempo))?$jatuh_tempo[0]->grand_total:"";

           $nestedData['grand_total'] = (!empty($grand_total))?$grand_total[0]->grand_total:"";
          
            //bayar
         $nestedData['total_kredit_bayar'] = (!empty($total_kredit_bayar))?$total_kredit_bayar[0]->grand_total:"";
           $nestedData['total_cash_bayar'] = (!empty($total_cash_bayar))?$total_cash_bayar[0]->grand_total:"";
           $nestedData['total_bayar'] = (!empty($total_bayar))?$total_bayar[0]->grand_total:"";
          
         
         
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

  public function rincian($id)
  {
    $this->load->helper('url');
     $id = $this->uri->segment(3);
    if($this->data['is_can_read']){
       $this->data['id'] = $id;

      $this->data['content'] = 'admin/laporan_transaksi/list_rincian_v';   
    }else{
      $this->data['content'] = 'errors/html/restrict'; 
    }
    
    $this->load->view('admin/layouts/page',$this->data);  
  }
   public function dataList_rincian()
  {
   $id = $this->input->post('id');
    $periode_start  = $this->input->post('periode_start');
    $periode_end  = $this->input->post('periode_end');
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
      $where = array();
 
      $where['kode_pelanggan'] = $id;
      $where['tipe'] = "transaksi"; 


  $send = "";    
      $totalData = $this->transaksi_model->getCountAllBy($limit,$start,$search,$order,$dir,$where);       

        $searchColumn = $this->input->post('columns');
        $isSearchColumn = false;
if(!empty($searchColumn[1]['search']['value'])){
            $value = $searchColumn[1]['search']['value'];
            $isSearchColumn = true;
            $where['created_at >='] = $value;
        }else{
          $isSearchColumn = false;
        }  

        if(!empty($searchColumn[2]['search']['value'])){
            $value = $searchColumn[2]['search']['value'];
            $isSearchColumn = true;
               $where['created_at <='] = $value;
        }else{
$isSearchColumn = false;
        }

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

             
         $namaCS = $this->customer_model->getAllById(array('id' => $data->kode_pelanggan));   
  $CS = (!empty($namaCS))?$namaCS[0]->nama:"";   
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
              
              $id_transaksi = "<a href='../../Transaksi/detail/".$data->id_transaksi."'><i class='fa fa-search' target='blank'></i> ".$data->id_transaksi."</a>";  
           if($data->status < "3"){
            $stat =  "Belum Lunas";
           }else{
            $stat =  "Lunas";
           }
            $nestedData['id']   = $start+$key+1;
            $nestedData['nama'] = $CS;
            $nestedData['id_transaksi']  =   $id_transaksi ;
            $nestedData['telp']  = $data->telp;
            $nestedData['kirim_via']  = 'Jalur '.$data->kirim_via;
            $nestedData['asal']  = $data->asal;
            $nestedData['tujuan']  = $data->tujuan;
            $nestedData['posting']  = $posting;
            $nestedData['status']  = $status;
            $nestedData['tgl_sekarang'] = date('d-m-Y');
    $nestedData['tgl_jatuh_tempo'] = date('d-m-Y', strtotime($data->tgl_jatuh_tempo));
        $nestedData['hari_terlewati'] = $stat; 
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

   function pdf(){
 $this->load->helper('url');
  $this->load->helper('html');
  $periode_start = $this->uri->segment(3);
  $periode_end = $this->uri->segment(4);
     $where = array();
     $where['created_at >='] = $periode_start;
     $where['created_at <='] = $periode_end;
     $search = array();
     $limit = 0;
     $start = 0;
     $order = 0;
     $dir = 0;
     $datas = $this->transaksi_model->getAllBySUM($limit,$start,$search,$order,$dir,$where);
    $new_data = array();
        if(!empty($datas))
        {
            foreach ($datas as $key=>$data)
            {   
  $namaCS = $this->customer_model->getAllById(array('id' => $data->kode_pelanggan));   
  $CS = (!empty($namaCS))?$namaCS[0]->nama:"";
        $where['kode_pelanggan'] = $data->kode_pelanggan;
        $total_kredit = $this->transaksi_model->getSumKredit($where);
        $total_cash = $this->transaksi_model->getSumCash($where);   
        $jatuh_tempo = $this->transaksi_model->getSumJatuhTempo($where); 
        //bayar
        $total_kredit_bayar = $this->transaksi_model->getSumKreditBayar($where);
        $total_cash_bayar = $this->transaksi_model->getSumCashBayar($where);   
       $total_bayar = $this->transaksi_model->getSumBayar($where);  
       $grand_total = $this->transaksi_model->getSumbelumBayar($where); 
         $action = "tes"; 

            $nestedData['id']   = $start+$key+1;
            $nestedData['nama'] = $CS;

        $nestedData['total_kredit'] = (!empty($total_kredit))?"Rp ".number_format($total_kredit[0]->grand_total,0,',','.'):"";
           $nestedData['total_cash'] = (!empty($total_cash))?"Rp ".number_format($total_cash[0]->grand_total,0,',','.'):"";
            $nestedData['jatuh_tempo'] = (!empty($jatuh_tempo))?"Rp ".number_format($jatuh_tempo[0]->grand_total,0,',','.'):"";

           $nestedData['grand_total'] = (!empty($grand_total))?"Rp ".number_format($grand_total[0]->grand_total,0,',','.'):"";
          
            //bayar
         $nestedData['total_kredit_bayar'] = (!empty($total_kredit_bayar))?"Rp ".number_format($total_kredit_bayar[0]->grand_total,0,',','.'):"";
           $nestedData['total_cash_bayar'] = (!empty($total_cash_bayar))?"Rp ".number_format($total_cash_bayar[0]->grand_total,0,',','.'):"";
           $nestedData['total_bayar'] = (!empty($total_bayar))?"Rp ".number_format($total_bayar[0]->grand_total,0,',','.'):"";
          //jumlah
             $nestedData['total_kredit_jumlah'] = (!empty($total_kredit))?$total_kredit[0]->grand_total:"";
                 $nestedData['total_cash_jumlah'] = (!empty($total_cash))?$total_cash[0]->grand_total:"";
            $nestedData['jatuh_tempo_jumlah'] = (!empty($jatuh_tempo))?$jatuh_tempo[0]->grand_total:"";

           $nestedData['grand_total_jumlah'] = (!empty($grand_total))?$grand_total[0]->grand_total:"";
               //bayar
         $nestedData['total_kredit_bayar_jumlah'] = (!empty($total_kredit_bayar))?$total_kredit_bayar[0]->grand_total:"";
           $nestedData['total_cash_bayar_jumlah'] = (!empty($total_cash_bayar))?$total_cash_bayar[0]->grand_total:"";
           $nestedData['total_bayar_jumlah'] = (!empty($total_bayar))?$total_bayar[0]->grand_total:"";
         
         
            $new_data[] = $nestedData; 
        }
    }
      $this->data['data'] = $new_data; 
      $this->data['periode_start'] = $periode_start; 
      $this->data['periode_end'] = $periode_end; 

     $this->load->library('pdf');

      $this->pdf->setPaper('A4', 'potrait');
    $this->pdf->filename = "Laporan Transaksi - ".date('dmy').".pdf";
    $this->pdf->load_view('admin/laporan_transaksi/cetak_v', $this->data, true);
  
}
   function pdf_rincian(){
 $this->load->helper('url');
  $this->load->helper('html');
  $id = $this->uri->segment(3);
  $periode_start = $this->uri->segment(4);
  $periode_end = $this->uri->segment(5);
     $where = array();
           $where['kode_pelanggan'] = $id;
      $where['tipe'] = "transaksi"; 
     $where['created_at >='] = $periode_start;
     $where['created_at <='] = $periode_end;
     $search = array();
     $limit = 0;
     $start = 0;
     $order = 0;
     $dir = 0;
     $datas = $this->transaksi_model->getAllBy($limit,$start,$search,$order,$dir,$where);
    $new_data = array();
        if(!empty($datas))
        {
            foreach ($datas as $key=>$data)
            {   
               if($data->status < "3"){
            $stat =  "Belum Lunas";
           }else{
            $stat =  "Lunas";
           }
  $namaCS = $this->customer_model->getAllById(array('id' => $data->kode_pelanggan));   
  $CS = (!empty($namaCS))?$namaCS[0]->nama:"";
            $nestedData['id']   = $start+$key+1;
            $nestedData['nama'] = $CS;
                     $nestedData['id_transaksi']  =   $data->id_transaksi  ;
            $nestedData['telp']  = $data->telp;
            $nestedData['kirim_via']  = 'Jalur '.$data->kirim_via;
            $nestedData['asal']  = $data->asal;
            $nestedData['tujuan']  = $data->tujuan;
            $nestedData['status']  = $stat;

            $nestedData['tgl_sekarang'] = date('d-m-Y');
    $nestedData['tgl_jatuh_tempo'] = date('d-m-Y', strtotime($data->tgl_jatuh_tempo));
       // $nestedData['hari_terlewati'] = $stat; 
        $nestedData['total_harga']  = "Rp.".number_format($data->total_harga_global,0,',','.');
        $nestedData['total_harga_jumlah']  = $data->total_harga_global;
            $nestedData['jadwal_pickup']  = date('d-m-Y H:i:s', strtotime($data->jadwal_pickup));
           $nestedData['jadwal_delivery']  = date('d-m-Y H:i:s', strtotime($data->jadwal_delivery));
            $nestedData['pickup']  = $data->delivery;
       
            $new_data[] = $nestedData; 
        }
    }
      $this->data['data'] = $new_data; 
      $this->data['periode_start'] = $periode_start; 
      $this->data['periode_end'] = $periode_end; 

     $this->load->library('pdf');

      $this->pdf->setPaper('A4', 'potrait');
    $this->pdf->filename = "Laporan Transaksi - ".date('dmy').".pdf";
    $this->pdf->load_view('admin/laporan_transaksi/cetak_rincian_v', $this->data, true);
  
}
 
  

}
?>