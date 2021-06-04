<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/Admin_Controller.php';
class Manifest extends Admin_Controller {
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
      $this->data['content'] = 'admin/manifest/list_v';   
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
       $where = array ('tipe' => 'manifest' );
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

             
          $vendorData = $this->vendor_model->getAllByid(array('id' => $data->vendor ));
          $nama_vendor = (!empty($vendorData))?$vendorData[0]->nama:"";
             $posting="";
           
              
               if($this->data['is_can_delete']){
              $action = "<a href='#' 
                  url='".base_url()."Manifest/destroy/".$data->id_transaksi."'
                  class='delete' 
                   ><i class='fa fa-trash'></i>&nbsp;Hapus
                  </a>";
               }else{
        $action = "";
               }

              if($data->posting >= 1){
                $posting = '<i class="fa fa-check-circle"></i> Posted';
              }if($data->posting == 4){
                $posting = '<i class="fa fa-thumbs-up"></i> Selesai';
              }

             
           if($data->status == 2){
                $status = '<i class="fa fa-check-circle"></i> Sudah di proses';
        

              } else if($data->status == 3){
                $status = '<i class="fa fa-check-circle"></i> Sudah di proses';
           
              } else if($data->status == 4){
                $status = '<i class="fa fa-check-circle"></i> Posted';
          
             
              }else{
                $status = '<i class="fa fa-spinner"></i>Belum di proses';
            
              }
              
              $id_transaksi = "<a href='".base_url().$suburl."/detail/".$data->id_transaksi."'><i class='fa fa-search'></i> ".$data->id_transaksi."</a>";  
           
            $nestedData['id']   = $start+$key+1;
            $nestedData['vendor'] = $nama_vendor;
            $nestedData['id_transaksi']  =   $id_transaksi ;

            $nestedData['kirim_via']  = 'Jalur '.$data->kirim_via;
            $nestedData['koli']  = $data->koli;
            $nestedData['kg']  = $data->berat_total;
            $nestedData['asal']  = $data->asal;
            $nestedData['tujuan']  = $data->tujuan;
            $nestedData['posting']  = $posting;
            $nestedData['status']  = $status;
        $nestedData['tanggal']  = date('d-m-Y', strtotime($data->tgl_rilis));

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
        
