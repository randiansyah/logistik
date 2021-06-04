<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/Admin_Controller.php';
class Tracking extends Admin_Controller {
  public function __construct()
  {
    parent::__construct();
    $this->load->model('customer_model'); 
    $this->load->model('transaksi_model');
    $this->load->model('transaksi_ukuran_model');
    $this->load->model('wilayah_model');
    $this->load->model('vendor_model');
     $this->load->model('tracking_model');
  }
  public function index()
  {
    $this->load->helper('url');
    if($this->data['is_can_read']){
      $this->data['content'] = 'admin/tracking/list_v';   
       $this->data['pelanggan'] = $this->customer_model->getAllById();  
      $this->data['data_provinsi'] = $this->wilayah_model->getAllProvince(); 
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
            4 => 'asal',
            5 => 'tujuan',
        );

      $order = $columns[$this->input->post('order')[0]['column']];
      $dir = $this->input->post('order')[0]['dir'];
      $search = array();
      $limit = 0;
      $start = 0;
       $where = array ('tipe' => 'delivery' );
  $send = "";   
      $totalData = $this->transaksi_model->getCountAllBy($limit,$start,$search,$order,$dir,$where,$send);       

        $searchColumn = $this->input->post('columns');
        $isSearchColumn = false;

           if(!empty($searchColumn[1]['search']['value'])){
            $value = $searchColumn[1]['search']['value'];
            $isSearchColumn = true;
            $where['kode_pelanggan'] = $value;
        }else{
          $isSearchColumn = false;
        }  

        if(!empty($searchColumn[2]['search']['value'])){
            $value = $searchColumn[2]['search']['value'];
            $isSearchColumn = true;
            $where['id_transaksi'] = $value;
        }else{
$isSearchColumn = false;
        } 
          if(!empty($searchColumn[3]['search']['value'])){
            $value = $searchColumn[3]['search']['value'];
            $isSearchColumn = true;
            $where['jenis_pembayaran'] = $value;
        }else{
$isSearchColumn = false;
        }
          if(!empty($searchColumn[4]['search']['value'])){
            $value = $searchColumn[4]['search']['value'];
            $isSearchColumn = true;
            $where['kirim_via'] = $value;
        }else{
$isSearchColumn = false;
        }
         
        if(!empty($searchColumn[5]['search']['value'])){
            $value = $searchColumn[5]['search']['value'];
            $isSearchColumn = true;
            $where['KDPROP_asal'] = $value;
        }else{
$isSearchColumn = false;
        } 
        if(!empty($searchColumn[6]['search']['value'])){
            $value = $searchColumn[6]['search']['value'];
            $isSearchColumn = true;
            $where['KDKAB_asal'] = $value;
        }else{
$isSearchColumn = false;
        } 
        if(!empty($searchColumn[7]['search']['value'])){
            $value = $searchColumn[7]['search']['value'];
            $isSearchColumn = true;
            $where['KDPROP_tujuan'] = $value;
        }else{
$isSearchColumn = false;
        } 
        if(!empty($searchColumn[8]['search']['value'])){
            $value = $searchColumn[8]['search']['value'];
            $isSearchColumn = true;
            $where['KDKAB_tujuan'] = $value;
        }else{
$isSearchColumn = false;
        } 
      
        

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
          if($this->data['is_can_edit']){
             $action = "<a href='".base_url().$suburl."/proses/".$data->id_transaksi."'><i class='fa fa-check'></i>Input Tracking</a>";
               }else{
        $action = "";
               }
             
          
             $posting="";
             if($data->status == 4){
                $status = '<i class="fa fa-check "></i> Sudah di Terima';
                $action = '<i class="fa fa-check "></i> Sudah di Terima';
              }else{
                $status = '';
              }
              
              $id_transaksi = "<a href='".base_url().$suburl."/detail/".$data->id_transaksi."'><i class='fa fa-search'></i> ".$data->delivery."</a>";  
           
            $nestedData['id']   = $start+$key+1;
            $nestedData['nama'] = $data->nama;
            $nestedData['id_transaksi']  =   $id_transaksi ;
            $nestedData['telp']  = $data->telp;
            $nestedData['asal']  = $data->asal;
            $nestedData['tujuan']  = $data->tujuan;
            $nestedData['posting']  = $posting;
            $nestedData['status']  = $status;
            $nestedData['jadwal_pickup']  = date('d-m-Y H:i:s', strtotime($data->jadwal_pickup));
           $nestedData['jadwal_delivery']  = date('d-m-Y H:i:s', strtotime($data->jadwal_delivery));
            $nestedData['pickup']  = $data->id_transaksi;
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

 public function edit($id)
  { 
    $this->form_validation->set_rules('id_transaksi',"transaksi tidak boleh kosong", 'trim|required'); 
  $date = date('y-m-d H:i:s');

   $dataMAX = $this->transaksi_model->getMAXId($where = array('tipe' => 'transaksi' ));
   $cekNomor = (!empty($dataMAX))?$dataMAX[0]->id_transaksi:"";
    $inv = 'INV';
   $kode = $this->transaksi_model->getKode();
   $nomor = $inv.$kode; 
   $id_pelanggan = $this->input->post('pelanggan');


   $pelanggan = $this->customer_model->getAllById(array('id' =>$id_pelanggan));
 

    if ($this->form_validation->run() === TRUE)
    { 
 


         $dataD = array(  
          'vendor' => $this->input->post('vendor'),
          'jadwal_delivery' => $this->input->post('jadwal_delivery'),
          'posting'      => 2,
          'status'       => 2,
          'updated_by'       => $this->input->post('user_input'),

        );
      
     $update = $this->transaksi_model->update($dataD,array("id_transaksi"=>$id));
    
      
      if ($update)
      {
 
   
      
     

        $this->session->set_flashdata('message', "jadwal Delivery Berhasil Diupdate");
        redirect("Tracking");


      }else{
        $this->session->set_flashdata('message_error', "jadwal Delivery Gagal Diupdate");
        redirect("Tracking","refresh");
      }
    }else{
      if(!empty($_POST)){ 
        $this->session->set_flashdata('message_error',validation_errors());
        return redirect("Tracking/proses/".$id);  
      }else{

        $data = $this->transaksi_model->getAllById(array("id_transaksi"=>$id));
     
        $this->data['delivery'] =   (!empty($data))?$data[0]->delivery:"";
        $this->data['sales'] =   (!empty($data))?$data[0]->created_by:"";
        $this->data['id_transaksi'] =   (!empty($data))?$data[0]->id_transaksi:"";
        $this->data['kode_pelanggan'] =   (!empty($data))?$data[0]->kode_pelanggan:"";
        $this->data['kirim_via'] =   (!empty($data))?$data[0]->kirim_via:"";
        $this->data['jenis_pengiriman'] =   (!empty($data))?$data[0]->jenis_pengiriman:"";
        $this->data['jenis_pembayaran'] =   (!empty($data))?$data[0]->jenis_pembayaran:"";
       
        $this->data['asal'] =   (!empty($data))?$data[0]->asal:"";
        $this->data['KDPROP_asal'] =   (!empty($data))?$data[0]->KDPROP_asal:"";
        $this->data['KDKAB_asal'] =   (!empty($data))?$data[0]->KDKAB_asal:"";
        $this->data['KDPROP_tujuan'] =   (!empty($data))?$data[0]->KDPROP_tujuan:"";
        $this->data['KDKAB_tujuan'] =   (!empty($data))?$data[0]->KDKAB_tujuan:"";
        $this->data['pickup'] =   (!empty($data))?$data[0]->pick_up:"";
        $this->data['alamat'] =   (!empty($data))?$data[0]->alamat:"";
        $this->data['alamat_tujuan'] =   (!empty($data))?$data[0]->alamat_tujuan:"";
        $this->data['status']     =   (!empty($data))?$data[0]->status:""; 
        $this->data['posting']    =   (!empty($data))?$data[0]->posting:"";  
        $this->data['waktu_input']    =   (!empty($data))?$data[0]->created_at:"";
        $this->data['packing']    =   (!empty($data))?$data[0]->packing:"";

        $this->data['jadwal_pickup']    =   date("d M Y - H:i", strtotime((!empty($data))?$data[0]->jadwal_pickup:""));
        
        $this->data['content'] = 'admin/spb_masuk/edit_v'; 
        $this->data['pelanggan'] = $this->customer_model->getAllById();
        $this->data['data_provinsi'] = $this->wilayah_model->getAllProvince();  
        $this->data['vendor'] = $this->vendor_model->getAllById();  
       
        $this->load->view('admin/layouts/page',$this->data); 
      }  
    }   
  } 


 public function proses($id)
  { 
    $this->form_validation->set_rules('id_transaksi',"transaksi tidak boleh kosong", 'trim|required'); 
  $date = date('y-m-d H:i:s');
   $id_pelanggan = $this->input->post('pelanggan');


   $pelanggan = $this->customer_model->getAllById(array('id' =>$id_pelanggan));

    if ($this->form_validation->run() === TRUE)
    { 
    $id = $this->input->post('id_transaksi');
    $status_pengiriman =  $this->input->post('status_pengiriman');

 if($status_pengiriman == "Selesai"){
      $statusA = $this->input->post('pengiriman');
        }else{
$statusA = $this->input->post('status_pengiriman');

        }


        $dataD = array(  
          'id_transaksi' => $this->input->post('id_transaksi'),
          'tanggal' => $this->input->post('tanggal'),
          'status_pengiriman' => $statusA,
          'pengiriman' => $this->input->post('pengiriman'),
         'nama' => (!empty($pelanggan))?$pelanggan[0]->nama:"",
          'email' => (!empty($pelanggan))?$pelanggan[0]->email:"",
          'created_at'       => date('y-m-d'),
          'created_by'       => $this->input->post('user_input'),

        );   
     $insert = $this->tracking_model->insert($dataD); 
    
      
      if ($insert)
      {

        
        if($status_pengiriman == "Selesai"){
$dataD = array(  
          'posting'      => 4,
          'status'       => 4,
        );
      
     $update = $this->transaksi_model->update($dataD,array("id_transaksi"=>$id));
        }else{
          
        }

            
 

        $this->session->set_flashdata('message', "Tracking Berhasil di Simpan");
        redirect("Tracking");


      }else{
        $this->session->set_flashdata('message_error', "Tracking gagal dibuat");
        redirect("Tracking","refresh");
      }
    }else{
      if(!empty($_POST)){ 
        $this->session->set_flashdata('message_error',validation_errors());
        return redirect("Tracking/proses/".$id);  
      }else{

        $data = $this->transaksi_model->getAllById(array("id_transaksi"=>$id));
      $tracking = $this->tracking_model->getAllById(array("id_transaksi"=>$id));

        $this->data['delivery'] =   (!empty($data))?$data[0]->delivery:"";
        $this->data['sales'] =   (!empty($data))?$data[0]->created_by:"";
        $this->data['id_transaksi'] =   (!empty($data))?$data[0]->id_transaksi:"";
        $this->data['kode_pelanggan'] =   (!empty($data))?$data[0]->kode_pelanggan:"";
        $this->data['kirim_via'] =   (!empty($data))?$data[0]->kirim_via:"";
        $this->data['jenis_pengiriman'] =   (!empty($data))?$data[0]->jenis_pengiriman:"";
        $this->data['jenis_pembayaran'] =   (!empty($data))?$data[0]->jenis_pembayaran:"";
       
        $this->data['asal'] =   (!empty($data))?$data[0]->asal:"";
        $this->data['KDPROP_asal'] =   (!empty($data))?$data[0]->KDPROP_asal:"";
        $this->data['KDKAB_asal'] =   (!empty($data))?$data[0]->KDKAB_asal:"";
        $this->data['KDPROP_tujuan'] =   (!empty($data))?$data[0]->KDPROP_tujuan:"";
        $this->data['KDKAB_tujuan'] =   (!empty($data))?$data[0]->KDKAB_tujuan:"";
        $this->data['pickup'] =   (!empty($data))?$data[0]->pick_up:"";
        $this->data['alamat'] =   (!empty($data))?$data[0]->alamat:"";
        $this->data['alamat_tujuan'] =   (!empty($data))?$data[0]->alamat_tujuan:"";
        $this->data['status']     =   (!empty($data))?$data[0]->status:""; 
        $this->data['posting']    =   (!empty($data))?$data[0]->posting:"";  
        $this->data['waktu_input']    =   (!empty($data))?$data[0]->created_at:"";
        $this->data['packing']    =   (!empty($data))?$data[0]->packing:"";

        $this->data['jadwal_delivery']    =   date("d M Y - H:i", strtotime((!empty($data))?$data[0]->jadwal_delivery:""));
        $this->data['tracking'] = $tracking; 
        
        $this->data['content'] = 'admin/tracking/konfirmasi'; 
        $this->data['pelanggan'] = $this->customer_model->getAllById();
        $this->data['data_provinsi'] = $this->wilayah_model->getAllProvince();  
        $this->data['vendor'] = $this->vendor_model->getAllById();  
       
        $this->load->view('admin/layouts/page',$this->data); 
      }  
    }   
  } 
public function detail($id)
  { 
    $this->form_validation->set_rules('id_transaksi',"transaksi tidak boleh kosong", 'trim|required'); 
$this->form_validation->set_rules('pelanggan',"pelanggan tidak boleh kosong", 'trim|required'); 
   $date = date('y-m-d H:i:s');
   $kode = $this->transaksi_model->getKode();

   $id_pelanggan = $this->input->post('pelanggan');

   $pelanggan = $this->customer_model->getAllById(array('id' =>$id_pelanggan));

    if ($this->form_validation->run() === TRUE)
    { 
      $this->tracking_model->delete(array("id_transaksi"=>$id));

       $no = $this->input->post('no');
      $tanggal = $this->input->post('tanggal');
      $status_pengiriman = $this->input->post('status_pengiriman');
      $pengiriman = $this->input->post('pengiriman');

       $data= [] ;

       foreach ($no as $key => $val) {
         if($no[$key] > 0){
        $data[] = array
        (
          'id_transaksi' => $id, 
          'tanggal' => $tanggal[$key],
          'status_pengiriman' => $status_pengiriman[$key],
          'pengiriman' => $pengiriman[$key],
          'nama' => (!empty($pelanggan))?$pelanggan[0]->nama:"",
          'email' => (!empty($pelanggan))?$pelanggan[0]->email:"",
          'created_at'       => date('y-m-d'),
          'created_by'       => $this->input->post('user_input'),
          );
         }
       }


      $update = $this->db->insert_batch('tracking',$data); 
      
      if ($update)
      {
        
        $this->session->set_flashdata('message', "Tracking Berhasil di Ubah");
        redirect("Tracking");
      }else{
        $this->session->set_flashdata('message_error', "Tracking Berhasil Gagal Diubah");
        redirect("Tracking","refresh");
      }
    }else{
      if(!empty($_POST)){ 
        $this->session->set_flashdata('message_error',validation_errors());
        return redirect("Pickup/edit/".$id);  
      }else{

        $data = $this->transaksi_model->getAllById(array("id_transaksi"=>$id));
       $tracking = $this->tracking_model->getAllById(array("id_transaksi"=>$id));

         $this->data['delivery'] =   (!empty($data))?$data[0]->delivery:"";
        $this->data['id_transaksi'] =   (!empty($data))?$data[0]->id_transaksi:"";
        $this->data['kode_pelanggan'] =   (!empty($data))?$data[0]->kode_pelanggan:"";
        $this->data['kode_vendor'] =   (!empty($data))?$data[0]->vendor:"";
        $this->data['kirim_via'] =   (!empty($data))?$data[0]->kirim_via:"";
        $this->data['jenis_pengiriman'] =   (!empty($data))?$data[0]->jenis_pengiriman:"";
        $this->data['jenis_pembayaran'] =   (!empty($data))?$data[0]->jenis_pembayaran:"";
           $this->data['asal'] =   (!empty($data))?$data[0]->asal:"";
        $this->data['KDPROP_asal'] =   (!empty($data))?$data[0]->KDPROP_asal:"";
        $this->data['KDKAB_asal'] =   (!empty($data))?$data[0]->KDKAB_asal:"";
        $this->data['KDPROP_tujuan'] =   (!empty($data))?$data[0]->KDPROP_tujuan:"";
        $this->data['KDKAB_tujuan'] =   (!empty($data))?$data[0]->KDKAB_tujuan:"";
        $this->data['pickup'] =   (!empty($data))?$data[0]->pick_up:"";
        $this->data['alamat'] =   (!empty($data))?$data[0]->alamat:"";
        $this->data['alamat_tujuan'] =   (!empty($data))?$data[0]->alamat_tujuan:"";
        $this->data['status']     =   (!empty($data))?$data[0]->status:""; 
        $this->data['posting']    =   (!empty($data))?$data[0]->posting:"";  
        $this->data['waktu_input']    =   (!empty($data))?$data[0]->created_at:"";
        $this->data['packing']    =   (!empty($data))?$data[0]->packing:"";
        $this->data['total_harga']    =   (!empty($data))?$data[0]->total_harga:"";
        $this->data['total_harga_global']    =   (!empty($data))?$data[0]->total_harga_global:"";
         $this->data['total_harga_packing']    =   (!empty($data))?$data[0]->total_harga_packing:"";
    $this->data['total_harga_asuransi']    =   (!empty($data))?$data[0]->total_harga_asuransi:"";
  $this->data['total_harga']    =   (!empty($data))?$data[0]->total_harga:"";
  $this->data['total']    =   (!empty($data))?$data[0]->total:"";
  $this->data['pajak']    =   (!empty($data))?$data[0]->pajak:"";
        $this->data['jadwal_delivery']    =   date("d M Y - H:i", strtotime((!empty($data))?$data[0]->jadwal_delivery:""));
        $this->data['tracking'] = $tracking; 
        
        $this->data['content'] = 'admin/tracking/detail_v'; 
        $this->data['pelanggan'] = $this->customer_model->getAllById();
        $this->data['data_provinsi'] = $this->wilayah_model->getAllProvince();  
        $this->data['vendor'] = $this->vendor_model->getAllById();    

       
        $this->load->view('admin/layouts/page',$this->data); 
      }  
    }   
  } 
  public function exportCSV()
    { 
       // file name 
       $filename = 'Pelanggan'.date('Ymd').'.csv'; 
       header("Content-Description: File Transfer"); 
       header("Content-Disposition: attachment; filename=$filename"); 
       header("Content-Type: application/csv; ");
       
       // get data 
       
       $datas = $this->customer_model->getAllById();

       // file creation 
       $file = fopen('php://output', 'w');
     
       $header = array("ID CUSTOMER","NAMA","EMAIL","JENIS KELAMIN","TELPON","ALAMAT"); 
       fputcsv($file, $header);
       foreach ($datas as $line){ 
         fputcsv($file,array($line->id_customer,$line->nama,$line->email,$line->jk,$line->telp,$line->alamat));
       }
       fclose($file); 
       exit; 
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