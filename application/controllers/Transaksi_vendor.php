<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/Admin_Controller.php';
class Transaksi_vendor extends Admin_Controller {
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
      $this->data['content'] = 'admin/invoice_vendor/list_v';   
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
           
            
              

              if($data->posting >= 1){
                $posting = '<i class="fa fa-check-circle"></i> Posted';
              }if($data->posting == 4){
                $posting = '<i class="fa fa-thumbs-up"></i> Selesai';
              }

             
           if($data->status == 2){
                $status = '<i class="fa fa-spinner"></i> Selesai di Konfirmasi';
                 if($this->data['is_can_edit']){
         $action = "<a href='".base_url().$suburl."/revisi/".$data->id_transaksi."'><i class='fa fa-check'></i>Revisi</a>&nbsp;&nbsp;&nbsp;<a href='#' 
                  url='".base_url()."Transaksi/selesai/".$data->id_transaksi."'
                  class='selesai' 
                   ><i class='fa fa-check'></i>&nbsp;Selesai
                  </a>";
               }else{
        $action = "";
               }
              

              } else if($data->status == 3){
                $status = '<i class="fa fa-check "></i> Finish';
              $action = "";
              } else if($data->status == 4){
                $status = '<i class="fa fa-check "></i> Finish';
              $action = '';
             
              }else{
                $status = '<i class="fa fa-spinner"></i>Belum di proses';
              if($this->data['is_can_edit']){
         $action = "<a href='".base_url().$suburl."/proses/".$data->id_transaksi."'><i class='fa fa-check'></i>Konfirmasi</a>";
               }else{
        $action = "";
               }
                
              }
              
              $id_transaksi = "<a href='".base_url().$suburl."/detail/".$data->id_transaksi."'><i class='fa fa-search'></i> ".$data->inv_vendor."</a>";  
           
            $nestedData['id']   = $start+$key+1;
            $nestedData['nama'] = $data->nama;
            $nestedData['id_transaksi']  =   $data->id_transaksi ;
             $nestedData['PR']  =   $id_transaksi ;
            $nestedData['telp']  = $data->telp;
            $nestedData['kirim_via']  = 'Jalur '.$data->kirim_via;
            $nestedData['koli']  = $data->koli;
            $nestedData['kg']  = $data->berat_total;
            $nestedData['vendor'] = $nama_vendor;
            $nestedData['asal']  = $data->asal;
            $nestedData['tujuan']  = $data->tujuan;
            $nestedData['posting']  = $posting;
            $nestedData['status']  = $status;
             $nestedData['tanggal']  = date('d-m-Y', strtotime($data->tgl_rilis));
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

 


 public function proses($id)
  { 
    $this->form_validation->set_rules('id_transaksi',"transaksi tidak boleh kosong", 'trim|required'); 
  $date = date('y-m-d H:i:s');
        $cekNomor = 'PR'.$this->data['users']->id.'IP'.date('d');
   $kode = $this->transaksi_model->getKode(array('id_transaksi' => $cekNomor));
   $nomor = $cekNomor.$kode;
   $id_pelanggan = $this->input->post('pelanggan');


   $pelanggan = $this->customer_model->getAllById(array('id' =>$id_pelanggan));
 

    if ($this->form_validation->run() === TRUE)
    { 

        $total1 = str_replace(".","",$this->input->post('total'));
        $total  = str_replace("Rp","",$total1);

         $dataD = array(  
          'inv_vendor' => $this->input->post('kode'),
          'tgl_pengajuan' => $this->input->post('tgl_rilis'),
          'tgl_jatuh_tempo' => $this->input->post('tgl_jatuh_tempo'),
          'catatan' => $this->input->post('catatan'),
          'total' => $total,
          'posting'      => 2,
          'status'       => 2,
          'updated_by'       => $this->input->post('user_input'),

        );
      
     $update = $this->transaksi_model->update($dataD,array("id_transaksi"=>$id));
    
      
      if ($update)
      {
 
        
      $this->transaksi_ukuran_model->delete(array("id_transaksi"=>$id));

        $no = $this->input->post('no');
       
        $harga_coli1 = str_replace(".","",$this->input->post('harga_coli'));
        $harga_coli  = str_replace("Rp","",$harga_coli1);

        $harga_kg1 = str_replace(".","",$this->input->post('harga_kg'));
        $harga_kg  = str_replace("Rp","",$harga_kg1);


        $total_harga1 = str_replace(".","",$this->input->post('total_harga'));
        $total_harga  = str_replace("Rp","",$total_harga1);

       
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
            'asal'   => $asal[$key],
            'tujuan'   => $tujuan[$key],
            'service'   => $service[$key],
            'berat'   => $kg[$key],
            'jumlah_coli'   => $coli[$key],
            'harga_satuan_coli'   => $harga_coli[$key],
            'harga_satuan_kg'   => $harga_kg[$key],
            'total_harga_satuan'   => $total_harga[$key],

          );
        }
      }
        $this->db->insert_batch('transaksi_ukuran', $order_detail);

