<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/Admin_Controller.php';
class Transaksi extends Admin_Controller {
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
      $this->data['content'] = 'admin/invoice/list_v';
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
            7 => 'KDPROP_asal',
        );

      $order = $columns[$this->input->post('order')[0]['column']];
      $dir = $this->input->post('order')[0]['dir'];
      $search = array();
      $limit = 0;
      $start = 0;
      
  $where = array ("tipe" => 'transaksi' );
  $send = "";    
      $totalData = $this->transaksi_model->getCountAllBy($limit,$start,$search,$order,$dir,$where);       

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
            $where['delivery'] = $value;
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
                   if($this->data['is_can_delete']){
  $adminAct = "<a href='#' 
                  url='".base_url().$suburl."/destroy/".$data->id_transaksi."'
                  class='delete' 
                   ><i class='fa fa-trash'></i>&nbsp;Hapus
                  </a>";
                   }else{
        $adminAct = "";
      }

               }
              

              if($data->posting >= 1){
                $posting = '<i class="fa fa-check-circle"></i> Posted';
              }if($data->posting == 4){
                $posting = '<i class="fa fa-thumbs-up"></i> Selesai';
              }

             
           if($data->status == 2){
                $status = '<i class="fa fa-spinner"></i> Selesai di Konfirmasi';
                 if($this->data['is_can_edit']){
             $action = "<a href='".base_url().$suburl."/proses/".$data->id_transaksi."'><i class='fa fa-check'></i>Revisi</a>&nbsp;".$adminAct;
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
              
              $id_transaksi = "<a href='".base_url().$suburl."/detail/".$data->id_transaksi."'><i class='fa fa-search'></i> ".$data->id_transaksi."</a>";  
           
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
    $cekNomor = 'INV001';
    $inv = 'INV';
   $kode = $this->transaksi_model->getKode();
   $nomor = $inv.$kode; 
   $id_pelanggan = $this->input->post('pelanggan');


   $pelanggan = $this->customer_model->getAllById(array('id' =>$id_pelanggan));
 

    if ($this->form_validation->run() === TRUE)
    { 

      $dataT = $this->transaksi_model->getAllById(array('id_transaksi' =>$id));

      $delivery = (!empty($dataT))?$dataT[0]->delivery:"";
 //update data delivery
      $total_harga1 = str_replace(".","",$this->input->post('total_harga'));
      $total_harga  = str_replace("Rp","",$total_harga1);
      $total_harga_global1 = str_replace(".","",$this->input->post('total_harga_global'));
      $total_harga_global  = str_replace("Rp","",$total_harga_global1);
      $sum_harga_packing1 = str_replace(".","",$this->input->post('sum_harga_packing'));
      $sum_harga_packing  = str_replace("Rp","",$sum_harga_packing1);

      $sum_harga_asuransi1 = str_replace(".","",$this->input->post('sum_harga_asuransi'));
      $sum_harga_asuransi  = str_replace("Rp","",$sum_harga_asuransi1);

      $total1 = str_replace(".","",$this->input->post('total'));
      $total  = str_replace("Rp","",$total1);

      $pajak1 = str_replace(".","",$this->input->post('pajak'));
      $pajak  = str_replace("Rp","",$pajak1);

         $dataD = array(  
          
         'total_harga' => $total_harga,
          'total_harga_global' => $total_harga_global,
          'total_harga_packing' => $sum_harga_packing,
          'total_harga_asuransi' => $sum_harga_asuransi,
          'total' => $total,
          'pajak' => $pajak,
          'tgl_jatuh_tempo' => $this->input->post('tgl_jatuh_tempo'),
          'tgl_rilis' => $this->input->post('tgl_rilis'),
          'posting'      => 2,
          'status'       => 2,
          'created_at' => $this->input->post('waktu_input'),
          'updated_by'       => $this->input->post('user_input'),

        );
      
     $update = $this->transaksi_model->update($dataD,array("id_transaksi"=>$id));
    
      
      if ($update)
      {
 
        
$this->transaksi_ukuran_model->delete(array("id_transaksi"=>$delivery));

         $no = $this->input->post('no');
       $harga_barang = $this->input->post('harga_barang');
        $harga_packing1 = str_replace(".","",$this->input->post('harga_packing'));
        $harga_packing  = str_replace("Rp","",$harga_packing1);
        $harga_asuransi1 = str_replace(".","",$this->input->post('harga_asuransi'));
        $harga_asuransi  = str_replace("Rp","",$harga_asuransi1);
        $harga_satuan1 = str_replace(".","",$this->input->post('harga_satuan'));
        $harga_satuan  = str_replace("Rp","",$harga_satuan1);

        $jenis_barang = $this->input->post('jenis_barang');
        $berat_barang = $this->input->post('berat');
        $panjang_barang = $this->input->post('panjang');
        $lebar_barang = $this->input->post('lebar');
        $tinggi_barang = $this->input->post('tinggi');
        $packing = $this->input->post('packing_s');
        $asuransi = $this->input->post('asuransi_s');
        $jumlah = $this->input->post('jumlah');
        $jumlah_packing = $this->input->post('jumlah_packing');
        $jumlah_coli = $this->input->post('jumlah_coli');
        $berat_total = $this->input->post('berat_total');
        $opsi_satuan = $this->input->post('opsi_satuan');

        $total_harga_packing1 = str_replace(".","",$this->input->post('total_harga_packing'));
        $total_harga_packing  = str_replace("Rp","",$total_harga_packing1);
        $total_harga_asuransi1 = str_replace(".","",$this->input->post('total_harga_asuransi'));
        $total_harga_asuransi  = str_replace("Rp","",$total_harga_asuransi1);
        $total_harga_satuan1 = str_replace(".","",$this->input->post('total_harga_satuan'));
        $total_harga_satuan  = str_replace("Rp","",$total_harga_satuan1);
       
        $order_detail = [];
      
        foreach ($no as $key => $val) {
          if($no[$key] > 0 ){
          $order_detail[] = array(
            'id_transaksi'  => $delivery,
            'harga_barang'   => $harga_barang[$key],
            'jenis_barang'   => $jenis_barang[$key],
            'opsi_satuan'   => $opsi_satuan[$key],
            'berat'   => $berat_barang[$key],
            'panjang'   => $panjang_barang[$key],
            'lebar'   => $lebar_barang[$key],
            'tinggi'   => $tinggi_barang[$key],
            'packing'   => $packing[$key],
            'asuransi'   => $asuransi[$key],
            'jumlah_coli_cs'   => $jumlah_packing[$key],
            'harga_packing'   => $harga_packing[$key],
            'harga_asuransi'   => $harga_asuransi[$key],
            'harga_satuan'   => $harga_satuan[$key],
            'jumlah_coli'   => $jumlah_coli[$key],
            'jumlah'   => $jumlah[$key],
            'berat_total'   => $berat_total[$key],
            'total_harga_packing'   => $total_harga_packing[$key],
            'total_harga_asuransi'   => $total_harga_asuransi[$key],
            'total_harga_satuan'   => $total_harga_satuan[$key]


          );
        }
      }
        $this->db->insert_batch('transaksi_ukuran', $order_detail);

        $this->session->set_flashdata('message', "Invoice Berhasil di simpan");
        redirect("Transaksi");


      }else{
        $this->session->set_flashdata('message_error', "Invoice Gagal di simpan");
        redirect("Transaksi","refresh");
      }
    }else{
      if(!empty($_POST)){ 
        $this->session->set_flashdata('message_error',validation_errors());
        return redirect("Transaksi/proses/".$id);  
      }else{

        $data = $this->transaksi_model->getAllById(array("id_transaksi"=>$id));
      $barang = $this->transaksi_ukuran_model->getAllById(array("id_transaksi"=>$data[0]->delivery));

        $this->data['delivery'] =   (!empty($data))?$data[0]->delivery:"";
        $this->data['sales'] =   (!empty($data))?$data[0]->created_by:"";
        $this->data['id_transaksi'] =   (!empty($data))?$data[0]->id_transaksi:"";
        $this->data['kode_pelanggan'] =   (!empty($data))?$data[0]->kode_pelanggan:"";
        $this->data['kirim_via'] =   (!empty($data))?$data[0]->kirim_via:"";
        $this->data['jenis_pengiriman'] =   (!empty($data))?$data[0]->jenis_pengiriman:"";
        $this->data['jenis_pembayaran'] =   (!empty($data))?$data[0]->jenis_pembayaran:"";
    
        $this->data['asal'] =   (!empty($data))?$data[0]->asal:"";
        $this->data['catatan'] =   (!empty($data))?$data[0]->catatan:"";
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
       $this->data['total_harga_packing']    =   (!empty($data))?$data[0]->total_harga_packing:"";
      $this->data['total_harga_asuransi']    =   (!empty($data))?$data[0]->total_harga_asuransi:"";
  $this->data['total_harga']    =   (!empty($data))?$data[0]->total_harga:"";
    $this->data['total_harga_global']    =   (!empty($data))?$data[0]->total_harga_global:"";
  $this->data['total']    =   (!empty($data))?$data[0]->total:"";
  $this->data['pajak']    =   (!empty($data))?$data[0]->pajak:"";
  $this->data['catatan']    =   (!empty($data))?$data[0]->catatan:"";
     

        $this->data['jadwal_pickup']    =   date("d M Y - H:i", strtotime((!empty($data))?$data[0]->jadwal_pickup:""));


        $this->data['barang'] = $barang; 
        
        $this->data['content'] = 'admin/invoice/konfirmasi'; 
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
        $barang = $this->transaksi_ukuran_model->getAllById(array("id_transaksi"=>(!empty($data))?$data[0]->delivery:""));


        
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
        $this->data['jadwal_pickup']    =   date("d M Y - H:i", strtotime((!empty($data))?$data[0]->jadwal_pickup:""));
         $this->data['tgl_jatuh_tempo']    =   date("d M Y", strtotime((!empty($data))?$data[0]->tgl_jatuh_tempo:""));
          $this->data['tgl_rilis']    =   date("d-m-Y", strtotime((!empty($data))?$data[0]->tgl_rilis:""));
           $this->data['catatan']    =   (!empty($data))?$data[0]->catatan:"";
        $this->data['barang'] = $barang; 
        
        $this->data['content'] = 'admin/invoice/detail_v'; 
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
    $pelanggan = $this->customer_model->getAllById(array('id' =>(!empty($data))?$data[0]->kode_pelanggan:""));
    $this->data['nama'] =   (!empty($pelanggan))?$pelanggan[0]->nama:"";
    $this->data['alamat'] =   (!empty($pelanggan))?$pelanggan[0]->alamat:"";
    $this->data['id_transaksi'] =   (!empty($data))?$data[0]->id_transaksi:"";
    $this->data['tgl_jatuh_tempo']    =   date("d M Y", strtotime((!empty($data))?$data[0]->tgl_jatuh_tempo:""));
      $this->data['jadwal_delivery']    =   date("d M Y", strtotime((!empty($data))?$data[0]->jadwal_delivery:""));
    $this->data['tgl_rilis']    =   date("d M Y", strtotime((!empty($data))?$data[0]->tgl_rilis:""));
     $this->data['asal'] =   (!empty($data))?$data[0]->asal:"";
      $this->data['kirim_via'] =   (!empty($data))?$data[0]->kirim_via:"";
     $this->data['inv'] =   (!empty($data))?$data[0]->id_transaksi:"";
     $this->data['tujuan'] =   (!empty($data))?$data[0]->tujuan:"";
     $this->data['total_harga']    =   (!empty($data))?$data[0]->total_harga:"";
     $this->data['total_harga_global']    =   (!empty($data))?$data[0]->total_harga_global:"";
     $this->data['packing']    =   (!empty($data))?$data[0]->total_harga_packing:"";
     $this->data['asuransi']    =   (!empty($data))?$data[0]->total_harga_asuransi:"";
     $this->data['total']    =   (!empty($data))?$data[0]->total:"";
     $this->data['pajak']    =   (!empty($data))?$data[0]->pajak:"";
     $this->data['catatan']    =   (!empty($data))?$data[0]->catatan:"";

     $barang = $this->transaksi_ukuran_model->getAllById(array("id_transaksi"=>(!empty($data))?$data[0]->delivery:""));
     $this->data['barang'] = $barang; 

     $this->load->library('pdf');

      $this->pdf->setPaper('A4', 'potrait');

    $this->$pdf->SetAutoPageBreak(true);
    $this->$pdf->SetDisplayMode('real', 'default');
    $this->pdf->filename = "Invoice".date('dmy').".pdf";
    $this->pdf->load_view('admin/invoice/cetak_v', $this->data, true);
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