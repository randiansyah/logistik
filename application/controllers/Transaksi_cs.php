<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/Admin_Controller.php';
class Transaksi_cs extends Admin_Controller {
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
      $this->data['content'] = 'admin/invoice_cs/list_v';  

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
       $where = array ('tipe' => 'j_transaksi' );
  $send = "";   
      $totalData = $this->transaksi_model->getCountAllBy($limit,$start,$search,$order,$dir,$where,$send);       

        $searchColumn = $this->input->post('columns');
        $isSearchColumn = false;

          if(!empty($searchColumn[1]['search']['value'])){
            $value = $searchColumn[1]['search']['value'];
            $isSearchColumn = true;
            $where['kode_pelanggan'] = $value;
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

             
          $vendorData = $this->customer_model->getAllByid(array('id' => $data->kode_pelanggan ));
          $nama_vendor = (!empty($vendorData))?$vendorData[0]->nama:"";
             $posting="";
           
              if($this->data['is_can_delete']){
         $action1 = "<a href='#' 
                  url='".base_url()."Transaksi_cs/destroy/".$data->id_transaksi."'
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
                  $action = "<a href='".base_url().$suburl."/pdf/".$data->id_transaksi."'><i class='fa fa-check' target='blank'></i>Print</a>&nbsp;&nbsp;&nbsp;".$action1;
              }
              
              $id_transaksi = "<a href='#'><i class='fa fa-search'></i> ".$data->id_transaksi."</a>";  
           
            $nestedData['id']   = $start+$key+1;
            $nestedData['vendor'] = $nama_vendor;
            $nestedData['id_transaksi']  =   $id_transaksi ;

            $nestedData['jenis_pembayaran']  = $data->jenis_pembayaran;
            $nestedData['kirim_via']  = 'Jalur '.$data->kirim_via;
            $nestedData['koli']  = $data->koli;
            $nestedData['kg']  = $data->berat_total;
            $nestedData['asal']  = $data->asal;
            $nestedData['tujuan']  = $data->tujuan;
            $nestedData['posting']  = $posting;
            $nestedData['status']  = $status;
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
            8 => '',
            9 => '',
            10 => '',
    
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
            $where['kode_pelanggan'] = $value;
        }

