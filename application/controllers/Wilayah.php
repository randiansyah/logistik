<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/Admin_Controller.php';
class Wilayah extends Admin_Controller{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('wilayah_model');
    }
    public function index(){
        $this->load->helper('url'); 
        if($this->data['is_can_read']){ 
            $this->data['content'] = 'admin/wilayah/list_v';    
                    $this->data['data_provinsi'] = $this->wilayah_model->getAllProvince();              
        }else{
            $this->data['content'] = 'errors/html/restrict'; 
        }
        
        $this->load->view('admin/layouts/page',$this->data);
    }
    public function dataList()
    {
        $columns = array( 
            0 =>'IDWILAYAH', 
            1 =>'KDPROP',
            2=> 'KDKAB',
            3=> 'kdkec',
            4=> 'kddesa',
            5=> 'nmprop',
            6=> 'nmkab',
            7=> 'nmkec',
            8=> 'nmdesa' 
        );

        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $search = array();
        $limit = 0;
        $start = 1;
        $totalData = $this->wilayah_model->getCountAllBy($limit,$start,$search,$order,$dir); 

        $searchColumn = $this->input->post('columns');
        $isSearchColumn = false;         

        if(!empty($searchColumn[1]['search']['value'])){
            $value = $searchColumn[1]['search']['value'];
            $isSearchColumn = true;
            $search['NMKEC'] = $value;
        }  

        if(!empty($searchColumn[2]['search']['value'])){
            $value = $searchColumn[2]['search']['value'];
            $isSearchColumn = true;
            $search['NMDESA'] = $value;
        } 
        if(!empty($searchColumn[3]['search']['value'])){
            $value = $searchColumn[3]['search']['value'];
            $isSearchColumn = true;
            $search['kdkec'] = $value;
        } 
        if(!empty($searchColumn[4]['search']['value'])){
            $value = $searchColumn[4]['search']['value'];
            $isSearchColumn = true;
            $search['kddesa'] = $value;
        }  

        if($isSearchColumn){ 
            $totalFiltered = $this->wilayah_model->getCountAllBy($limit,$start,$search,$order,$dir); 
              
        }else{
            $totalFiltered = $totalData;
        }   
       
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $datas = $this->wilayah_model->getAllBy($limit,$start,$search,$order,$dir);
        
        $new_data = array();
        if(!empty($datas))
        {
         
            foreach ($datas as $key=>$data)
            {   
                $edit_url = "";
                $delete_url = "";
             
                $nestedData['id'] = $start+$key+1;
                $nestedData['kdwilayah'] = $data->IDWILAYAH;
                $nestedData['kdprop'] = $data->KDPROP;
                $nestedData['kdkab'] = $data->KDKAB;
                $nestedData['kdkec'] = $data->KDKEC;
                $nestedData['kddesa'] = $data->KDDESA;
                $nestedData['nmprop'] = $data->NMPROP;
                $nestedData['nmkab'] = $data->NMKAB;
                $nestedData['nmkec'] = $data->NMKEC;
                $nestedData['nmdesa'] = $data->NMDESA; 
                $nestedData['action'] = $edit_url." ".$delete_url;   
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

    public function exportCSV()
    { 
       // file name 
       $filename = 'datawilayah'.date('Ymd').'.csv'; 
       header("Content-Description: File Transfer"); 
       header("Content-Disposition: attachment; filename=$filename"); 
       header("Content-Type: application/csv; ");
       
       // get data 
       $datas = $this->wilayah_model->getAllById();

       // file creation 
       $file = fopen('php://output', 'w');
     
       $header = array("IDWILAYAH","KDPROP","KDKAB","KDKEC","KDDESA","NMPROP","NMKAB","NMKEC","NMDESA"); 
       fputcsv($file, $header);
       foreach ($datas as $line){ 
         fputcsv($file,array($line->IDWILAYAH,$line->KDPROP,$line->KDKAB,$line->KDKEC,$line->KDDESA,$line->NMPROP,$line->NMKAB,$line->NMKEC,$line->NMDESA));
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
        $is_deleted = $this->uri->segment(4);
        if(!empty($id)){
            $data = array(
                'is_deleted' => ($is_deleted == 1)?0:1
            ); 
            $update = $this->wilayah_model->update($data,array("kd_prop"=>$id));

            $response_data['data'] = $data; 
            $response_data['status'] = true;
        }else{
            $response_data['msg'] = "ID Harus Diisi";
        }
        
        echo json_encode($response_data); 
    }

    public function get_kabupaten()
    {
        $response_data = array();

        $kdprop = $this->input->get('kdprop');
        $data = array();
 
            $data = $this->wilayah_model->getAllKabupaten(array("kdprop"=>$kdprop));
    

        $response_data['status'] = true;
        $response_data['msg'] = "";
        $response_data['data'] = $data;


        echo json_encode($response_data);
    }

    

       
    public function get_kecamatan()
    {
        $response_data = array();

        $kdprop = $this->input->get('kdprop');  
        $kdkab = $this->input->get('kdkab');
        $data = array();
        if ($this->data['is_superadmin']){
            $where_in["kdkab"] = $kdkab;
            $data = $this->wilayah_model->getAllKecamatanWhereIn(array("kdprop"=>$kdprop),$where_in);
        }else{
            if($this->data['users_wilayah'][0]->KDKEC==0){
                for ($i = 0; $i < count($this->data['users_wilayah']); $i++) { 
                    $where_in["kdkab"] = $kdkab; 
                    @$data += array_merge($data, $this->wilayah_model->getAllKecamatanWhereIn(array("kdprop"=>$kdprop),$where_in));
                }
            } else {
                $kecamatan = array();
                for ($i = 0; $i < count($this->data['users_wilayah']); $i++) {  
                    $kec = $this->data['users_wilayah'][$i]->KDKAB.$this->data['users_wilayah'][$i]->KDKEC;
                    array_push($kecamatan, $kec);
                        
                }
                
                if($this->data['users_wilayah'][0]->KDKEC==0){
                $where_in['kdkab'] = $kdkab;
                }else{
                    $kdkec = array();
                    foreach ($kecamatan as $key => $value) {
                    if (in_array(substr($value, 0, 2),array($kdkab))) {
                        array_push($kdkec, substr($value, 2, 3));
                    }
                    }
                    $where_in['kdkab'] = $kdkab;
                    $where_in['kdkec'] = $kdkec;
                }
                $data = $this->wilayah_model->getAllKecamatanWhereIn(array("kdprop"=>$kdprop),$where_in);
            }
        } 
        

        $response_data['status'] = true;
        $response_data['msg'] = ""; 
        $response_data['data'] = $data;
        

        echo json_encode($response_data);
    }
    public function get_kelurahan_user()
    {
        $response_data = array();

        $kdprop = $this->input->get('kdprop');  
        $kdkab = $this->input->get('kdkab');  
        $kdkec = substr($this->input->get('kdkec'),2,3);
        $kdkec_pure = $this->input->get('kdkec');

        $data = array();
        if ($this->data['is_superadmin']){
            $data = $this->wilayah_model->getAllDesaWhereInUser(
                array("kdprop"=>$kdprop),$kdkab,$kdkec_pure
            );
        }else{
            $desa = array();
            for ($i = 0; $i < count($this->data['users_wilayah']); $i++) {  
                $des = $this->data['users_wilayah'][$i]->KDKEC.$this->data['users_wilayah'][$i]->KDDESA;
                array_push($desa, $des);
                    
            }
            
            if($this->data['users_wilayah'][0]->KDDESA==0){
               $where_in['kdkab'] = $kdkab;
               $where_in['kdkec'] = $kdkec;
            }else{
                $kddesa = array();
                foreach ($desa as $key => $value) {
                  if (in_array(substr($value, 0, 3),array($kdkec))) {
                    array_push($kddesa, substr($value, 3, 3));
                  }
                }
                $where_in['kdkab'] = $kdkab;
                $where_in['kdkec'] = $kdkec;
                $where_in['kddesa'] = $kddesa;
            }
            $data = $this->wilayah_model->getAllKelurahan(array("kdprop"=>$kdprop),$where_in);
            
        }
        

        $response_data['status'] = true;
        $response_data['msg'] = "";
        $response_data['data'] = $data;   
        

        echo json_encode($response_data);
    }

    public function get_kelurahan()
    {
        $response_data = array();

        $kdprop = $this->input->get('kdprop');  
        $kdkab = $this->input->get('kdkab');  
        $kdkec = $this->input->get('kdkec');
        $kdkec_pure = $this->input->get('kdkec');

        $data = array();
        if ($this->data['is_superadmin']){
            $data = $this->wilayah_model->getAllDesaWhereIn(
                array("kdprop"=>$kdprop),$kdkab,$kdkec_pure
            );
        }else{
            $desa = array();
            for ($i = 0; $i < count($this->data['users_wilayah']); $i++) {  
                $des = $this->data['users_wilayah'][$i]->KDKEC.$this->data['users_wilayah'][$i]->KDDESA;
                array_push($desa, $des);
                    
            }
            
            if($this->data['users_wilayah'][0]->KDDESA==0){
               $where_in['kdkab'] = $kdkab;
               $where_in['kdkec'] = $kdkec;
            }else{
                $kddesa = array();
                foreach ($desa as $key => $value) {
                  if (in_array(substr($value, 0, 3),array($kdkec))) {
                    array_push($kddesa, substr($value, 3, 3));
                  }
                }
                $where_in['kdkab'] = $kdkab;
                $where_in['kdkec'] = $kdkec;
                $where_in['kddesa'] = $kddesa;
            }
            $data = $this->wilayah_model->getAllKelurahan(array("kdprop"=>$kdprop),$where_in);
            
        }
        

        $response_data['status'] = true;
        $response_data['msg'] = "";
        $response_data['data'] = $data;   
        

        echo json_encode($response_data);
    }
}
?>