<?php
defined('BASEPATH') OR exit ('maaf akses di tolak');
require_once APPPATH.'core/Admin_Controller.php';
class Data_vendor extends Admin_controller{
	public function __construct(){
 parent::__construct();
 $this->load->model('vendor_model');
 $this->load->model('karyawan_model');
	}




public function index()
{
  $this->load->helper('url');
  if($this->data['is_can_read']){
	$this->data['content'] = 'admin/vendor/list_v'; 	
	}else{
	$this->data['content'] = 'errors/html/restrict'; 
	}
	$this->load->view('admin/layouts/page',$this->data);  
}

public function dataList()
  {
    $columns = array( 
           0 => 'id', 
           1 => 'k_vendor', 
           2 => 'nama',
           3 => 'kategori_usaha',
           4 => 'jumlah_kendaraan',
           5 => 'alamat',
           6 => 'no_hp',
           7 => 'status',
           8 => ''
        );

      $order = $columns[$this->input->post('order')[0]['column']];
      $dir = $this->input->post('order')[0]['dir'];
      $search = array();
      $limit = 0;
      $start = 0;
      $totalData = $this->vendor_model->getCountAllBy($limit,$start,$search,$order,$dir);       
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
        $datas = $this->vendor_model->getAllBy($limit,$start,$search,$order,$dir);
        $new_data = array();
        if(!empty($datas))
        {
        foreach ($datas as $key=>$data)
        {   
          $delete_url = "";
        
              if($this->data['is_can_delete']){
                if($data->is_deleted == 0){
                $delete_url = "<a href='#' 
                  url='".base_url()."Data_vendor/destroy/".$data->id."/".$data->is_deleted."'
                  class='btn btn-sm btn-success white delete' >Non Aktifkan
                  </a>";
              }else{
                $delete_url = "<a href='#' 
                  url='".base_url()."Data_vendor/destroy/".$data->id."/".$data->is_deleted."'
                  class='btn btn-sm btn-danger white delete' 
                   >Aktifkan
                  </a>";
              } 
            }
        
                $nestedData['id']            = $start+$key+1;
          $nestedData['k_vendor'] = "<a href='".base_url()."Data_vendor/edit/".$data->id."'><i class='fa fa-search'></i> ".$data->k_vendor."</a>";
                $nestedData['nama']  = $data->nama;
                $nestedData['alamat']  = $data->alamat;
                $nestedData['KTP']  = $data->KTP;
                $nestedData['tempat_lahir']  = $data->tempat_lahir." ".$data->tgl_lahir;
                $nestedData['kategori_usaha']  = $data->kategori_usaha;
                $nestedData['jumlah_kendaraan']  = $data->jumlah_kendaraan;
                $nestedData['no_hp']  = $data->no_hp;
               
                if($data->status == "1"){
                $nestedData['status']   = '<span class="btn btn-success btn-xs">Aktif</span>';
              }else{
                  $nestedData['status']   = '<span class="btn btn-danger btn-xs">Tidak Aktif</span>';               
              }
          
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
  
    $data = array (
    'k_vendor' => $this->input->post('k_vendor'),
    'nama' => $this->input->post('nama'),
    'alamat' => $this->input->post('alamat'),
    'KTP' => $this->input->post('KTP'),
    'tempat_lahir' => $this->input->post('tempat_lahir'),
    'tgl_lahir' => $this->input->post('tgl_lahir'),
    'agama' => $this->input->post('agama'),
    'jenis_kelamin' => $this->input->post('jenis_kelamin'),
    'no_hp' => $this->input->post('no_hp'),
    'kategori_usaha' => $this->input->post('kategori_usaha'),
    'jumlah_kendaraan' => $this->input->post('jumlah_kendaraan'),
    'status' => $this->input->post('status'),
    'user_input' => $this->input->post('user_input'),
    'waktu_input' => $this->input->post('waktu_input')
     );  
   
   
   
    $insert_barang = $this->vendor_model->insert($data);
    if ($insert_barang)
      {  
        $this->session->set_flashdata('message', "Vendor Baru Berhasil Disimpan");
        redirect("Data_vendor");
      }else{
        $this->session->set_flashdata('message_error',"Vendor Baru Gagal Disimpan");
        redirect("Data_vendor");
      }     
                

  }else{
       
    $this->data['content'] = 'admin/vendor/create_v';
    $this->data['waktu_input'] = $date;
    $this->load->view('admin/layouts/page',$this->data);
  }
 }
 public function edit($id){
 $this->form_validation->set_rules('nama',"Name Is Required", 'trim|required'); 

if($this->form_validation->run() === TRUE){
 
$date = date('y-m-d H:i:s');
 $data = array (
    'k_vendor' => $this->input->post('k_vendor'),
    'nama' => $this->input->post('nama'),
    'alamat' => $this->input->post('alamat'),
    'KTP' => $this->input->post('KTP'),
    'tempat_lahir' => $this->input->post('tempat_lahir'),
    'tgl_lahir' => $this->input->post('tgl_lahir'),
    'agama' => $this->input->post('agama'),
    'jenis_kelamin' => $this->input->post('jenis_kelamin'),
    'no_hp' => $this->input->post('no_hp'),
    'kategori_usaha' => $this->input->post('kategori_usaha'),
    'jumlah_kendaraan' => $this->input->post('jumlah_kendaraan'),
    'status' => $this->input->post('status'),
    'user_input' => $this->input->post('user_input'),
    'waktu_input' => $this->input->post('waktu_input')
     );   
  $update = $this->vendor_model->update($data,array("vendor.id"=>$id)); 
    if ($update)
      {  
        $this->session->set_flashdata('message', "vendor berhasil di ubah");
        redirect("Data_vendor","refresh");
      }else{
        $this->session->set_flashdata('message_error',"vendor gagal di ubah");
         redirect("Data_vendor","refresh");
      }
    

}else{
  if(!empty($_POST)){ 
        $this->session->set_flashdata('message_error',validation_errors());
        return redirect("Data_vendor/edit/".$id);  
      }else{
      $this->data['id']= $id;
      $data = $this->vendor_model->getAllById(array("vendor.id"=>$this->data['id'])); 
      $this->data['k_vendor'] =  (!empty($data))?$data[0]->k_vendor:"";

      $this->data['nama'] =  (!empty($data))?$data[0]->nama:"";
      $this->data['alamat'] =  (!empty($data))?$data[0]->alamat:"";
      $this->data['KTP'] =  (!empty($data))?$data[0]->KTP:"";
      $this->data['tempat_lahir'] =  (!empty($data))?$data[0]->tempat_lahir:"";
      $this->data['tgl_lahir'] =  (!empty($data))?$data[0]->tgl_lahir:"";
      $this->data['agama'] =  (!empty($data))?$data[0]->agama:"";
      $this->data['jenis_kelamin'] =  (!empty($data))?$data[0]->jenis_kelamin:"";
      $this->data['no_hp'] =  (!empty($data))?$data[0]->no_hp:"";
      $this->data['status'] =  (!empty($data))?$data[0]->status:"";
      $this->data['user_input'] =  (!empty($data))?$data[0]->user_input:"";
      $this->data['waktu_input'] =  (!empty($data))?$data[0]->waktu_input:"";
      $this->data['kategori_usaha'] =   (!empty($data))?$data[0]->kategori_usaha:"";
    $this->data['jumlah_kendaraan'] =   (!empty($data))?$data[0]->jumlah_kendaraan:"";
      $this->data['content'] = 'admin/vendor/edit_v'; 
      
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
      $this->load->model("vendor_model");
      $data = array(
        'is_deleted' => ($is_deleted == 1)?0:1,
        'status' => ($is_deleted == 0)?0:1,
      ); 
            $update = $this->vendor_model->update($data,array("id"=>$id));
            
          $response_data['data'] = $data; 
          $response_data['status'] = true;
    }else{
      $response_data['msg'] = "ID Harus Diisi";
    }
    
        echo json_encode($response_data); 
  }

} 


?>