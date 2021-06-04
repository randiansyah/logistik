<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/Admin_Controller.php';
class Role extends Admin_Controller {
 	public function __construct()
	{
		parent::__construct(); 
	 	$this->load->model('roles_model');
	}

	public function index()
	{

		$this->load->helper('url');
		if($this->data['is_can_read']){
			$this->data['content'] = 'admin/role/list_v'; 	
		}else{
			$this->data['content'] = 'errors/html/restrict'; 
		}
		
		$this->load->view('admin/layouts/page',$this->data);  
	}

	public function create()
	{  
		$this->form_validation->set_rules('name',"Nama Harus Diisi", 'trim|required'); 
		 
		if ($this->form_validation->run() === TRUE)
		{ 
			$data = array(
				'name' => $this->input->post('name'), 
				'description' => $this->input->post('description')
			); 
			if ($this->roles_model->insert($data))
			{ 
				$this->session->set_flashdata('message', "Role Baru Berhasil Disimpan");
				redirect("role");
			}
			else
			{
				$this->session->set_flashdata('message_error',"Role Baru Gagal Disimpan");
				redirect("role");
			}
		}else{    
			$this->data['content'] = 'admin/role/create_v'; 
			$this->load->view('admin/layouts/page',$this->data); 
		}
	} 

	public function edit($id)
	{  
		$this->form_validation->set_rules('name', "Name Harus Diisi", 'trim|required');

		if ($this->form_validation->run() === TRUE)
		{
			$data = array(
				'name' => $this->input->post('name'), 
				'description' => $this->input->post('description')
			);
			$update = $this->roles_model->update($data,array("roles.id"=>$id));
			if ($update)
			{ 
				$this->session->set_flashdata('message', "Role Berhasil Diubah");
				redirect("role","refresh");
			}else{
				$this->session->set_flashdata('message_error', "Role Gagal Diubah");
				redirect("role","refresh");
			}
		} 
		else
		{
			if(!empty($_POST)){ 
				$id = $this->input->post('id'); 
				$this->session->set_flashdata('message_error',validation_errors());
				return redirect("role/edit/".$id);	
			}else{
				$this->data['id']= $this->uri->segment(3);
				$roles = $this->roles_model->getAllById(array("roles.id"=>$this->data['id']));  
				$this->data['name'] =   (!empty($roles))?$roles[0]->name:"";
				$this->data['description'] =   (!empty($roles))?$roles[0]->description:""; 
				
				$this->data['content'] = 'admin/role/edit_v'; 
				$this->load->view('admin/layouts/page',$this->data); 
			}  
		}    
		
	} 

	public function dataList()
	{

		 $columns = array( 
            0 =>'id',  
            1 =>'name', 
            2=> 'description',
            3=> ''
        );

		
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
  		$search = array();
  		$limit = 0;
  		$start = 0;
        $totalData = $this->roles_model->getCountAllBy($limit,$start,$search,$order,$dir); 
        

        if(!empty($this->input->post('search')['value'])){
        	$search_value = $this->input->post('search')['value'];
           	$search = array(
           		"roles.name"=>$search_value,
           		"roles.description"=>$search_value
           	); 
           	$totalFiltered = $this->roles_model->getCountAllBy($limit,$start,$search,$order,$dir); 
        }else{
        	$totalFiltered = $totalData;
        } 
       
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
     	$datas = $this->roles_model->getAllBy($limit,$start,$search,$order,$dir);
     	
        $new_data = array();
        if(!empty($datas))
        {
        	 
            foreach ($datas as $key=>$data)
            {  

            	$edit_url = "";
     			$delete_url = "";
     		
            	if($this->data['is_can_edit'] && $data->is_deleted == 0){
            		$edit_url = "<a href='".base_url()."role/edit/".$data->id."' class='btn btn-sm btn-info white'><i class='fa fa-pencil'></i> Ubah</a>";
            	}  
            	if($this->data['is_can_delete']){
	            	if($data->is_deleted == 0){
	        			$delete_url = "<a href='#' 
	        				url='".base_url()."role/destroy/".$data->id."/".$data->is_deleted."'
	        				class='btn btn-sm btn-danger white delete' >Non Aktifkan
	        				</a>";
	        		}else{
	        			$delete_url = "<a href='#' 
	        				url='".base_url()."role/destroy/".$data->id."/".$data->is_deleted."'
	        				class='btn btn-sm btn-danger white delete' 
	        				 >Aktifkan
	        				</a>";
	        		} 
        		}
            	
                $nestedData['id'] = $start+$key+1; 
                $nestedData['name'] = $data->name; 
                $nestedData['description'] = substr(strip_tags($data->description),0,50);
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
 

	public function destroy(){
		$response_data = array();
        $response_data['status'] = false;
        $response_data['msg'] = "";
        $response_data['data'] = array();   

		$id =$this->uri->segment(3);
		$is_deleted = $this->uri->segment(4);
 		if(!empty($id)){
 			$this->load->model("roles_model");
			$data = array(
				'is_deleted' => ($is_deleted == 1)?0:1
			); 
			$update = $this->roles_model->update($data,array("id"=>$id));

        	$response_data['data'] = $data; 
         	$response_data['status'] = true;
 		}else{
 		 	$response_data['msg'] = "ID Harus Diisi";
 		}
		
        echo json_encode($response_data); 
	}
}
