<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/Admin_Controller.php';
class Werehouse extends Admin_Controller {
  public function __construct()
  {
    parent::__construct();
    $this->load->model('customer_model'); 
    $this->load->model('transaksi_model');
    $this->load->model('transaksi_ukuran_model');
    $this->load->model('wilayah_model');
  }
  public function index()
  {
    $this->load->helper('url');
    if($this->data['is_can_read']){
      $this->data['content'] = 'admin/werehouse/list_v';   
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
        
  $where = array ("tipe" => 'pickup' );
  $send = "status IN ('4','5')";    
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

              $id_transaksi = "<a href='".base_url().$suburl."/detail/".$data->id_transaksi."'><i class='fa fa-search'></i> ".$data->pick_up."</a>";
          
             $posting="";
           
              if($this->data['is_can_edit']){
              $adminAct = "<a href='".base_url().$suburl."/edit/".$data->id_transaksi."'

                   ><i class='fa fa-pencil'></i>&nbsp;Edit
                  </a>";
               }else{
        $adminAct = "";
               }
              

              if($data->posting >= 1){
                $posting = '<i class="fa fa-check-circle"></i> Posted';
              }if($data->posting == 4){
                $posting = '<i class="fa fa-thumbs-up"></i> Selesai';
              }

             
         if($data->status == 4){
                $status = '<i class="fa fa-spinner"></i> menunggu Di Terima ';
                 if($this->data['is_can_edit']){
                 $action = "<a href='".base_url().$suburl."/proses/".$data->id_transaksi."'><i class='fa fa-check'></i>Konfirmasi</a>";
               }else{
        $action = "";
               }
             
              }else{
                $status = '<i class="fa fa-truck"></i> Selesai';
                 $action = $adminAct;
              }
              
              $id_transaksi = "<a href='".base_url().$suburl."/detail/".$data->id_transaksi."'><i class='fa fa-search'></i> ".$data->pick_up."</a>";  
           
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
   $cekNomor = 'SPB'.$this->data['users']->id.'IP-DL'.date('d');
   $kode = $this->transaksi_model->getKode(array('id_transaksi' => $cekNomor));
   $nomor = $cekNomor.$kode; 
   $id_pelanggan = $this->input->post('pelanggan');


   $pelanggan = $this->customer_model->getAllById(array('id' =>$id_pelanggan));
 

    if ($this->form_validation->run() === TRUE)
    { 
 //update data pickup

         $dataP = array(  
          'posting'      => 5,
          'status'       => 5,
        );
      
     $update = $this->transaksi_model->update($dataP,array("id_transaksi"=>$id));
     //hapus no spb lama
    $dataEdit = $this->transaksi_model->getAllById(array("pick_up"=>$id));
    $deleteTD = $this->transaksi_ukuran_model->delete(array('id_transaksi' => $dataEdit[0]->id_transaksi ));
    $deleteT = $this->transaksi_model->delete(array("pick_up"=>$id));

     $dataT = $this->transaksi_model->getAllById(array('id_transaksi' =>$id));

     $nomor_manual = $this->input->post('nomor');
    
      $KDPROP  = $this->input->post('kdprop');
      $KDKAB   = $this->input->post('kdkab');
      $KDPROP_tujuan  = $this->input->post('kdprop_tujuan');
      $KDKAB_tujuan   = $this->input->post('kdkab_tujuan');
      $wilayah_asal = $this->wilayah_model->getOneBy(array('KDPROP' => $KDPROP, 'KDKAB' => $KDKAB));
      $wilayah_tujuan = $this->wilayah_model->getOneBy(array('KDPROP' => $KDPROP_tujuan, 'KDKAB' => $KDKAB_tujuan));
       $data = array (
    'id_transaksi' => $nomor_manual,
    'pick_up' => $id,
    'delivery' => $dataT[0]->pick_up,
    'kode_pelanggan' => $this->input->post('pelanggan'),
    'nama' => (!empty($pelanggan))?$pelanggan[0]->nama:"",
    'telp' => (!empty($pelanggan))?$pelanggan[0]->telp:"",
    'kirim_via' => $this->input->post('kirim_via'),
    'jenis_pengiriman' => $this->input->post('jenis_pengiriman'),
    'jenis_pembayaran' => $this->input->post('jenis_pembayaran'),
    'jadwal_pickup' => $this->input->post('jadwal_pickup'),
    'asal' => $wilayah_asal->NMKAB,
    'KDPROP_asal' => $wilayah_asal->KDPROP,
    'KDKAB_asal' => $wilayah_asal->KDKAB,
    'tujuan' => $wilayah_tujuan->NMKAB,
    'KDPROP_tujuan' => $wilayah_tujuan->KDPROP,
    'KDKAB_tujuan' => $wilayah_tujuan->KDKAB,
    'alamat' => $this->input->post('alamat'),
    'alamat_tujuan' => $this->input->post('alamat_tujuan'),
    'tipe' => 'delivery',
    'posting' => 1,
    'status' => 1,
    'created_by' => $this->input->post('sales'),
    'updated_by' => $this->input->post('user_input')
     );  

      $insert = $this->transaksi_model->insert($data); 

      
      if ($insert)
      {
   

        $no = $this->input->post('no');
      $harga_barang1 = str_replace(".","",$this->input->post('harga_barang'));
      $harga_barang  = str_replace("Rp","",$harga_barang1);
        $jenis_barang = $this->input->post('jenis_barang');
        $berat_barang = $this->input->post('berat');
        $panjang_barang = $this->input->post('panjang');
        $lebar_barang = $this->input->post('lebar');
        $tinggi_barang = $this->input->post('tinggi');
        $packing = $this->input->post('packing');
        $packing_k = $this->input->post('packingK');
        $asuransi = $this->input->post('asuransi');
        $jumlah_coli = $this->input->post('jumlah_coli');
       $berat_total = $this->input->post('berat_total');
       
        $order_detail = [];
      
        foreach ($no as $key => $val) {
          if($no[$key] > 0 ){
          $order_detail[] = array(
            'id_transaksi'  => $nomor_manual,
            'harga_barang'   => $harga_barang[$key],
            'jenis_barang'   => $jenis_barang[$key],
            'berat'   => $berat_barang[$key],
            'berat_total'   => $berat_total[$key],
            'panjang'   => $panjang_barang[$key],
            'lebar'   => $lebar_barang[$key],
            'tinggi'   => $tinggi_barang[$key],
            'packing'   => $packing[$key],
            'asuransi'   => $asuransi[$key],
            'jumlah_coli'   => $jumlah_coli[$key],

          );
        }
      }
        $this->db->insert_batch('transaksi_ukuran', $order_detail);

        $this->session->set_flashdata('message', "SPB Berhasil DiUbah");
        redirect("Werehouse");


      }else{
        $this->session->set_flashdata('message_error', "SPB gagal Diubah");
        redirect("Werehouse","refresh");
      }
    }else{
      if(!empty($_POST)){ 
        $this->session->set_flashdata('message_error',validation_errors());
        return redirect("Werehouse/proses/".$id);  
      }else{

      $data = $this->transaksi_model->getAllById(array("id_transaksi"=>$id));
      //ambil edit
     $id_transaksi = (!empty($data))?$data[0]->id_transaksi:"";
     $dataEdit = $this->transaksi_model->getAllById(array("pick_up"=>$id_transaksi));
  $barang = $this->transaksi_ukuran_model->getAllById(array("id_transaksi"=>$dataEdit[0]->id_transaksi));


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
        $this->data['sales']    =   (!empty($data))?$data[0]->created_by:"";
        $this->data['packing']    =   (!empty($data))?$data[0]->packing:"";

        $this->data['nomor']    =   (!empty($dataEdit))?$dataEdit[0]->id_transaksi:"";

    $this->data['jadwal_pickup']    =   date("d M Y - H:i", strtotime((!empty($data))?$data[0]->jadwal_pickup:""));
    $this->data['jadwal_pickup_pure']    = (!empty($data))?$data[0]->jadwal_pickup:"";
        $this->data['barang'] = $barang; 
        
        $this->data['content'] = 'admin/werehouse/edit_v'; 
        $this->data['pelanggan'] = $this->customer_model->getAllById();
        $this->data['data_provinsi'] = $this->wilayah_model->getAllProvince();  
       
        $this->load->view('admin/layouts/page',$this->data); 
      }  
    }   
  } 

  public function get_spb()
    {
        $response_data = array();

        $spb = $this->input->get('nomor');
        $data = array();
    $data = $this->transaksi_model->getAllById(array("id_transaksi"=>$spb));
         $id_transaksi = (!empty($data))?$data[0]->id_transaksi:"";
      
          $response_data['data']= (!empty($data))?$data[0]->id_transaksi:"";  
    
        echo json_encode($response_data);
    }

 public function proses($id)
  { 
    $this->form_validation->set_rules('id_transaksi',"transaksi tidak boleh kosong", 'trim|required'); 
  $date = date('y-m-d H:i:s');
   $cekNomor = 'SPB'.$this->data['users']->id.'IP-DL'.date('d');
   $kode = $this->transaksi_model->getKode(array('id_transaksi' => $cekNomor));
   $nomor = $cekNomor.$kode; 
   $id_pelanggan = $this->input->post('pelanggan');


   $pelanggan = $this->customer_model->getAllById(array('id' =>$id_pelanggan));
 

    if ($this->form_validation->run() === TRUE)
    { 
 //update data pickup

         $dataP = array(  
          'posting'      => 5,
          'status'       => 5,
        );
      
     $update = $this->transaksi_model->update($dataP,array("id_transaksi"=>$id));


     $dataT = $this->transaksi_model->getAllById(array('id_transaksi' =>$id));

     $nomor_manual = $this->input->post('nomor');
    
      $KDPROP  = $this->input->post('kdprop');
      $KDKAB   = $this->input->post('kdkab');
      $KDPROP_tujuan  = $this->input->post('kdprop_tujuan');
      $KDKAB_tujuan   = $this->input->post('kdkab_tujuan');
      $wilayah_asal = $this->wilayah_model->getOneBy(array('KDPROP' => $KDPROP, 'KDKAB' => $KDKAB));
      $wilayah_tujuan = $this->wilayah_model->getOneBy(array('KDPROP' => $KDPROP_tujuan, 'KDKAB' => $KDKAB_tujuan));
       $data = array (
    'id_transaksi' => $nomor_manual,
    'pick_up' => $id,
    'delivery' => $dataT[0]->pick_up,
    'kode_pelanggan' => $this->input->post('pelanggan'),
    'nama' => (!empty($pelanggan))?$pelanggan[0]->nama:"",
    'telp' => (!empty($pelanggan))?$pelanggan[0]->telp:"",
    'kirim_via' => $this->input->post('kirim_via'),
    'jenis_pengiriman' => $this->input->post('jenis_pengiriman'),
    'jenis_pembayaran' => $this->input->post('jenis_pembayaran'),
    'jadwal_pickup' => $this->input->post('jadwal_pickup'),
    'asal' => $wilayah_asal->NMKAB,
    'KDPROP_asal' => $wilayah_asal->KDPROP,
    'KDKAB_asal' => $wilayah_asal->KDKAB,
    'tujuan' => $wilayah_tujuan->NMKAB,
    'KDPROP_tujuan' => $wilayah_tujuan->KDPROP,
    'KDKAB_tujuan' => $wilayah_tujuan->KDKAB,
    'alamat' => $this->input->post('alamat'),
    'alamat_tujuan' => $this->input->post('alamat_tujuan'),
    'tipe' => 'delivery',
    'posting' => 1,
    'status' => 1,
    'created_by' => $this->input->post('sales'),
    'updated_by' => $this->input->post('user_input')
     );  

      $insert = $this->transaksi_model->insert($data); 

      
      if ($insert)
      {
   

        $no = $this->input->post('no');
      $harga_barang1 = str_replace(".","",$this->input->post('harga_barang'));
      $harga_barang  = str_replace("Rp","",$harga_barang1);
        $jenis_barang = $this->input->post('jenis_barang');
        $berat_barang = $this->input->post('berat');
        $panjang_barang = $this->input->post('panjang');
        $lebar_barang = $this->input->post('lebar');
        $tinggi_barang = $this->input->post('tinggi');
        $packing = $this->input->post('packing');
        $packing_k = $this->input->post('packingK');
        $asuransi = $this->input->post('asuransi');
        $jumlah_coli = $this->input->post('jumlah_coli');
       $berat_total = $this->input->post('berat_total');
       
        $order_detail = [];
      
        foreach ($no as $key => $val) {
          if($no[$key] > 0 ){
          $order_detail[] = array(
            'id_transaksi'  => $nomor_manual,
            'harga_barang'   => $harga_barang[$key],
            'jenis_barang'   => $jenis_barang[$key],
            'berat'   => $berat_barang[$key],
            'berat_total'   => $berat_total[$key],
            'panjang'   => $panjang_barang[$key],
            'lebar'   => $lebar_barang[$key],
            'tinggi'   => $tinggi_barang[$key],
            'packing'   => $packing[$key],
            'asuransi'   => $asuransi[$key],
            'jumlah_coli'   => $jumlah_coli[$key],

          );
        }
      }
        $this->db->insert_batch('transaksi_ukuran', $order_detail);

        $this->session->set_flashdata('message', "SPB Berhasil Di Update");
        redirect("Werehouse");


      }else{
        $this->session->set_flashdata('message_error', "SPB gagal dibuat");
        redirect("Werehouse","refresh");
      }
    }else{
      if(!empty($_POST)){ 
        $this->session->set_flashdata('message_error',validation_errors());
        return redirect("Werehouse/proses/".$id);  
      }else{

        $data = $this->transaksi_model->getAllById(array("id_transaksi"=>$id));
      $barang = $this->transaksi_ukuran_model->getAllById(array("id_transaksi"=>$data[0]->pick_up));


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
        $this->data['sales']    =   (!empty($data))?$data[0]->created_by:"";
        $this->data['packing']    =   (!empty($data))?$data[0]->packing:"";

        $this->data['nomor']    =  $nomor;

    $this->data['jadwal_pickup']    =   date("d M Y - H:i", strtotime((!empty($data))?$data[0]->jadwal_pickup:""));
    $this->data['jadwal_pickup_pure']    = (!empty($data))?$data[0]->jadwal_pickup:"";
        $this->data['barang'] = $barang; 
        
        $this->data['content'] = 'admin/werehouse/konfirmasi'; 
        $this->data['pelanggan'] = $this->customer_model->getAllById();
        $this->data['data_provinsi'] = $this->wilayah_model->getAllProvince();  
       
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
        $barang = $this->transaksi_ukuran_model->getAllById(array("id_transaksi"=>$data[0]->pick_up));


        $this->data['id_transaksi'] =   (!empty($data))?$data[0]->id_transaksi:"";
        $this->data['kode_pelanggan'] =   (!empty($data))?$data[0]->kode_pelanggan:"";
        $this->data['kirim_via'] =   (!empty($data))?$data[0]->kirim_via:"";
        $this->data['jenis_pengiriman'] =   (!empty($data))?$data[0]->jenis_pengiriman:"";
        $this->data['jenis_pembayaran'] =   (!empty($data))?$data[0]->jenis_pembayaran:"";
          $this->data['jadwal_pickup']    =   date("d M Y - H:i", strtotime((!empty($data))?$data[0]->jadwal_pickup:""));
        $this->data['catatan'] =   (!empty($data))?$data[0]->catatan:"";
         $this->data['asal'] =   (!empty($data))?$data[0]->asal:"";
        $this->data['KDPROP_asal'] =   (!empty($data))?$data[0]->KDPROP_asal:"";
        $this->data['KDKAB_asal'] =   (!empty($data))?$data[0]->KDKAB_asal:"";
        $this->data['KDPROP_tujuan'] =   (!empty($data))?$data[0]->KDPROP_tujuan:"";
        $this->data['KDKAB_tujuan'] =   (!empty($data))?$data[0]->KDKAB_tujuan:"";
       
        $this->data['alamat'] =   (!empty($data))?$data[0]->alamat:"";
        $this->data['alamat_tujuan'] =   (!empty($data))?$data[0]->alamat_tujuan:"";
        $this->data['status']     =   (!empty($data))?$data[0]->status:""; 
        $this->data['posting']    =   (!empty($data))?$data[0]->posting:"";  
        $this->data['waktu_input']    =   (!empty($data))?$data[0]->created_at:"";
        $this->data['pickup']    =   (!empty($data))?$data[0]->pick_up:"";
        $this->data['barang']    =   $barang;
        
        $this->data['content'] = 'admin/pickadel/detail_v'; 
        $this->data['pelanggan'] = $this->customer_model->getAllById();
        $this->data['data_provinsi'] = $this->wilayah_model->getAllProvince();  
       
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