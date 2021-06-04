<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/Admin_Controller.php';
class Group extends Admin_Controller {
 	public function __construct()
	{
		parent::__construct();
		$this->load->model('groups_model'); 
	}
	public function index()
	{
		$this->load->helper('url');
		if($this->data['is_can_read']){
			$this->data['content'] = 'admin/groups/list_v'; 	
		}else{
			$this->data['content'] = 'errors/html/restrict'; 
		}
		
		$this->load->view('admin/layouts/page',$this->data);  
	}

	public function create()
	{ 
		// $this->form_validation->set_rules('area_id',"Area Is Required", 'trim|required'); 
		$this->form_validation->set_rules('name',"Name Is Required", 'trim|required');  

		if ($this->form_validation->run() === TRUE)
		{ 
			$data = array( 
				'name' => $this->input->post('name'),
				'description' => $this->input->post('description'),
				// 'area_id' => $this->input->post('area_id')
			); 
			$insert_groups = $this->groups_model->insert($data);


			if ($insert_groups)
			{  

				$this->session->set_flashdata('message', "Grup Baru Berhasil Disimpan");
				redirect("group");
			}
			else
			{
				$this->session->set_flashdata('message_error',"Grup Baru Gagal Disimpan");
				redirect("group");
			}
		}else{  
			$this->load->model("area_model");
			$this->data['areas'] = $this->area_model->getAllById(array());
			$this->data['content'] = 'admin/groups/create_v'; 
			$this->load->view('admin/layouts/page',$this->data); 
		}
	} 

	public function edit($id)
	{ 
		$this->form_validation->set_rules('name', "Name Is Required", 'trim|required'); 
		
		$this->load->model("area_model");
	 	$this->data['areas'] = $this->area_model->getAllById(array());
		if ($this->form_validation->run() === TRUE)
		{
		 	$group_id = $id;
			$data = array( 
				'name' => $this->input->post('name'),
				'description' => $this->input->post('description'),
				// 'area_id' => $this->input->post('area_id')
			);
			$update = $this->groups_model->update($data,array("groups.id"=>$id)); 
			if ($update)
			{  
				$this->session->set_flashdata('message', "Grup Berhasil Diubah");
				redirect("group","refresh");
			}else{
				$this->session->set_flashdata('message_error', "Grup Gagal Diubah");
				redirect("group","refresh");
			}
		} 
		else
		{
			if(!empty($_POST)){ 
				$this->session->set_flashdata('message_error',validation_errors());
				return redirect("group/edit/".$id);	
			}else{
				$this->data['id']= $id;
				$data = $this->groups_model->getAllById(array("groups.id"=>$this->data['id'])); 

				$this->data['area_id'] =   (!empty($data))?$data[0]->area_id:"";
				$this->data['name'] =   (!empty($data))?$data[0]->name:"";
				$this->data['description'] =   (!empty($data))?$data[0]->description:""; 
				
				$this->data['content'] = 'admin/groups/edit_v'; 
				$this->load->view('admin/layouts/page',$this->data); 
			}  
		}    
		
	} 

	public function dataList()
	{
	 	$columns = array( 
            0 =>'id', 
            1 =>'code',
            2=> 'name',
            3=> 'description',
            4=> ''
        );

		
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
  		$search = array();
  		$limit = 0;
  		$start = 0;
        $totalData = $this->groups_model->getCountAllBy($limit,$start,$search,$order,$dir); 
        

        if(!empty($this->input->post('search')['value'])){
        	$search_value = $this->input->post('search')['value'];
           	$search = array( 
           		"groups.name"=>$search_value,
           		"groups.description"=>$search_value
           	); 
           	$totalFiltered = $this->groups_model->getCountAllBy($limit,$start,$search,$order,$dir); 
        }else{
        	$totalFiltered = $totalData;
        } 
       
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
     	$datas = $this->groups_model->getAllBy($limit,$start,$search,$order,$dir);
     	
        $new_data = array();
        if(!empty($datas))
        {
         
            foreach ($datas as $key=>$data)
            {   
            	$edit_url = "";
     			$delete_url = "";
     		
            	if($this->data['is_can_edit'] && $data->is_deleted == 0){
            		$edit_url = "<a href='".base_url()."group/edit/".$data->id."' class='btn btn-sm btn-info white'><i class='fa fa-pencil'></i> Ubah</a>";
            	}  
            	if($this->data['is_can_delete']){
	            	if($data->is_deleted == 0){
	        			$delete_url = "<a href='#' 
	        				url='".base_url()."group/destroy/".$data->id."/".$data->is_deleted."'
	        				class='btn btn-sm btn-danger white delete' >NonAktifkan
	        				</a>";
	        		}else{
	        			$delete_url = "<a href='#' 
	        				url='".base_url()."group/destroy/".$data->id."/".$data->is_deleted."'
	        				class='btn btn-sm btn-danger  white delete' 
	        				 >Aktifkan
	        				</a>";
	        		}  
        		}
                $nestedData['id'] = $start+$key+1;
                $nestedData['area_name'] = '';
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

	public function getGroupsByArea(){
		$response_data = array();
        $response_data['status'] = false;
        $response_data['msg'] = "";
        $response_data['data'] = array();   

		$area_id = $this->input->get('area_id');
 		if(!empty($area_id)){
 			$this->load->model("groups_model");
			$data = $this->groups_model->getAllById(array("groups.area_id"=>$area_id)); 
        	$response_data['data'] = $data; 
         	$response_data['status'] = true;
 		}else{
 		 	$response_data['msg'] = "Area ID Harus Diisi";
 		}
		
        echo json_encode($response_data); 
	}

	public function destroy(){
		$response_data = array();
        $response_data['status'] = false;
        $response_data['msg'] = "";
        $response_data['data'] = array();   

		$id =$this->uri->segment(3);
		$is_deleted = $this->uri->segment(4);
 		if(!empty($id)){
 			$this->load->model("groups_model");
			$data = array(
				'is_deleted' => ($is_deleted == 1)?0:1
			); 
			$update = $this->groups_model->update($data,array("id"=>$id));

        	$response_data['data'] = $data; 
         	$response_data['status'] = true;
 		}else{
 		 	$response_data['msg'] = "ID Harus Diisi";
 		}
		
        echo json_encode($response_data); 
	}
}
