<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/Admin_Controller.php';
class Daftar_harga extends Admin_Controller {
  public function __construct()
  {
    parent::__construct();
    $this->load->model('customer_model'); 
    $this->load->model('transaksi_model');
    $this->load->model('transaksi_ukuran_model');
    $this->load->model('wilayah_model');
    $this->load->model('vendor_model');
    $this->load->model('daftar_harga_model');
    $this->load->model('daftar_harga_key_model');

  }
  public function index()
  {
    $this->load->helper('url');
    if($this->data['is_can_read']){
      $this->data['content'] = 'admin/daftar_harga/list_v';   
    }else{
      $this->data['content'] = 'errors/html/restrict'; 
    }
    
    $this->load->view('admin/layouts/page',$this->data);  
  }

   public function dataList()
  {
    $columns = array( 
            0 => 'id', 
            1 => 'id_daftar_harga',
            2 => 'kirim_via',
            3 => 'tujuan',
            4 => 'created_at',
        );

      $order = $columns[$this->input->post('order')[0]['column']];
      $dir = $this->input->post('order')[0]['dir'];
      $search = array();
      $where = array();
     
      $limit = 0;
      $start = 0;
      $totalData = $this->daftar_harga_key_model->getCountAllBy($limit,$start,$search,$order,$dir,$where);       

        $searchColumn = $this->input->post('columns');
        $isSearchColumn = false;
        

      if($isSearchColumn){
        $totalFiltered = $this->daftar_harga_key_model->getCountAllBy($limit,$start,$search,$order,$dir,$where); 
      }else{
        $totalFiltered = $totalData;
      }  
       
    $limit = $this->input->post('length');
    $start = $this->input->post('start');
    $datas = $this->daftar_harga_key_model->getAllBy($limit,$start,$search,$order,$dir,$where);
    $suburl = $this->uri->segment(1);
        $new_data = array();
        if(!empty($datas))
        {
            foreach ($datas as $key=>$data)
            {   

            if($this->data['is_can_edit']){
          $edit = "<a href='".base_url().$suburl."/edit/".$data->id_daftar_harga."'><i class='fa fa-check'></i>Edit </a>";
            }else{
          $edit = '';
            }

            if($this->data['is_can_delete']){
          $hapus = "<a href='#' 
                  url='".base_url().$suburl."/destroy/".$data->id_daftar_harga."'
                  class='delete' 
                   ><i class='fa fa-trash'></i>&nbsp;Hapus
                  </a>";
            }else{
          $hapus = "";
            }
           
            $nestedData['id']   = $start+$key+1;
            $nestedData['id_daftar_harga'] = $data->id_daftar_harga;
            $nestedData['kirim_via']  = 'Jalur '.$data->kirim_via;
            $nestedData['tujuan']  = $data->tujuan;
            $nestedData['created_at']  = $data->created_at;
          
            $nestedData['aksi']  = $edit.'   '.$hapus;
            
         
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

  public function create(){
  $this->form_validation->set_rules('id_daftar',"daftar harga tidak boleh kosong", 'trim|required'); 
  $date = date('Y-m-d');
    $cekNomor = $this->data['users']->id.date('d');
   $kode = $this->daftar_harga_key_model->getKode(array('id_daftar_harga' => $cekNomor));
   $nomor = $cekNomor.$kode; 

  if($this->form_validation->run() == true){

      $KDPROP_tujuan  = $this->input->post('kdprop_tujuan');
      $KDKAB_tujuan   = $this->input->post('kdkab_tujuan');
      $wilayah_tujuan = $this->wilayah_model->getOneBy(array('KDPROP' => $KDPROP_tujuan, 'KDKAB' => $KDKAB_tujuan));

     $data = array(
      'id_daftar_harga' => $nomor,
      'KDPROP_asal' => '12',
          'KDKAB_asal' => '75',
          'asal' => 'KOTA MEDAN',
      'KDPROP_tujuan' => $KDPROP_tujuan,
      'KDKAB_tujuan' => $KDKAB_tujuan,
      'tujuan' => $wilayah_tujuan->NMKAB,
      'created_at' => $this->input->post('waktu_input'),
      'kirim_via' => $this->input->post('kirim_via'),
      'created_by' => $this->input->post('user_input'),


      );
     $insert = $this->daftar_harga_key_model->insert($data);

     if($insert)
     {
      $KDPROP_tujuan  = $this->input->post('kdprop_tujuan');
      $KDKAB_tujuan   = $this->input->post('kdkab_tujuan');
      $wilayah_tujuan = $this->wilayah_model->getOneBy(array('KDPROP' => $KDPROP_tujuan, 'KDKAB' => $KDKAB_tujuan));

        $no = $this->input->post('no');
        $kg = $this->input->post('kg');
        $min = $this->input->post('min');
        $coliA = $this->input->post('coliA');
        $coliB = $this->input->post('coliA');
        $coliC = $this->input->post('coliC');
        $leadtime = $this->input->post('leadtime');
        $ket = $this->input->post('ket');

        $daftar_harga_detail = [];
        foreach ($no as $key => $val) {
          if($no[$key] > 0){
          $daftar_harga_detail[] = array(
          'id_harga' => $nomor,
          'kg' => $kg[$key],
          'min' => $min[$key],
          'coli_a' => $coliA[$key],
          'coli_b' => $coliB[$key],
          'coli_c' => $coliC[$key], 
          'lead_time' => $leadtime[$key],
          'keterangan' => $ket[$key],
          'KDPROP_asal' => '12',
          'KDKAB_asal' => '75',
          'asal' => 'KOTA MEDAN',
          'KDPROP_tujuan' => $KDPROP_tujuan,
          'KDKAB_tujuan' => $KDKAB_tujuan,
          'tujuan' => $wilayah_tujuan->NMKAB,
          'created_at' => $this->input->post('waktu_input'),
         'kirim_via' => $this->input->post('kirim_via'),
        'created_by' => $this->input->post('user_input'),

        );
          }
        }
       $this->db->insert_batch('daftar_harga',$daftar_harga_detail);
       $this->session->set_flashdata('message', "Daftar harga Baru Berhasil Disimpan");
        redirect("Daftar_harga");
      }else{
        $this->session->set_flashdata('message_error',"Daftar harga Baru Gagal Disimpan");
        redirect("Daftar_harga");
      } 


  }else{
    $this->data['content'] = 'admin/daftar_harga/create_v';
    $this->data['waktu_input'] = $date;
    $this->data['nomor'] = $nomor;
     $this->data['data_provinsi'] = $this->wilayah_model->getAllProvince();
    $this->load->view('admin/layouts/page',$this->data);
  }
}
 public function edit($id){
  $this->form_validation->set_rules('id_daftar',"daftar harga tidak boleh kosong", 'trim|required'); 
  $date = date('Y-m-d');
    $cekNomor = $this->data['users']->id.date('d');
   $kode = $this->daftar_harga_key_model->getKode(array('id_daftar_harga' => $cekNomor));
   $nomor = $cekNomor.$kode; 

  if($this->form_validation->run() == true){

      $KDPROP_tujuan  = $this->input->post('kdprop_tujuan');
      $KDKAB_tujuan   = $this->input->post('kdkab_tujuan');
      $wilayah_tujuan = $this->wilayah_model->getOneBy(array('KDPROP' => $KDPROP_tujuan, 'KDKAB' => $KDKAB_tujuan));

     $data = array(
      'KDPROP_asal' => '12',
          'KDKAB_asal' => '75',
          'asal' => 'KOTA MEDAN',
      'KDPROP_tujuan' => $KDPROP_tujuan,
      'KDKAB_tujuan' => $KDKAB_tujuan,
      'tujuan' => $wilayah_tujuan->NMKAB,
      'created_at' => $this->input->post('waktu_input'),
      'kirim_via' => $this->input->post('kirim_via'),
      'created_by' => $this->input->post('user_input'),


      );
     $update = $this->daftar_harga_key_model->update($data,array("id_daftar_harga" => $id));

     if($update)
     {

    $this->daftar_harga_model->delete(array("id_harga"=>$id));
    $coliA1 = str_replace(".","",$this->input->post('coliA'));
    $coliA  = str_replace("Rp","",$coliA1);
    $coliB1 = str_replace(".","",$this->input->post('coliB'));
    $coliB  = str_replace("Rp","",$coliB1);
    $coliC1 = str_replace(".","",$this->input->post('coliC'));
    $coliC  = str_replace("Rp","",$coliC1);

      $KDPROP_tujuan  = $this->input->post('kdprop_tujuan');
      $KDKAB_tujuan   = $this->input->post('kdkab_tujuan');
      $wilayah_tujuan = $this->wilayah_model->getOneBy(array('KDPROP' => $KDPROP_tujuan, 'KDKAB' => $KDKAB_tujuan));

        $no = $this->input->post('no');
        $kg = $this->input->post('kg');
        $min = $this->input->post('min');
       
        $leadtime = $this->input->post('leadtime');
        $ket = $this->input->post('ket');

        $daftar_harga_detail = [];
        foreach ($no as $key => $val) {
          if($no[$key] > 0){
          $daftar_harga_detail[] = array(
          'id_harga' => $id,
          'kg' => $kg[$key],
          'min' => $min[$key],
          'coli_a' => $coliA[$key],
          'coli_b' => $coliB[$key],
          'coli_c' => $coliC[$key], 
          'lead_time' => $leadtime[$key],
          'keterangan' => $ket[$key],
          'KDPROP_asal' => '12',
          'KDKAB_asal' => '75',
          'asal' => 'KOTA MEDAN',
          'KDPROP_tujuan' => $KDPROP_tujuan,
          'KDKAB_tujuan' => $KDKAB_tujuan,
          'tujuan' => $wilayah_tujuan->NMKAB,
          'created_at' => $this->input->post('waktu_input'),
         'kirim_via' => $this->input->post('kirim_via'),
        'created_by' => $this->input->post('user_input'),

        );
          }
        }
       $this->db->insert_batch('daftar_harga',$daftar_harga_detail);
       $this->session->set_flashdata('message', "Daftar harga Baru Berhasil Disimpan");
        redirect("Daftar_harga");
      }else{
        $this->session->set_flashdata('message_error',"Daftar harga Baru Gagal Disimpan");
        redirect("Daftar_harga");
      } 


  }else{
    $data = $this->daftar_harga_key_model->getAllById(array("id_daftar_harga"=>$id));
    $daftar_harga = $this->daftar_harga_model->getAllById(array("id_harga"=>$id));

    $this->data['kirim_via'] =  (!empty($data))?$data[0]->kirim_via:"";
    $this->data['KDPROP_tujuan'] =   (!empty($data))?$data[0]->KDPROP_tujuan:"";
    $this->data['KDKAB_tujuan'] =   (!empty($data))?$data[0]->KDKAB_tujuan:""; 
    $this->data['waktu_input'] = $date;
    $this->data['nomor'] =  (!empty($data))?$data[0]->id_daftar_harga:"";
    $this->data['daftar_harga'] = $daftar_harga;
    $this->data['data_provinsi'] = $this->wilayah_model->getAllProvince();
    $this->data['content'] = 'admin/daftar_harga/edit_v';
    $this->load->view('admin/layouts/page',$this->data);
  }
}
  public function destroy(){
    $response_data = array();
        $response_data['status'] = false;
        $response_data['msg'] = "";
        $response_data['data'] = array();   
    $id =$this->uri->segment(3);
    if(!empty($id)){
          $delete = $this->daftar_harga_key_model->delete(array("id_daftar_harga"=>$id));
          $delete_ukuran = $this->daftar_harga_model->delete(array("id_harga"=>$id));
         
          $response_data['data'] = $data; 
          $response_data['status'] = true;
    }else{
      $response_data['msg'] = "ID Harus Diisi";
    }
    
        echo json_encode($response_data); 
  }

}
?>