  $where = array ("tipe" => 'delivery' );
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
            $where['vendor'] = $value;
        }

         if(!empty($this->input->post('periode_start'))){
            $isSearchColumn = true;
            $where["jadwal_delivery >="] = $this->input->post('periode_start');
            $where["jadwal_delivery <="] =  $this->input->post('periode_end');
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

          $vendorData = $this->vendor_model->getAllByid(array('id' => $data->vendor ));
          $nama_vendor = (!empty($vendorData))?$vendorData[0]->nama:"";
             $posting="";
           
            
              

              if($data->posting >= 1){
                   $status = '<i class="fa fa-spinner"></i> Menunggu Konfirmasi';
              }

             
           if($data->status == 2){
               $status = '<i class="fa fa-truck"></i> Selesai';
              $action = "<a href='".base_url().$suburl."/proses/".$data->id_transaksi."'><i class='fa fa-check'></i> Konfirmasi</a>";
              
              }else{
               
                  $status = '<i class="fa fa-spinner"></i> Menunggu Konfirmasi';
                  $action = "<a href='".base_url().$suburl."/proses/".$data->id_transaksi."'><i class='fa fa-check'></i> Konfirmasi</a>";
              }
              
            
           
            $idnya   = $start+$key+1;
  $nestedData['id']  =  "<input type='hidden' class='form-control' id-tr='".$idnya."' name='id[]' value='".$idnya."'>'" ;
 
    $nestedData['id_transaksi']  =  "<input type='text' class='form-control' name='spb[]' value='".$data->id_transaksi."'>" ;
            $nestedData['asal']  = $data->asal;
            $nestedData['kirim_via']  = "<input type='text' class='form-control' name='service[]' value='".$data->kirim_via."'>" ;
            $nestedData['vendor']  = $nama_vendor;
$nestedData['tujuan']  = "<input type='text' class='form-control' name='tujuan[]' value='".$data->tujuan."'>" ;
$nestedData['coli']  = "<input type='text' value='0' class='form-control coli' id='coli' name='coli[]' value=''>" ;
$nestedData['kg']  = "<input type='text' value='0' class='form-control' id='kg' name='kg[]' value=''>" ;
            $nestedData['posting']  = $posting;
            $nestedData['status']  = $status;
            $nestedData['created_at']  = date('d-m-Y H:i:s', strtotime($data->created_at));
            $nestedData['jadwal_pickup']  = date('d-m-Y H:i:s', strtotime($data->jadwal_pickup));
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

 


 public function create()
  { 
    $this->form_validation->set_rules('id_transaksi',"transaksi tidak boleh kosong", 'trim|required'); 
  $date = date('y-m-d H:i:s');
   $cekNomor = 'MNS'.$this->data['users']->id.'-IP-'.date('d');
   $kode = $this->transaksi_model->getKode(array('id_transaksi' => $cekNomor));
   $nomor = $cekNomor.$kode; 
   $id_pelanggan = $this->input->post('pelanggan');


   $pelanggan = $this->customer_model->getAllById(array('id' =>$id_pelanggan));
 

    if ($this->form_validation->run() === TRUE)
    { 
        $periode_start = $this->input->post('periode_start');
        if(!empty($periode_start)){
          $periode_start = $this->input->post('periode_start');
    
        }else{
     $periode_start = date('Y-m-d');
        }

       $data = array (
    'id_transaksi' => $this->input->post('id_transaksi'),
    'asal' => $this->input->post('asal'),
    'tgl_rilis' => $periode_start,
    'vendor' => $this->input->post('vendor'),
    'alamat' => $this->input->post('catatan'),
    'berat_total' => $this->input->post('jkg'),
    'koli' => $this->input->post('jcoli'),
    'tipe' => 'manifest',
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
        $service = $this->input->post('service');
        $asal = $this->input->post('asal');
        $tujuan = $this->input->post('tujuan');
    
        $coli = $this->input->post('coli');
        $kg = $this->input->post('kg');
       
        $order_detail = [];
      
        foreach ($no as $key => $val) {
          if($no[$key] > 0 ){
          $order_detail[] = array(
            'id_transaksi'  =>  $this->input->post('id_transaksi'),
            'SPB'   => $spb[$key],
            'asal'   => $asal,
            'tujuan'   => $tujuan[$key],
            'service'   => $service[$key],
            'berat'   => $kg[$key],
            'jumlah_coli'   => $coli[$key],

          );
        }
      }
        $this->db->insert_batch('transaksi_ukuran', $order_detail);

        $this->session->set_flashdata('message', "Manifest Berhasil Dibuat");
        redirect("Manifest");


      }else{
        $this->session->set_flashdata('message_error', "Manifest Gagal Di Buat");
        redirect("Manifest","refresh");
      }
    }else{
      if(!empty($_POST)){ 
        $this->session->set_flashdata('message_error',validation_errors());
        return redirect("Werehouse/proses/".$id);  
      }else{


        $this->data['id_transaksi'] =   $nomor;
        $this->data['content'] = 'admin/manifest/create_v'; 
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
        $spb = $this->transaksi_ukuran_model->getAllById(array("id_transaksi"=>$id));


        $this->data['id_transaksi'] =   (!empty($data))?$data[0]->id_transaksi:"";
      
        $this->data['status']     =   (!empty($data))?$data[0]->status:""; 
       $this->data['asal']     =   (!empty($data))?$data[0]->asal:""; 
        $this->data['posting']    =   (!empty($data))?$data[0]->posting:"";  
        $this->data['waktu_input']    =   (!empty($data))?$data[0]->created_at:"";
         $this->data['vendorData']    =   (!empty($data))?$data[0]->vendor:"";
        $this->data['tgl_rilis']    =   (!empty($data))?$data[0]->tgl_rilis:"";
        $this->data['coli']    =   (!empty($data))?$data[0]->koli:"";
        $this->data['berat_total']    =   (!empty($data))?$data[0]->berat_total:"";
        $this->data['spb']    =   $spb;
        
        $this->data['content'] = 'admin/manifest/detail_v'; 
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

       function pdf(){

    $id_transaksi = $this->uri->segment(3);
    $data = $this->transaksi_model->getAllById(array("id_transaksi"=>$id_transaksi));
    $pelanggan = $this->vendor_model->getAllById(array('id' =>(!empty($data))?$data[0]->vendor:""));
    $this->data['nama'] =   (!empty($pelanggan))?$pelanggan[0]->nama:"";
     $this->data['tgl_rilis']    =    date("d M Y", strtotime((!empty($data))?$data[0]->tgl_rilis:""));

    $this->data['id_transaksi'] =   (!empty($data))?$data[0]->id_transaksi:"";
    $this->data['tgl_jatuh_tempo']    =   date("d M Y", strtotime((!empty($data))?$data[0]->tgl_jatuh_tempo:""));
    $this->data['tgl_pengajuan']    =   date("d M Y", strtotime((!empty($data))?$data[0]->tgl_pengajuan:""));
     $this->data['asal'] =   (!empty($data))?$data[0]->asal:"";
     $this->data['inv'] =   (!empty($data))?$data[0]->id_transaksi:"";
     $this->data['tujuan'] =   (!empty($data))?$data[0]->tujuan:"";
     $this->data['koli']    =   (!empty($data))?$data[0]->koli:"";
     $this->data['berat_total']    =   (!empty($data))?$data[0]->berat_total:"";
     $this->data['total_harga_packing']    =   (!empty($data))?$data[0]->total_harga_packing:"";
     $this->data['total_harga_asuransi']    =   (!empty($data))?$data[0]->total_harga_asuransi:"";
     $this->data['total']    =   (!empty($data))?$data[0]->total:"";
     $this->data['pajak']    =   (!empty($data))?$data[0]->pajak:"";
     $this->data['keterangan']    =   (!empty($data))?$data[0]->alamat:"";

     $spb = $this->transaksi_ukuran_model->getAllById(array("id_transaksi"=> $id_transaksi));


     $this->data['spb'] = $spb; 

     $this->load->library('Pdf');

      $this->pdf->setPaper('A4', 'potrait');
    $this->pdf->filename = "Manifest".date('dmy').".pdf";
    $this->pdf->load_view('admin/manifest/cetak_v', $this->data, true);
    /*

    $mpdf = new \Mpdf\Mpdf();   

    $html=$this->load->view('admin/invoice/cetak_v', $this->data, true);

    $mpdf->AddPage('P', // L - landscape, P - portrait
            '', '', '', '',
            15, // margin_left
            15, // margin right
            10, // margin top
            10, // margin bottom
            10, // margin header
            10); // margin footer
    $mpdf->WriteHTML($html);
        $mpdf->Output();
    //$this->m_pdf->pdf->Output("./uploads/".$filename, "F");
    //exit;

    */
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