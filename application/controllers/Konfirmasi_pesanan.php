<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/Admin_Controller.php';
class Konfirmasi_pesanan extends Admin_Controller {
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
      $this->data['content'] = 'admin/konfirmasi_pesanan/list_v';   
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
            4 => 'kirim_via',
            5 => 'asal',
            6 => 'tujuan',
        );

      $order = $columns[$this->input->post('order')[0]['column']];
      $dir = $this->input->post('order')[0]['dir'];
      $search = array();
      $limit = 0;
      $start = 0;
        
  $where = array ("tipe" => 'delivery' );
  $send = "status IN ('3','4')";    
      $totalData = $this->transaksi_model->getCountAllBy($limit,$start,$search,$order,$dir,$where,$where);       

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
        $totalFiltered = $this->transaksi_model->getCountAllBy($limit,$start,$search,$order,$dir,$where); 
      }else{
        $totalFiltered = $totalData;
      }  
       
    $limit = $this->input->post('length');
    $start = $this->input->post('start');
     


    $datas = $this->transaksi_model->getAllByOR($limit,$start,$search,$order,$dir,$where,$send);
    $suburl = $this->uri->segment(1);
     
        $new_data = array();
        if(!empty($datas))
        {
            foreach ($datas as $key=>$data)
            {   

             
          
             $posting="";
           
             if($this->data['is_can_edit']){
             $action = "<a href='".base_url().$suburl."/proses/".$data->id_transaksi."'><i class='fa fa-check'></i>Terima </a>";
               }else{
        $action = "";
               }
              

              if($data->posting >= 1){
                $posting = '<i class="fa fa-check-circle"></i> Posted';
              }if($data->posting == 4){
                $posting = '<i class="fa fa-thumbs-up"></i> Selesai';
            if($this->data['is_superadmin']){
             $action = "<a href='".base_url().$suburl."/batal/".$data->id_transaksi."'><i class='fa fa-check'></i>Batalkan penerimaan </a>";
               }else{
        $action = "";
               }

              }

             
           if($data->status == 2){
                $status = '<i class="fa fa-spinner"></i> Menunggu Konfirmasi';
     

              } else if($data->status == 3){
                $status = '<i class="fa fa-truck "></i> Dalam Pengiriman';

              
             
             }else if($data->status == 4){
                $status = '<i class="fa fa-check"></i> Selesai';
        
              
             
              }else{
                $status = '<i class="fa fa-spinner"></i>Belum di proses';
               
              }
              
              $id_transaksi = "<a href='".base_url().$suburl."/detail/".$data->id_transaksi."'><i class='fa fa-search'></i> ".$data->delivery."</a>";  
           
            $nestedData['id']   = $start+$key+1;
            $nestedData['nama'] = $data->nama;
            $nestedData['id_transaksi']  =   $id_transaksi ;
            $nestedData['telp']  = $data->telp;
            $nestedData['kirim_via']  = 'Jalur '.$data->kirim_via;
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

 


 public function proses($id)
  { 
    $this->form_validation->set_rules('id_transaksi',"transaksi tidak boleh kosong", 'trim|required'); 
  $date = date('y-m-d H:i:s');
  
   $id_pelanggan = $this->input->post('pelanggan');


   $pelanggan = $this->customer_model->getAllById(array('id' =>$id_pelanggan));
 

    if ($this->form_validation->run() === TRUE)
    { 
 //update data delivery
      $total_harga1 = str_replace(".","",$this->input->post('harga_bayar'));
      $total_harga  = str_replace("Rp","",$total_harga1);

         $dataD = array(  
          'posting'      => 4,
          'status'       => 4,
        );
      
     $update = $this->transaksi_model->update($dataD,array("id_transaksi"=>$id));
    
      
      if ($update)
      {
  
 
        $this->session->set_flashdata('message', "Pesanan Berhasil di terima");
        redirect("Konfirmasi_pesanan");


      }else{
        $this->session->set_flashdata('message_error', "Pesanan Gagal di terima");
        redirect("Konfirmasi_pesanan","refresh");
      }
    }else{
      if(!empty($_POST)){ 
        $this->session->set_flashdata('message_error',validation_errors());
        return redirect("Konfirmasi_pesanan/proses/".$id);  
      }else{

        $data = $this->transaksi_model->getAllById(array("id_transaksi"=>$id));
      $barang = $this->transaksi_ukuran_model->getAllById(array("id_transaksi"=>$id));

      $this->data['delivery'] =   (!empty($data))?$data[0]->delivery:"";
        $this->data['id_transaksi'] =   (!empty($data))?$data[0]->id_transaksi:"";
        $this->data['kode_pelanggan'] =   (!empty($data))?$data[0]->kode_pelanggan:"";
        $this->data['kode_vendor'] =   (!empty($data))?$data[0]->vendor:"";
        $this->data['kirim_via'] =   (!empty($data))?$data[0]->kirim_via:"";
        $this->data['jenis_pengiriman'] =   (!empty($data))?$data[0]->jenis_pengiriman:"";
        $this->data['jenis_pembayaran'] =   (!empty($data))?$data[0]->jenis_pembayaran:"";
        $this->data['catatan'] =   (!empty($data))?$data[0]->catatan:"";
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
        $this->data['jadwal_pickup']    =   date("d M Y - H:i", strtotime((!empty($data))?$data[0]->jadwal_pickup:""));
         $this->data['jadwal_delivery']    =   date("d M Y - H:i", strtotime((!empty($data))?$data[0]->jadwal_delivery:""));
        $this->data['barang'] = $barang; 
        
        $this->data['content'] = 'admin/konfirmasi_pesanan/konfirmasi'; 
        $this->data['pelanggan'] = $this->customer_model->getAllById();
        $this->data['data_provinsi'] = $this->wilayah_model->getAllProvince();  
        $this->data['vendor'] = $this->vendor_model->getAllById();   
       
        $this->load->view('admin/layouts/page',$this->data); 
      }  
    }   
  } 


  public function batal($id)
  { 
    $this->form_validation->set_rules('id_transaksi',"transaksi tidak boleh kosong", 'trim|required'); 
  $date = date('y-m-d H:i:s');
  
   $id_pelanggan = $this->input->post('pelanggan');


   $pelanggan = $this->customer_model->getAllById(array('id' =>$id_pelanggan));
 

    if ($this->form_validation->run() === TRUE)
    { 
 //update data delivery
      $total_harga1 = str_replace(".","",$this->input->post('harga_bayar'));
      $total_harga  = str_replace("Rp","",$total_harga1);

         $dataD = array(  
          'posting'      => 3,
          'status'       => 3,
        );
      
     $update = $this->transaksi_model->update($dataD,array("id_transaksi"=>$id));
    
      
      if ($update)
      {
  
 
        $this->session->set_flashdata('message', "Pesanan Berhasil di di Batalkan");
        redirect("Konfirmasi_pesanan");


      }else{
        $this->session->set_flashdata('message_error', "Pesanan Gagal di Batalkan");
        redirect("Konfirmasi_pesanan","refresh");
      }
    }else{
      if(!empty($_POST)){ 
        $this->session->set_flashdata('message_error',validation_errors());
        return redirect("Konfirmasi_pesanan/proses/".$id);  
      }else{

        $data = $this->transaksi_model->getAllById(array("id_transaksi"=>$id));
      $barang = $this->transaksi_ukuran_model->getAllById(array("id_transaksi"=>$id));

      $this->data['delivery'] =   (!empty($data))?$data[0]->delivery:"";
        $this->data['id_transaksi'] =   (!empty($data))?$data[0]->id_transaksi:"";
        $this->data['kode_pelanggan'] =   (!empty($data))?$data[0]->kode_pelanggan:"";
        $this->data['kode_vendor'] =   (!empty($data))?$data[0]->vendor:"";
        $this->data['kirim_via'] =   (!empty($data))?$data[0]->kirim_via:"";
        $this->data['jenis_pengiriman'] =   (!empty($data))?$data[0]->jenis_pengiriman:"";
        $this->data['jenis_pembayaran'] =   (!empty($data))?$data[0]->jenis_pembayaran:"";
        $this->data['catatan'] =   (!empty($data))?$data[0]->catatan:"";
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
        $this->data['jadwal_pickup']    =   date("d M Y - H:i", strtotime((!empty($data))?$data[0]->jadwal_pickup:""));
         $this->data['jadwal_delivery']    =   date("d M Y - H:i", strtotime((!empty($data))?$data[0]->jadwal_delivery:""));
        $this->data['barang'] = $barang; 
        
        $this->data['content'] = 'admin/konfirmasi_pesanan/konfirmasi'; 
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
      $data = array(  
        'posting'      => 1,
        'status'       => 1,
      );

      $update = $this->transaksi_model->update($data,array("id_transaksi"=>$id)); 
      
      if ($update)
      {
        $this->transaksi_ukuran_model->delete(array("id_transaksi"=>$id));
        
        $ukuran = array(
        'id_transaksi' => $this->input->post('id_transaksi'),
        'panjang' => $this->input->post('panjang'),
        'lebar' => $this->input->post('lebar'),
        'tinggi' => $this->input->post('tinggi'),

       );

        $insert_ukuran = $this->transaksi_ukuran_model->insert($ukuran);

        $this->session->set_flashdata('message', "Pesanan Baru Berhasil di posting");
        redirect("Pesanan");
      }else{
        $this->session->set_flashdata('message_error', "Pesanan Baru Gagal Diposting");
        redirect("Pesanan","refresh");
      }
    }else{
      if(!empty($_POST)){ 
        $this->session->set_flashdata('message_error',validation_errors());
        return redirect("Pickup/edit/".$id);  
      }else{

        $data = $this->transaksi_model->getAllById(array("id_transaksi"=>$id));
        $barang = $this->transaksi_ukuran_model->getAllById(array("id_transaksi"=>$id));


         $this->data['delivery'] =   (!empty($data))?$data[0]->delivery:"";
        $this->data['id_transaksi'] =   (!empty($data))?$data[0]->id_transaksi:"";
        $this->data['kode_pelanggan'] =   (!empty($data))?$data[0]->kode_pelanggan:"";
        $this->data['kode_vendor'] =   (!empty($data))?$data[0]->vendor:"";
        $this->data['kirim_via'] =   (!empty($data))?$data[0]->kirim_via:"";
        $this->data['jenis_pengiriman'] =   (!empty($data))?$data[0]->jenis_pengiriman:"";
        $this->data['jenis_pembayaran'] =   (!empty($data))?$data[0]->jenis_pembayaran:"";
        $this->data['catatan'] =   (!empty($data))?$data[0]->catatan:"";
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
        $this->data['jadwal_pickup']    =   date("d M Y - H:i", strtotime((!empty($data))?$data[0]->jadwal_pickup:""));
         $this->data['jadwal_delivery']    =   date("d M Y - H:i", strtotime((!empty($data))?$data[0]->jadwal_delivery:""));
        $this->data['barang'] = $barang; 
        
        $this->data['content'] = 'admin/konfirmasi_pesanan/detail_v'; 
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