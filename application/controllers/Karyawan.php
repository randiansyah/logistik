<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/Admin_Controller.php';
class Karyawan extends Admin_Controller {
	public function __construct(){
 parent::__construct();
 $this->load->model('karyawan_model');
 $this->load->model('cabang_model');
 $this->load->helper(array('form', 'url'));
	}




public function index()
{
  $this->load->helper('url');
  if($this->data['is_can_read']){
	$this->data['content'] = 'admin/karyawan/list_v'; 	
	}else{
	$this->data['content'] = 'errors/html/restrict'; 
	}
	$this->load->view('admin/layouts/page',$this->data);  
}

public function dataList()
  {
    $columns = array( 
            0 => 'id', 
           1 => 'KDPGW', 
           2 => 'nama',
           3 => 'staff_level',
           4 => 'divisi',
           5 => 'status_karyawan',
           6 => 'no_hp',
           7 => 'status',
           8 => ''
        );

      $order = $columns[$this->input->post('order')[0]['column']];
      $dir = $this->input->post('order')[0]['dir'];
      $search = array();
      $limit = 0;
      $start = 0;
      $totalData = $this->karyawan_model->getCountAllBy($limit,$start,$search,$order,$dir);       
        $searchColumn = $this->input->post('columns');
        $isSearchColumn = false;
        
          if(!empty($searchColumn[1]['search']['value'])){
          $value = $searchColumn[1]['search']['value'];
          $isSearchColumn = true;
          $search['menu_kategori.kode'] = $value;
        }  
        if(!empty($this->input->post('search')['value'])){
          $search_value = $this->input->post('search')['value'];
          $search = array( 
              "menu_kategori.kode"          =>$search_value,
            ); 
          $totalFiltered = $this->karyawan_model->getCountAllBy($limit,$start,$search,$order,$dir); 
        }else{
          $totalFiltered = $totalData;
        } 
       
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $datas = $this->karyawan_model->getAllBy($limit,$start,$search,$order,$dir);
        $new_data = array();
        if(!empty($datas))
        {
        foreach ($datas as $key=>$data)
        {   
          $delete_url = "";
        
              if($this->data['is_can_delete']){
                if($data->is_deleted == 0){
                $delete_url = "<a href='#' 
                  url='".base_url()."karyawan/destroy/".$data->id."/".$data->is_deleted."'
                  class='btn btn-sm btn-success white delete' >Non Aktifkan
                  </a>";
              }else{
                $delete_url = "<a href='#' 
                  url='".base_url()."karyawan/destroy/".$data->id."/".$data->is_deleted."'
                  class='btn btn-sm btn-danger white delete' 
                   >Aktifkan
                  </a>";
              } 
            }
        
                $nestedData['id']            = $start+$key+1;
                $nestedData['KDPGW'] = "<a href='".base_url()."karyawan/edit/".$data->id."'><i class='fa fa-search'></i> ".$data->KDPGW."</a>";
                $nestedData['nama']  = $data->nama;
                $nestedData['nickname']  = $data->nickname;
                $nestedData['mulai_bekerja']  = $data->mulai_bekerja;
                $nestedData['alamat']  = $data->alamat;
                $nestedData['alamat_saat_ini']  = $data->alamat_saat_ini;
                $nestedData['KTP']  = $data->KTP;
                $nestedData['tempat_lahir']  = $data->tempat_lahir." ".$data->tgl_lahir;
                $nestedData['agama']  = $data->agama;
                $nestedData['jenis_kelamin']  = $data->jenis_kelamin;
                $nestedData['no_hp']  = $data->no_hp;
                $nestedData['golongan_darah']  = $data->golongan_darah;
                $nestedData['sim']  = $data->sim;
                $nestedData['status_pernikahan']  = $data->status_pernikahan;
                $nestedData['pendidikan_terakhir']  = $data->pendidikan_terakhir;
                $nestedData['instansi_pendidikan']  = $data->instansi_pendidikan;
                $nestedData['staff_level']  = $data->staff_level;
                $nestedData['divisi']  = $data->divisi;
                $nestedData['status_karyawan']  = $data->status_karyawan;
                if($data->status == "1"){
                $nestedData['status']   = '<span class="btn btn-success btn-xs">Aktif</span>';
              }else{
                  $nestedData['status']   = '<span class="btn btn-danger btn-xs">Tidak Aktif</span>';               
              }
                $nestedData['photo'] = "<img width='50px' src=".base_url('assets/upload/').$data->photo.">";  
                $nestedData['action']        = $delete_url;   
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
  $this->form_validation->set_rules('nama',"Nama Lengkap", 'trim|required'); 
   $date = date('y-m-d H:i:s');
  if($this->form_validation->run() === TRUE){
    $config['upload_path']          = './assets/upload/image';
    $config['allowed_types']        = 'gif|jpg|png';
    $config['overwrite']      = true;
    $config['max_size']    = 2024; 
    $config['encrypt_name'] = TRUE;
            $this->load->library('upload', $config);
     if (!$this->upload->do_upload('photo'))
                {
      $error = array('error' => $this->upload->display_errors());

    $this->session->set_flashdata('message_error',"photo Gagal di upload");
    redirect("karyawan/create","refresh");

                }else{
    $data = $this->upload->data();
    $photo = $data['file_name'];
    $data = array (
    'KDPGW' => $this->input->post('KDPGW'),
    'nama' => $this->input->post('nama'),
    'nickname' => $this->input->post('nickname'), 
    'mulai_bekerja' => $this->input->post('mulai_bekerja'),
    'alamat' => $this->input->post('alamat'),
    'alamat_saat_ini' => $this->input->post('alamat_saat_ini'),
    'KTP' => $this->input->post('KTP'),
    'tempat_lahir' => $this->input->post('tempat_lahir'),
    'tgl_lahir' => $this->input->post('tgl_lahir'),
    'agama' => $this->input->post('agama'),
    'jenis_kelamin' => $this->input->post('jenis_kelamin'),
    'no_hp' => $this->input->post('no_hp'),
    'golongan_darah' => $this->input->post('golongan_darah'),
    'sim' => $this->input->post('sim'),
    'status_pernikahan' => $this->input->post('status_pernikahan'),
    'pendidikan_terakhir' => $this->input->post('pendidikan_terakhir'),
    'instansi_pendidikan' => $this->input->post('instansi_pendidikan'),
    'staff_level' => $this->input->post('staff_level'),
    'divisi' => $this->input->post('divisi'),
    'status_karyawan' => $this->input->post('status_karyawan'),
    'status' => $this->input->post('status'),
    'user_input' => $this->input->post('user_input'),
    'waktu_input' => $this->input->post('waktu_input'),
    'photo' => $photo
     );  
   
   
   
    $insert_barang = $this->karyawan_model->insert($data);
    if ($insert_barang)
      {  
        $this->session->set_flashdata('message', "Karyawan Baru Berhasil Disimpan");
        redirect("karyawan");
      }else{
        $this->session->set_flashdata('message_error',"Karyawan Baru Gagal Disimpan");
        redirect("karyawan");
      }     
                }

  }else{
       
    $this->data['content'] = 'admin/karyawan/create_v';
    $this->data['waktu_input'] = $date;
    $this->load->view('admin/layouts/page',$this->data);
  }
 }
 public function edit($id){
 $this->form_validation->set_rules('nama',"Name Is Required", 'trim|required'); 

if($this->form_validation->run() === TRUE){
 
    $config['upload_path']          = './assets/upload/image';
    $config['allowed_types']        = 'gif|jpg|png';
    $config['overwrite']      = true;
    $config['max_size']             = 2024;
    $config['encrypt_name'] = TRUE;
$this->load->library('upload', $config);

 if ( ! $this->upload->do_upload('photo'))
                {
   $photo = $this->input->post('filephoto');
                }

                else{
$data = $this->upload->data();  
$photo = $data['file_name'];
                }

$date = date('y-m-d H:i:s');

 $data = array (
    'KDPGW' => $this->input->post('KDPGW'),
    'nama' => $this->input->post('nama'),
    'nickname' => $this->input->post('nickname'), 
    'mulai_bekerja' => $this->input->post('mulai_bekerja'),
    'alamat' => $this->input->post('alamat'),
    'alamat_saat_ini' => $this->input->post('alamat_saat_ini'),
    'KTP' => $this->input->post('KTP'),
    'tempat_lahir' => $this->input->post('tempat_lahir'),
    'tgl_lahir' => $this->input->post('tgl_lahir'),
    'agama' => $this->input->post('agama'),
    'jenis_kelamin' => $this->input->post('jenis_kelamin'),
    'no_hp' => $this->input->post('no_hp'),
    'golongan_darah' => $this->input->post('golongan_darah'),
    'sim' => $this->input->post('sim'),
    'status_pernikahan' => $this->input->post('status_pernikahan'),
    'pendidikan_terakhir' => $this->input->post('pendidikan_terakhir'),
    'instansi_pendidikan' => $this->input->post('instansi_pendidikan'),
    'staff_level' => $this->input->post('staff_level'),
    'divisi' => $this->input->post('divisi'),
    'status_karyawan' => $this->input->post('status_karyawan'),
    'status' => $this->input->post('status'),
    'user_input' => $this->input->post('user_input'),
    'waktu_input' => $date,
    'photo' => $photo
     );  
  $update = $this->karyawan_model->update($data,array("karyawan.id"=>$id)); 
    if ($update)
      {  
        $this->session->set_flashdata('message', "Karyawan berhasil di ubah");
        redirect("karyawan","refresh");
      }else{
        $this->session->set_flashdata('message_error',"Karyawan gagal di ubah");
         redirect("karyawan","refresh");
      }
    

}else{
  if(!empty($_POST)){ 
        $this->session->set_flashdata('message_error',validation_errors());
        return redirect("karyawan/edit/".$id);  
      }else{
      $this->data['id']= $id;
      $data = $this->karyawan_model->getAllById(array("karyawan.id"=>$this->data['id'])); 
      $this->data['KDPGW'] =  (!empty($data))?$data[0]->KDPGW:"";
      $this->data['nama'] =  (!empty($data))?$data[0]->nama:"";
      $this->data['nickname'] =  (!empty($data))?$data[0]->nickname:"";
      $this->data['mulai_bekerja'] =  (!empty($data))?$data[0]->mulai_bekerja:"";
      $this->data['alamat'] =  (!empty($data))?$data[0]->alamat:"";
      $this->data['alamat_saat_ini'] =  (!empty($data))?$data[0]->alamat_saat_ini:"";
      $this->data['KTP'] =  (!empty($data))?$data[0]->KTP:"";
      $this->data['tempat_lahir'] =  (!empty($data))?$data[0]->tempat_lahir:"";
      $this->data['tgl_lahir'] =  (!empty($data))?$data[0]->tgl_lahir:"";
      $this->data['agama'] =  (!empty($data))?$data[0]->agama:"";
      $this->data['jenis_kelamin'] =  (!empty($data))?$data[0]->jenis_kelamin:"";
      $this->data['no_hp'] =  (!empty($data))?$data[0]->no_hp:"";
      $this->data['golongan_darah'] =  (!empty($data))?$data[0]->golongan_darah:"";
      $this->data['sim'] =  (!empty($data))?$data[0]->sim:"";
      $this->data['status_pernikahan'] =  (!empty($data))?$data[0]->status_pernikahan:"";
      $this->data['pendidikan_terakhir'] =  (!empty($data))?$data[0]->pendidikan_terakhir:"";
      $this->data['instansi_pendidikan'] =  (!empty($data))?$data[0]->instansi_pendidikan:"";
      $this->data['staff_level'] =  (!empty($data))?$data[0]->staff_level:"";
      $this->data['divisi'] =  (!empty($data))?$data[0]->divisi:"";
      $this->data['status_karyawan'] =  (!empty($data))?$data[0]->status_karyawan:"";
      $this->data['status'] =  (!empty($data))?$data[0]->status:"";
      $this->data['user_input'] =  (!empty($data))?$data[0]->user_input:"";
      $this->data['waktu_input'] =  (!empty($data))?$data[0]->waktu_input:"";
      $this->data['photo'] =   (!empty($data))?$data[0]->photo:"";
      $this->data['content'] = 'admin/karyawan/edit_v'; 
      
        $this->load->view('admin/layouts/page',$this->data); 
      }  
}
}

 public function destroy(){
    $response_data = array();
        $response_data['status'] = false;
        $response_data['msg'] = "";
        $response_data['data'] = array();   

    $id =$this->uri->segment(3);
    $is_deleted = $this->uri->segment(4);
    if(!empty($id)){
      $this->load->model("karyawan_model");
      $data = array(
        'is_deleted' => ($is_deleted == 1)?0:1,
        'status' => ($is_deleted == 0)?0:1,
      ); 
            $update = $this->karyawan_model->update($data,array("id"=>$id));
            
          $response_data['data'] = $data; 
          $response_data['status'] = true;
    }else{
      $response_data['msg'] = "ID Harus Diisi";
    }
    
        echo json_encode($response_data); 
  }

} 


?>