        $this->session->set_flashdata('message', "Invoice Berhasil Di konfirmasi");
        redirect("Transaksi_vendor");


      }else{
        $this->session->set_flashdata('message_error', "Invoice Gagal Di konfirmasi");
        redirect("Transaksi_vendor","refresh");
      }
    }else{
      if(!empty($_POST)){ 
        $this->session->set_flashdata('message_error',validation_errors());
        return redirect("Transaksi_vendor/proses/".$id);  
      }else{

        $data = $this->transaksi_model->getAllById(array("id_transaksi"=>$id));
      $spb = $this->transaksi_ukuran_model->getAllById(array("id_transaksi"=>$id));

        $this->data['id_transaksi'] =   (!empty($data))?$data[0]->id_transaksi:"";
        $this->data['waktu_input']    =   (!empty($data))?$data[0]->created_at:"";
        $this->data['vendorData']    =   (!empty($data))?$data[0]->vendor:"";
        $this->data['kode']    =  $nomor;
        $this->data['spb'] = $spb; 
        $this->data['content'] = 'admin/invoice_vendor/konfirmasi'; 
        $this->data['pelanggan'] = $this->customer_model->getAllById();
        $this->data['data_provinsi'] = $this->wilayah_model->getAllProvince();  
        $this->data['vendor'] = $this->vendor_model->getAllById();  
       
        $this->load->view('admin/layouts/page',$this->data); 
      }  
    }   
  } 

  public function revisi($id)
  { 
    $this->form_validation->set_rules('id_transaksi',"transaksi tidak boleh kosong", 'trim|required'); 
  $date = date('y-m-d H:i:s');
        $cekNomor = 'PR'.$this->data['users']->id.'IP'.date('d');
   $kode = $this->transaksi_model->getKode(array('id_transaksi' => $cekNomor));
   $nomor = $cekNomor.$kode;
   $id_pelanggan = $this->input->post('pelanggan');


   $pelanggan = $this->customer_model->getAllById(array('id' =>$id_pelanggan));
 

    if ($this->form_validation->run() === TRUE)
    { 

        $total1 = str_replace(".","",$this->input->post('total'));
        $total  = str_replace("Rp","",$total1);

         $dataD = array(  
          'inv_vendor' => $this->input->post('kode'),
          'tgl_pengajuan' => $this->input->post('tgl_rilis'),
          'tgl_jatuh_tempo' => $this->input->post('tgl_jatuh_tempo'),
          'catatan' => $this->input->post('catatan'),
          'total' => $total,
          'posting'      => 2,
          'status'       => 2,
          'updated_by'       => $this->input->post('user_input'),

        );
      
     $update = $this->transaksi_model->update($dataD,array("id_transaksi"=>$id));
    
      
      if ($update)
      {
 
        
      $this->transaksi_ukuran_model->delete(array("id_transaksi"=>$id));

        $no = $this->input->post('no');
       
        $harga_coli1 = str_replace(".","",$this->input->post('harga_coli'));
        $harga_coli  = str_replace("Rp","",$harga_coli1);

        $harga_kg1 = str_replace(".","",$this->input->post('harga_kg'));
        $harga_kg  = str_replace("Rp","",$harga_kg1);


        $total_harga1 = str_replace(".","",$this->input->post('total_harga'));
        $total_harga  = str_replace("Rp","",$total_harga1);

       
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
            'asal'   => $asal[$key],
            'tujuan'   => $tujuan[$key],
            'service'   => $service[$key],
            'berat'   => $kg[$key],
            'jumlah_coli'   => $coli[$key],
            'harga_satuan_coli'   => $harga_coli[$key],
            'harga_satuan_kg'   => $harga_kg[$key],
            'total_harga_satuan'   => $total_harga[$key],

          );
        }
      }
        $this->db->insert_batch('transaksi_ukuran', $order_detail);

        $this->session->set_flashdata('message', "Invoice Berhasil Di revisi");
        redirect("Transaksi_vendor");


      }else{
        $this->session->set_flashdata('message_error', "Invoice Gagal Di revisi");
        redirect("Transaksi_vendor","refresh");
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
        $this->data['vendorData']    =   (!empty($data))?$data[0]->vendor:"";
        $this->data['kode']    =  (!empty($data))?$data[0]->inv_vendor:"";
        $this->data['tgl_pengajuan']    =  (!empty($data))?$data[0]->tgl_pengajuan:"";
      $this->data['tgl_jatuh_tempo']    =  (!empty($data))?$data[0]->tgl_jatuh_tempo:"";
      $this->data['total']    =  (!empty($data))?$data[0]->total:"";
      $this->data['catatan']    =  (!empty($data))?$data[0]->catatan:"";
        $this->data['spb'] = $spb; 
        $this->data['content'] = 'admin/invoice_vendor/revisi_v'; 
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
        return redirect("Transaksi/edit/".$id);  
      }else{

        $data = $this->transaksi_model->getAllById(array("id_transaksi"=>$id));
      $spb = $this->transaksi_ukuran_model->getAllById(array("id_transaksi"=>$id));

        $this->data['id_transaksi'] =   (!empty($data))?$data[0]->id_transaksi:"";
        $this->data['waktu_input']    =   (!empty($data))?$data[0]->created_at:"";
        $this->data['vendorData']    =   (!empty($data))?$data[0]->vendor:"";
        $this->data['kode']    =  (!empty($data))?$data[0]->inv_vendor:"";
        $this->data['tgl_pengajuan']    =  (!empty($data))?$data[0]->tgl_pengajuan:"";
      $this->data['tgl_jatuh_tempo']    =  (!empty($data))?$data[0]->tgl_jatuh_tempo:"";
      $this->data['total']    =  (!empty($data))?$data[0]->total:"";
      $this->data['catatan']    =  (!empty($data))?$data[0]->catatan:"";
        $this->data['spb'] = $spb; 
        $this->data['content'] = 'admin/invoice_vendor/detail_v'; 
        $this->data['pelanggan'] = $this->customer_model->getAllById();
        $this->data['data_provinsi'] = $this->wilayah_model->getAllProvince();  
        $this->data['vendor'] = $this->vendor_model->getAllById();    

       
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
     $this->data['asal'] =   (!empty($data))?$data[0]->asal:"";
     $this->data['inv'] =   (!empty($data))?$data[0]->inv_vendor:"";
     $this->data['tujuan'] =   (!empty($data))?$data[0]->tujuan:"";
     $this->data['total_harga']    =   (!empty($data))?$data[0]->total_harga:"";
     $this->data['total_harga_global']    =   (!empty($data))?$data[0]->total_harga_global:"";
     $this->data['total_harga_packing']    =   (!empty($data))?$data[0]->total_harga_packing:"";
     $this->data['total_harga_asuransi']    =   (!empty($data))?$data[0]->total_harga_asuransi:"";
     $this->data['total']    =   (!empty($data))?$data[0]->total:"";
     $this->data['pajak']    =   (!empty($data))?$data[0]->pajak:"";
     $this->data['catatan']    =   (!empty($data))?$data[0]->catatan:"";

     $spb = $this->transaksi_ukuran_model->getAllById(array("id_transaksi"=> $id_transaksi));


     $this->data['spb'] = $spb; 

     $this->load->library('Pdf');

      $this->pdf->setPaper('A4', 'potrait');
    $this->pdf->filename = "InvoiceVendor".date('dmy').".pdf";
    $this->pdf->load_view('admin/invoice_vendor/cetak_v', $this->data, true);
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

  public function selesai(){
    $response_data = array();
        $response_data['status'] = false;
        $response_data['msg'] = "";
        $response_data['data'] = array();   
    $id =$this->uri->segment(3);
    if(!empty($id)){

        $data = array(  
        'posting'      => 3,
        'status'       => 3,
      );

      $update = $this->transaksi_model->update($data,array("id_transaksi"=>$id)); 
         
          $response_data['data'] = $data; 
          $response_data['status'] = true;
    }else{
      $response_data['msg'] = "ID harus ada";
    }
    
        echo json_encode($response_data); 
  }

}
?>