         if(!empty($this->input->post('periode_start'))){
            $isSearchColumn = true;
            $periode_start = date("Y-m-d",strtotime($this->input->post('periode_start')));
            $periode_end = date("Y-m-d",strtotime($this->input->post('periode_end')));
            $where["jadwal_delivery >="] = $periode_start;
            $where["jadwal_delivery <="] =  $periode_end;
        }   
        if(!empty($searchColumn[4]['search']['value'])){
            $value = $searchColumn[4]['search']['value'];
            $isSearchColumn = true;
            $where['jenis_pembayaran'] = $value;
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

    $getSum = $this->transaksi_ukuran_model->getSumAllbyid(array('id_transaksi' => $data->id_transaksi ));
          $jumlah = (!empty($getSum))?$getSum[0]->qty:"";
          $satuan = (!empty($getSum))?$getSum[0]->satuan:"";
          $total_satuan = (!empty($getSum))?$getSum[0]->total_satuan:"";
          $packing = (!empty($getSum))?$getSum[0]->packing:"";
          $asuransi = (!empty($getSum))?$getSum[0]->asuransi:"";
             $posting="";
           
            
    $getName = $this->customer_model->getAllByid(array('id' => $data->kode_pelanggan));
    $namanya = (!empty($getName))?$getName[0]->nama:""; 
    $getjenis = $this->transaksi_model->getAllByid(array('id_transaksi' => $data->id_transaksi));
    $jenis_bayar = (!empty($getjenis))?$getjenis[0]->jenis_pembayaran:""; 

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
 
  
   $nestedData['id']  =  "<input type='text' style='width:35px;' class='form-control' id-tr='".$idnya."' name='id[]' value='".$idnya."'>" ;

    $nestedData['nama']  =  "<input type='text'  class='form-control' name='kode_pelanggan[]' value='".$namanya."'>" ;

     $nestedData['jenis']  =  "<input type='text'  class='form-control' name='jenis_bayar[]' value='".$jenis_bayar."'>" ;
 
    $nestedData['id_transaksi']  =  "<input type='text' class='form-control' name='spb[]' value='".$data->id_transaksi."'>" ;
            $nestedData['asal']  = "<input type='text' class='form-control' name='asal[]' value='".$data->asal."'>" ;
             $nestedData['tanggal']  = "<input type='text' class='form-control' name='jadwal_delivery[]' value='".$data->jadwal_delivery."'>" ;

            $nestedData['kirim_via']  = "<input type='text' class='form-control' name='service[]' value='".$data->kirim_via."'>" ;
         
$nestedData['tujuan']  = "<input type='text' class='form-control' name='tujuan[]' value='".$data->tujuan."'>" ;
$nestedData['qty']  = "<input type='text' class='form-control' id='jumlah' name='jumlah[]' value='".$jumlah."'>" ;
$nestedData['satuan']  = "<input type='text' class='form-control harga' name='harga_satuan[]' value='".$satuan."'>" ;
$nestedData['total_satuan']  = "<input type='text' class='form-control' name='total_harga_satuan[]' value='".$total_satuan."'>" ;

$nestedData['packing']  = "<input type='text' class='form-control' name='harga_packing[]' value='".$data->total_harga_packing."'>" ;
$nestedData['asuransi']  = "<input type='text' class='form-control' name='harga_asuransi[]' value='".$data->total_harga_asuransi."'>" ;
$nestedData['cetak']  = "<input type='checkbox' name='ceklist[".$idnya."]' class='checkItem flat' value='".$idnya."'> " ;

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



   public function konfirmasi($id)
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

      //total harga global
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
        $harga_satuan1 = str_replace(".","",$this->input->post('harga_satuan'));
        $harga_satuan  = str_replace("Rp","",$harga_satuan1);


        $total_harga1 = str_replace(".","",$this->input->post('total_harga'));
        $total_harga  = str_replace("Rp","",$total_harga1);

       
        $spb = $this->input->post('spb');
        $service = $this->input->post('service');
        $asal = $this->input->post('asal');
        $tujuan = $this->input->post('tujuan');
        $opsi_satuan = $this->input->post('opsi_satuan');
        $tanggal = $this->input->post('jadwal_delivery');
        $coli = $this->input->post('coli');
        $kg = $this->input->post('kg');
       
        $order_detail = [];
      
        foreach ($no as $key => $val) {
          if($no[$key] > 0 ){
          $order_detail[] = array(
            'id_transaksi'  =>  $this->input->post('id_transaksi'),
            'SPB'   => $spb[$key],
            'tanggal'   => $tanggal[$key],
            'asal'   => $asal[$key],
            'tujuan'   => $tujuan[$key],
            'service'   => $service[$key],
            'berat_total'   => $kg[$key],
            'jumlah_coli'   => $coli[$key],
            'harga_satuan'   => $harga_satuan[$key],
            'opsi_satuan'   => $opsi_satuan[$key],
            'total_harga_satuan'   => $total_harga[$key],

          );
        }
      }
        $this->db->insert_batch('transaksi_ukuran', $order_detail);

        $this->session->set_flashdata('message', "Harga Berhasil diinput");
        redirect("Transaksi_cs");


      }else{
        $this->session->set_flashdata('message_error', "Harga Gagal Di input");
        redirect("Transaksi_cs","refresh");
      }
    }else{
      if(!empty($_POST)){ 
        $this->session->set_flashdata('message_error',validation_errors());
        return redirect("Transaksi_cs/konfirmasi/".$id);  
      }else{

        $data = $this->transaksi_model->getAllById(array("id_transaksi"=>$id));
      $spb = $this->transaksi_ukuran_model->getAllById(array("id_transaksi"=>$id));

        $this->data['id_transaksi'] =   (!empty($data))?$data[0]->id_transaksi:"";
        $this->data['waktu_input']    =   (!empty($data))?$data[0]->created_at:"";
        $this->data['vendorData']    =   (!empty($data))?$data[0]->kode_pelanggan:"";
        $this->data['kode']    =  (!empty($data))?$data[0]->inv_vendor:"";
        $this->data['created_at']    =  (!empty($data))?$data[0]->created_at:"";

      $this->data['total']    =  (!empty($data))?$data[0]->total:"";
      $this->data['catatan']    =  (!empty($data))?$data[0]->catatan:"";
        $this->data['spb'] = $spb; 
        $this->data['content'] = 'admin/invoice_cs/konfirmasi_v'; 
        $this->data['pelanggan'] = $this->customer_model->getAllById();
        $this->data['data_provinsi'] = $this->wilayah_model->getAllProvince();  

       
        $this->load->view('admin/layouts/page',$this->data); 
      }  
    }   
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
        $harga_satuan1 = str_replace(".","",$this->input->post('harga_satuan'));
        $harga_satuan  = str_replace("Rp","",$harga_satuan1);


        $total_harga1 = str_replace(".","",$this->input->post('total_harga'));
        $total_harga  = str_replace("Rp","",$total_harga1);

       
        $spb = $this->input->post('spb');
        $service = $this->input->post('service');
        $asal = $this->input->post('asal');
        $tujuan = $this->input->post('tujuan');
        $opsi_satuan = $this->input->post('opsi_satuan');
    
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
            'berat_total'   => $kg[$key],
            'jumlah_coli'   => $coli[$key],
            'harga_satuan'   => $harga_satuan[$key],
            'opsi_satuan'   => $opsi_satuan[$key],
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


 public function revisi($id)
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
        $harga_satuan1 = str_replace(".","",$this->input->post('harga_satuan'));
        $harga_satuan  = str_replace("Rp","",$harga_satuan1);


        $total_harga1 = str_replace(".","",$this->input->post('total_harga'));
        $total_harga  = str_replace("Rp","",$total_harga1);

       
        $spb = $this->input->post('spb');
        $service = $this->input->post('service');
        $asal = $this->input->post('asal');
        $tujuan = $this->input->post('tujuan');
        $opsi_satuan = $this->input->post('opsi_satuan');
     $tanggal = $this->input->post('jadwal_delivery');
        $coli = $this->input->post('coli');
        $kg = $this->input->post('kg');
       
        $order_detail = [];
      
        foreach ($no as $key => $val) {
          if($no[$key] > 0 ){
          $order_detail[] = array(
            'id_transaksi'  =>  $this->input->post('id_transaksi'),
            'SPB'   => $spb[$key],
            'tanggal'   => $tanggal[$key],
            'asal'   => $asal[$key],
            'tujuan'   => $tujuan[$key],
            'service'   => $service[$key],
            'berat_total'   => $kg[$key],
            'jumlah_coli'   => $coli[$key],
            'harga_satuan'   => $harga_satuan[$key],
            'opsi_satuan'   => $opsi_satuan[$key],
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
        $this->data['content'] = 'admin/invoice_cs/revisi_v'; 
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
   $cekNomor = 'INV'.$this->data['users']->id.'-IP-'.date('d');
   $kode = $this->transaksi_model->getKode(array('id_transaksi' => $cekNomor));
   $nomor = $cekNomor.$kode; 
   $id_pelanggan = $this->input->post('pelanggan');


   $pelanggan = $this->customer_model->getAllById(array('id' =>$id_pelanggan));
 
 $tgl_jatuh_tempo = date("Y-m-d",strtotime($this->input->post('jatuh_tempo')));
    if ($this->form_validation->run() === TRUE)
    { 
 

       $data = array (
    'id_transaksi' => $this->input->post('id_transaksi'),
    'kode_pelanggan' => $this->input->post('vendor'),
    'tipe' => 'j_transaksi',
    'tgl_jatuh_tempo' => $tgl_jatuh_tempo,
    'pajak' => $this->input->post('pajak'),
    'jenis_pembayaran' => $this->input->post('jenis_pembayaran'),
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
        $tanggal = $this->input->post('jadwal_delivery');

       // $date= date("Y-m-d",strtotime($tanggal));
    
        $jumlah = $this->input->post('jumlah');
        $harga_satuan = $this->input->post('harga_satuan');
        $total_harga_satuan = $this->input->post('total_harga_satuan');
        $harga_packing = $this->input->post('harga_packing');
        $harga_asuransi = $this->input->post('harga_asuransi');
        $ceklist = $this->input->post('ceklist');
   
//$cek = if(isset($this->post('ceklist'))) ? 1 : 0; 
     
     
        $order_detail = [];
      
        foreach ($no as $key => $val) {
         
          if($no[$key] > 0 ){
         
          $order_detail[] = array(
            'id_transaksi'  =>  $this->input->post('id_transaksi'),
            'SPB'   => $spb[$key],
            'tanggal'   => $tanggal[$key],
            'asal'   => $asal[$key],
            'tujuan'   => $tujuan[$key],
            'service'   => $service[$key],
            'jumlah'   => $jumlah[$key],
            'harga_satuan'   => $harga_satuan[$key],
            'total_harga_satuan'   => $total_harga_satuan[$key],
            'total_harga_packing'   => $harga_packing[$key],
            'total_harga_asuransi'   => $harga_asuransi[$key],
            'cetak'   => $ceklist[$val] ? 1:0,

          );
        }
      }
        $this->db->insert_batch('transaksi_ukuran', $order_detail);

        $this->session->set_flashdata('message', "Invoice Berhasil Dibuat");
        redirect("Transaksi_cs");


      }else{
        $this->session->set_flashdata('message_error', "Invoice Gagal Di Buat");
        redirect("Transaksi_cs","refresh");
      }
    }else{
      if(!empty($_POST)){ 
        $this->session->set_flashdata('message_error',validation_errors());
        return redirect("Transaksi_cs/proses/".$id);  
      }else{


        $this->data['id_transaksi'] =   $nomor;
        $this->data['content'] = 'admin/invoice_cs/create_v'; 
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
    $pelanggan = $this->customer_model->getAllById(array('id' =>(!empty($data))?$data[0]->kode_pelanggan:""));
    $this->data['nama'] =   (!empty($pelanggan))?$pelanggan[0]->nama:"";
    $this->data['alamat'] =   (!empty($pelanggan))?$pelanggan[0]->alamat:"";

    $this->data['id_transaksi'] =   (!empty($data))?$data[0]->id_transaksi:"";
    $this->data['tgl_jatuh_tempo']    =   date("d M Y", strtotime((!empty($data))?$data[0]->tgl_jatuh_tempo:""));
    $this->data['jadwal_delivery']    =   date("d M Y", strtotime((!empty($data))?$data[0]->jadwal_delivery:""));
    $this->data['tgl_pengajuan']    =   date("d M Y", strtotime((!empty($data))?$data[0]->tgl_pengajuan:""));
     $this->data['asal'] =   (!empty($data))?$data[0]->asal:"";
     $this->data['inv'] =   (!empty($data))?$data[0]->id_transaksi:"";
     $this->data['tujuan'] =   (!empty($data))?$data[0]->tujuan:"";
     $this->data['catatan']    =   (!empty($data))?$data[0]->catatan:"";

     $spb = $this->transaksi_ukuran_model->getAllById(array("id_transaksi"=> $id_transaksi,"cetak" => "1"));
    $getSum = $this->transaksi_ukuran_model->getSumAllbyid(array('id_transaksi' => $id_transaksi ,"cetak" => "1"));
           $this->data['sub_total'] = (!empty($getSum))?$getSum[0]->total_satuan:"";
           $sub_total = (!empty($getSum))?$getSum[0]->total_satuan:"";
           $packing =  (!empty($getSum))?$getSum[0]->packing:"";
           $asuransi = (!empty($getSum))?$getSum[0]->asuransi:"";
           $pajak =  (!empty($data))?$data[0]->pajak:"";
           $rumus_pajak =   ($sub_total*$pajak)/100;

          $this->data['pajak']    =   $rumus_pajak;
          $this->data['total']    =  $sub_total + $rumus_pajak;
          $this->data['grand_total'] = $sub_total + $rumus_pajak + $packing + $asuransi;
          $this->data['packing'] = (!empty($getSum))?$getSum[0]->packing:"";
          $this->data['asuransi'] = (!empty($getSum))?$getSum[0]->asuransi:"";




     $this->data['spb'] = $spb; 

     $this->load->library('Pdf');

      $this->pdf->setPaper('A4', 'potrait');
    $this->pdf->filename = "InvoiceCS".date('dmy').".pdf";
    $this->pdf->load_view('admin/invoice_cs/cetak_v', $this->data, true);
  
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