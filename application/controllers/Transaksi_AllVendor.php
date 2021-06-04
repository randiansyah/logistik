<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/Admin_Controller.php';
class Transaksi_AllVendor extends Admin_Controller {
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
      $this->data['content'] = 'admin/invoice_allvendor/list_v';   
    }else{
      $this->data['content'] = 'errors/html/restrict'; 
    }
    
    $this->load->view('admin/layouts/page',$this->data);  
  }

    public function dataList_manifest()
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
       $where = array ('tipe' => 'j_manifest' );
  $send = "";   
      $totalData = $this->transaksi_model->getCountAllBy($limit,$start,$search,$order,$dir,$where,$send);       

        $searchColumn = $this->input->post('columns');
        $isSearchColumn = false;
        

      if($isSearchColumn){
        $totalFiltered = $this->transaksi_model->getCountAllBy($limit,$start,$search,$order,$dir,$where,$send); 
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
   $getSum = $this->transaksi_ukuran_model->getSumAllbyid(array('id_transaksi' => $data->id_transaksi ));
    $total_satuan = (!empty($getSum))?$getSum[0]->total_satuan:"";
             
          $vendorData = $this->vendor_model->getAllByid(array('id' => $data->vendor ));
          $nama_vendor = (!empty($vendorData))?$vendorData[0]->nama:"";
             $posting="";
           
              if($this->data['is_can_delete']){
         $action1 = "<a href='#' 
                  url='".base_url().$suburl."/destroy/".$data->id_transaksi."'
                  class='delete' 
                   ><i class='fa fa-trash'></i>&nbsp;Hapus
                  </a>";
               }else{
        $action1 = "";
               }
              

              if($data->posting >= 1){
                $posting = '<i class="fa fa-check-circle"></i> Posted';
              }if($data->posting == 4){
                $posting = '<i class="fa fa-thumbs-up"></i> Selesai';
              }
 
             if($data->status == 3){
                $status = '<i class="fa fa-check-circle"></i> Sudah di proses';
              $action = '<i class="fa fa-thumbs-up"></i> Selesai';
              } else if($data->status == 4){
                $status = '<i class="fa fa-check-circle"></i> Posted';
              $action = '';
             
              }else{
                $status = '';
                  $action = "<a href='".base_url().$suburl."/pdf/".$data->id_transaksi."'><i class='fa fa-check'></i>Print</a>&nbsp;&nbsp;&nbsp;".$action1;
              }
              
              $id_transaksi = "<a href='#'><i class='fa fa-search'></i> ".$data->id_transaksi."</a>";  
           
            $nestedData['id']   = $start+$key+1;
            $nestedData['vendor'] = $nama_vendor;
            $nestedData['id_transaksi']  =   $id_transaksi ;

            $nestedData['kirim_via']  = 'Jalur '.$data->kirim_via;
            $nestedData['koli']  = $data->koli;
            $nestedData['kg']  = $data->berat_total;
            $nestedData['asal']  = $data->asal;
            $nestedData['tujuan']  = $data->tujuan;
            $nestedData['posting']  = $posting;
            $nestedData['total']  = number_format($total_satuan,0,'.','.');
        $nestedData['tanggal']  = date('d-m-Y', strtotime($data->created_at));

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
        
  $where = array ("tipe" => 'manifest' );
  $send = "";    
      $totalData = $this->transaksi_model->getCountAllBy($limit,$start,$search,$order,$dir,$where);       

        $searchColumn = $this->input->post('columns');
        $isSearchColumn = false;
        

      if($isSearchColumn){
        $totalFiltered = $this->transaksi_model->getCountAllBy($limit,$start,$search,$order,$dir,$where); 
      }else{
        $totalFiltered = $totalData;
      }  

      if(!empty($searchColumn[1]['search']['value'])){
            $value = $searchColumn[1]['search']['value'];
            $isSearchColumn = true;
            $search['vendor'] = $value;
        }

         if(!empty($this->input->post('periode_start'))){
            $isSearchColumn = true;
            $where["tgl_pengajuan >="] = $this->input->post('periode_start');
            $where["tgl_pengajuan <="] =  $this->input->post('periode_end');
        }   
       
    $limit = 0;
    $start = $this->input->post('start');
     
    if(!empty($searchColumn[1]['search']['value']) == true){
    $datas = $this->transaksi_model->getAllBy($limit,$start,$search,$order,$dir,$where);
   }else{
    $datas= array();
   }
    $suburl = $this->uri->segment(1);
     
        $new_data = array();
        if(!empty($datas))
        {
            foreach ($datas as $key=>$data)
            {   


              
            
           
            $idnya   = $start+$key+1;
  $nestedData['id']  =  "<input type='hidden' class='form-control' id-tr='".$idnya."' name='id[]' value='".$idnya."'>'" ;
 
    $nestedData['id_transaksi']  =  "<input type='text' class='form-control' name='spb[]' value='".$data->inv_vendor."'>" ;
         
    $nestedData['tanggal']  = "<input type='text' class='form-control' name='tanggal[]' value='".$data->tgl_pengajuan."'>" ;

    $nestedData['coli']  = "<input type='text' class='form-control' name='coli[]' value='".$data->koli."'>" ;

    $nestedData['kg']  = "<input type='text' class='form-control' name='kg[]' value='".$data->berat_total."'>" ;

    $nestedData['total']  = "<input type='text' class='form-control harga' name='total[]' value='".$data->total."'>" ;


  
    $nestedData['created_at']  = date('d-m-Y H:i:s', strtotime($data->created_at));
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


public function detail($id)
  { 
    $this->form_validation->set_rules('id_transaksi',"transaksi tidak boleh kosong", 'trim|required'); 
  $date = date('y-m-d H:i:s');
        $cekNomor = 'PR'.$this->data['users']->id.'IP'.date('d');
   $kode = $this->transaksi_model->getKode(array('id_transaksi' => $cekNomor));
   $nomor = $cekNomor.$kode;
 
 

    if ($this->form_validation->run() === TRUE)
    { 

        $total_harga1 = str_replace(".","",$this->input->post('sub_total'));
        $total_harga  = str_replace("Rp","",$total_harga1);

        //pajak
      $pajak1 = str_replace(".","",$this->input->post('pajak'));
      $pajak  = str_replace("Rp","",$pajak1);
      //total plus pajak
       $total1 = str_replace(".","",$this->input->post('total'));
       $total  = str_replace("Rp","",$total1);

      //packing
      $packing1 = str_replace(".","",$this->input->post('harga_packing'));
      $packing  = str_replace("Rp","",$packing1);
      //
      $asuransi1 = str_replace(".","",$this->input->post('harga_asuransi'));
      $asuransi  = str_replace("Rp","",$asuransi1);

      $global1 = str_replace(".","",$this->input->post('grand_total'));
      $global  = str_replace("Rp","",$global1);

         $dataD = array(  
          'tgl_pengajuan' => $this->input->post('tgl_rilis'),
          'tgl_jatuh_tempo' => $this->input->post('tgl_jatuh_tempo'),
          'catatan' => $this->input->post('catatan'),
          'total_harga' => $total_harga,
          'pajak' => $pajak,
          'total' => $total,
          'total_harga_packing' => $packing,
          'total_harga_asuransi' => $asuransi,
          'total_harga_global' => $global,
          'posting'      => 2,
          'status'       => 2,
          'updated_by'       => $this->input->post('user_input'),

        );
      
     $update = $this->transaksi_model->update($dataD,array("id_transaksi"=>$id));
    
      
      if ($update)
      {
 
        
      $this->transaksi_ukuran_model->delete(array("id_transaksi"=>$id));

        $no = $this->input->post('no');
       

        $total_harga1 = str_replace(".","",$this->input->post('total'));
        $total_harga  = str_replace("Rp","",$total_harga1);

       
        $spb = $this->input->post('id_transaksi');
        $coli = $this->input->post('coli');
        $kg = $this->input->post('kg');
     
        $order_detail = [];
      
        foreach ($no as $key => $val) {
          if($no[$key] > 0 ){
          $order_detail[] = array(
            'id_transaksi'  =>  $this->input->post('id_transaksi'),
            'SPB'   => $spb[$key],
            'berat_total'   => $kg[$key],
            'jumlah_coli'   => $coli[$key],
            'harga_satuan'   => $harga_satuan[$key],
            'total_harga_satuan'   => $total_harga[$key],

          );
        }
      }
        $this->db->insert_batch('transaksi_ukuran', $order_detail);

        $this->session->set_flashdata('message', "Invoice Berhasil Di revisi");
        redirect("Transaksi_cs");


      }else{
        $this->session->set_flashdata('message_error', "Invoice Gagal Di revisi");
        redirect("Transaksi_cs","refresh");
      }
    }else{
      if(!empty($_POST)){ 
        $this->session->set_flashdata('message_error',validation_errors());
        return redirect("Transaksi_vendor/revisi/".$id);  
      }else{

        $data = $this->transaksi_model->getAllById(array("id_transaksi"=>$id));
      $spb = $this->transaksi_ukuran_model->getAllById(array("id_transaksi"=>$id));

        $this->data['id_transaksi'] =   (!empty($data))?$data[0]->id_transaksi:"";
        $this->data['waktu_input']    =   (!empty($data))?$data[0]->created_at:"";
        $this->data['vendorData']    =   (!empty($data))?$data[0]->kode_pelanggan:"";
        $this->data['kode']    =  (!empty($data))?$data[0]->inv_vendor:"";
        $this->data['created_at']    =  (!empty($data))?$data[0]->created_at:"";
        $this->data['tgl_pengajuan']    =  (!empty($data))?$data[0]->tgl_pengajuan:"";
      $this->data['tgl_jatuh_tempo']    =  (!empty($data))?$data[0]->tgl_jatuh_tempo:"";

      $this->data['total_harga']    =  (!empty($data))?$data[0]->total_harga:"";
      $this->data['pajak']    =  (!empty($data))?$data[0]->pajak:"";
      $this->data['total']    =  (!empty($data))?$data[0]->total:"";
    $this->data['harga_packing']    =  (!empty($data))?$data[0]->total_harga_packing:"";
    $this->data['harga_asuransi']    =  (!empty($data))?$data[0]->total_harga_asuransi:"";
    $this->data['grand_total']    =  (!empty($data))?$data[0]->total_harga_global:"";
      $this->data['catatan']    =  (!empty($data))?$data[0]->catatan:"";
        $this->data['spb'] = $spb; 
        $this->data['content'] = 'admin/invoice_cs/detail_v'; 
        $this->data['pelanggan'] = $this->customer_model->getAllById();
        $this->data['data_provinsi'] = $this->wilayah_model->getAllProvince();  

       
        $this->load->view('admin/layouts/page',$this->data); 
      }  
    }   
  } 


 public function create()
  { 
    $this->form_validation->set_rules('id_transaksi',"transaksi tidak boleh kosong", 'trim|required'); 
  $date = date('y-m-d H:i:s');
   $cekNomor = 'INV'.$this->data['users']->id.'-IPV-'.date('d');
   $kode = $this->transaksi_model->getKode(array('id_transaksi' => $cekNomor));
   $nomor = $cekNomor.$kode; 
   $id_pelanggan = $this->input->post('pelanggan');


   $pelanggan = $this->customer_model->getAllById(array('id' =>$id_pelanggan));
 

    if ($this->form_validation->run() === TRUE)
    { 
 

       $data = array (
    'id_transaksi' => $this->input->post('id_transaksi'),
    'vendor' => $this->input->post('vendor'),
    'tipe' => 'j_manifest',
    'tgl_pengajuan' => $this->input->post('tgl_pengajuan'),
    'tgl_jatuh_tempo' => $this->input->post('jatuh_tempo'),
    'posting' => 1,
    'status' => 1,
    'created_by' => $this->input->post('user_input'),
    'created_at' => $this->input->post('waktu_input')
     );  

      $insert = $this->transaksi_model->insert($data); 

      
      if ($insert)
      {
  
   
      

        $no = $this->input->post('id');
        $spb = $this->input->post('spb');
        $tanggal = $this->input->post('tanggal');
        $total_harga_satuan = $this->input->post('total');
        $coli = $this->input->post('coli');
        $kg = $this->input->post('kg');
     
        $order_detail = [];
      
        foreach ($no as $key => $val) {
          if($no[$key] > 0 ){
          $order_detail[] = array(
            'id_transaksi'  =>  $this->input->post('id_transaksi'),
            'SPB'   => $spb[$key],
            'tanggal'   => $tanggal[$key],
            'berat'   => $kg[$key],
            'jumlah_coli'   => $coli[$key],
            'total_harga_satuan'   => $total_harga_satuan[$key],

          );
        }
      }
        $this->db->insert_batch('transaksi_ukuran', $order_detail);

        $this->session->set_flashdata('message', "Invoice Berhasil Dibuat");
        redirect("Transaksi_AllVendor");


      }else{
        $this->session->set_flashdata('message_error', "Invoice Gagal Di Buat");
        redirect("Transaksi_AllVendor","refresh");
      }
    }else{
      if(!empty($_POST)){ 
        $this->session->set_flashdata('message_error',validation_errors());
        return redirect("Transaksi_AllVendor/proses/".$id);  
      }else{


        $this->data['id_transaksi'] =   $nomor;
        $this->data['content'] = 'admin/invoice_allvendor/create_v'; 
        $this->data['data_provinsi'] = $this->wilayah_model->getAllProvince();  
        $this->data['vendor'] = $this->vendor_model->getAllById();  
        $this->data['cs'] = $this->customer_model->getAllById();
       
        $this->load->view('admin/layouts/page',$this->data); 
      }  
    }   
  } 

   function pdf(){

    $id_transaksi = $this->uri->segment(3);
    $data = $this->transaksi_model->getAllById(array("id_transaksi"=>$id_transaksi));
    $pelanggan = $this->vendor_model->getAllById(array('id' =>(!empty($data))?$data[0]->vendor:""));
    $this->data['nama'] =   (!empty($pelanggan))?$pelanggan[0]->nama:"";
   
    $this->data['id_transaksi'] =   (!empty($data))?$data[0]->id_transaksi:"";
    $this->data['tgl_jatuh_tempo']    =   date("d M Y", strtotime((!empty($data))?$data[0]->tgl_jatuh_tempo:""));
    $this->data['tgl_pengajuan']    =   date("d M Y", strtotime((!empty($data))?$data[0]->tgl_pengajuan:""));
   
     $this->data['inv'] =   (!empty($data))?$data[0]->id_transaksi:"";
     $this->data['catatan']    =   (!empty($data))?$data[0]->catatan:"";

     $spb = $this->transaksi_ukuran_model->getAllById(array("id_transaksi"=> $id_transaksi));
    $getSum = $this->transaksi_ukuran_model->getSumAllbyid(array('id_transaksi' => $id_transaksi ));
           $this->data['sub_total'] = (!empty($getSum))?$getSum[0]->total_satuan:"";
         
       



     $this->data['spb'] = $spb; 

     $this->load->library('Pdf');

      $this->pdf->setPaper('A4', 'potrait');
    $this->pdf->filename = "InvoiceCS".date('dmy').".pdf";
    $this->pdf->load_view('admin/invoice_allvendor/cetak_v', $this->data, true);
  
}

 

public function destroy(){
    $response_data = array();
        $response_data['status'] = false;
        $response_data['msg'] = "";
        $response_data['data'] = array();   
    $id =$this->uri->segment(3);
    if(!empty($id)){
          $delete = $this->transaksi_model->delete(array("id_transaksi"=>$id));
          $delete_ukuran = $this->transaksi_ukuran_model->delete(array("id_transaksi"=>$id));
         
          $response_data['data'] = $data; 
          $response_data['status'] = true;
    }else{
      $response_data['msg'] = "ID Harus Diisi";
    }
    
        echo json_encode($response_data); 
  }

}
?>