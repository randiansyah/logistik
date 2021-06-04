<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/Admin_Controller.php';
class Privileges extends Admin_Controller {
 	public function __construct()
	{
		parent::__construct();
		$this->load->model('privilleges_model');
		$this->load->model('roles_model');
	}
	public function index()
	{
		$this->load->helper('url');
		if($this->data['is_can_read']){
			$this->data['content'] = 'admin/privilleges/list_v'; 	
		}else{
			$this->data['content'] = 'errors/html/restrict'; 
		}
		
		$this->load->view('admin/layouts/page',$this->data);  
	}

	public function create()
	{ 
	 	
	 	$this->form_validation->set_rules('role_id', "Role Harus Diisi", 'trim|required|is_unique[privilleges.role_id]'); 

		if ($this->form_validation->run() === TRUE)
		{ 

			$menus = $this->input->post('functions');  
 			$parentMenu = array();
		  	$status = true;
		 	$data = [];
		 	foreach ($menus as $menu_id => $dataFunction) { 
				foreach ($dataFunction as $function_id => $function) { 
					$data[] = array(
						"menu_id"=>$menu_id,
						"function_id"=>$function,
						"role_id"=>$this->input->post('role_id'),
					);
				}
				$parentMenu[] = $menu_id;
			}

			$insert = $this->privilleges_model->insert_batch($data);
			if(!$insert) $status = false;

			//insert root
			$data = array(
				"menu_id"=>1,
				"function_id"=>1,
				"role_id"=>$this->input->post('role_id')
			);
			$insert = $this->privilleges_model->insert($data); 

			//Insert Menu Utama
			$dataParent = $this->menu_model->getDataParentByMenus(implode(",",$parentMenu));
			$data = [];
			foreach ($dataParent as $key => $value) {
				$data[] = array(
					"menu_id"=>$value->id,
					"function_id"=>1,
					"role_id"=>$this->input->post('role_id')
				);
			}
			$insert = $this->privilleges_model->insert_batch($data);
			if(!$insert) $status = false;
			 
			if ($status)
			{ 
				$this->session->set_flashdata('message', "Privilleges Baru Berhasil Disimpan");
				redirect("privileges");
			}
			else
			{
				$this->session->set_flashdata('message_error',"Privilleges Baru Gagal Disimpan");
				redirect("privileges");
			}
		}else{  
			if(!empty($_POST)){  
				$this->session->set_flashdata('message_error',validation_errors());
				return redirect("privileges/create/");	
			}else{
				$this->load->model("roles_model"); 
		 		$this->data['roles'] = $this->roles_model->getAllById(); 
		 		
		 		$this->load->model("menu_model"); 
		 		$this->load->model("function_model"); 
		 		$menus = $this->menu_model->getAllById(); 
		 		$functions = $this->function_model->getAllMenuFunctionBy(null,null,null,null,null); 
				
		 		$dataMenus = array();
	 			foreach ($functions as $key => $function) { 
	 			  	$dataMenus[$function->id]["id"] = $function->id;
	 			  	$dataMenus[$function->id]["name"] = $function->name; 
	 			  	$dataMenus[$function->id]["functions"][] = array(
	 			  		"id"=>$function->function_id,
	 			  		"name"=>$function->function_name
	 			  	);
	 			}  
	 			$this->data['menus'] = $dataMenus;

				$this->data['content'] = 'admin/privilleges/create_v'; 
				$this->load->view('admin/layouts/page',$this->data); 
			}
		}
	} 

	public function edit($id)
	{  
		$this->form_validation->set_rules('role_id', "Role Harus Diisi", 'trim|required'); 
	 
		if ($this->form_validation->run() === TRUE)
		{
		 
			$functions = $this->input->post('functions');  
 			$deleted = $this->privilleges_model->delete(array("role_id"=>$this->input->post('role_id')));
		  	$status = true;
		  	$data = [];
		  	$parentMenu = [];
		 	foreach ($functions as $menu_id => $dataFunction) { 
				foreach ($dataFunction as $function_id => $function) { 
					$data[] = array(
						"menu_id"=>$menu_id,
						"function_id"=>$function,
						"role_id"=>$this->input->post('role_id'),
					);
				}
				$parentMenu[] = $menu_id;
			}

			$insert = $this->privilleges_model->insert_batch($data);


			//insert root
			$data = array(
				"menu_id"=>1,
				"function_id"=>1,
				"role_id"=>$this->input->post('role_id')
			);
			$insert = $this->privilleges_model->insert($data); 

			//Insert Menu Utama
			$dataParent = $this->menu_model->getDataParentByMenus(implode(",",$parentMenu));
			$data = [];
			foreach ($dataParent as $key => $value) {
				$data[] = array(
					"menu_id"=>$value->id,
					"function_id"=>1,
					"role_id"=>$this->input->post('role_id')
				);
			}
			$insert = $this->privilleges_model->insert_batch($data);
			if ($status)
			{ 
				$this->session->set_flashdata('message', "Privilleges Berhasil Diubah");
				redirect("privileges","refresh");
			}else{
				$this->session->set_flashdata('message_error', "Privilleges Gagal Diubah");
				redirect("privileges","refresh");
			}
		} 
		else
		{
			$this->load->model("menu_model"); 
	 		$this->load->model("function_model"); 
	 		$menus = $this->menu_model->getAllById(); 
	 		$functions = $this->function_model->getAllMenuFunction(); 
	 		$dataMenus = array();
	 	 
 			foreach ($functions as $key => $function) { 
 			  	$dataMenus[$function->id]["id"] = $function->id;
 			  	$dataMenus[$function->id]["name"] = $function->name; 
 			  	$dataMenus[$function->id]["functions"][] = array(
 			  		"id"=>$function->function_id,
 			  		"name"=>$function->function_name
 			  	);
 			} 

 			$this->data['menus'] = $dataMenus;
			if(!empty($_POST)){ 
				$this->session->set_flashdata('message_error',validation_errors());
				return redirect("privileges/edit/".$id);	
			}else{
				$this->data['id']= $id;
				$data = $this->privilleges_model->getOneBy(array("roles.id"=>$this->data['id'])); 
				$data_role = $this->roles_model->getOneBy(["ID"=>$this->data['id']]);
				$dataMenus = array();
	 	 		if(!empty($data)){
	 	 			foreach ($data as $key => $function) {  
		 			  	$dataMenus[$function->menu_id]["menu_id"] = $function->menu_id;  
		 			  	$dataMenus[$function->menu_id]["functions"][]['id'] =  $function->function_id;
	 				}
	 	 		}
	 			$this->data['menu_selecteds'] = $dataMenus;
				$this->data['role_id'] =   (!empty($data))?$data[0]->role_id:"";  
				$this->data['role_name'] =   (!empty($data_role))?$data_role->name:"";  
				$this->data['content'] = 'admin/privilleges/edit_v'; 
				$this->load->view('admin/layouts/page',$this->data); 
			}  
		}    
		
	} 
	public function detail()
	{   
		$this->load->model("menu_model"); 
 		$this->load->model("function_model"); 
 		$menus = $this->menu_model->getAllById(); 
 		$functions = $this->function_model->getAllMenuFunctionBy(null,null,null,null,null); 

 		$dataMenus = array();
 	 
			foreach ($functions as $key => $function) { 
			  	$dataMenus[$function->id]["id"] = $function->id;
			  	$dataMenus[$function->id]["name"] = $function->name; 
			  	$dataMenus[$function->id]["functions"][] = array(
			  		"id"=>$function->function_id,
			  		"name"=>$function->function_name
			  	);
			} 

			$this->data['menus'] = $dataMenus;
		if(!empty($_POST)){ 
			$id = $this->input->post('id'); 
			$this->session->set_flashdata('message_error',validation_errors());
			return redirect("privileges/edit/".$id);	
		}else{
			$this->data['id']= $this->uri->segment(3);
			$data = $this->privilleges_model->getAllById(array("role_id"=>$this->data['id'])); 
			$dataMenus = array();
 	 
 			foreach ($data as $key => $function) {  
 			  	$dataMenus[$function->menu_id]["menu_id"] = $function->menu_id;  
 			  	$dataMenus[$function->menu_id]["functions"][]['id'] =  $function->function_id;
 			} 
 			
 			$this->data['menu_selecteds'] = $dataMenus;

			$this->load->model("roles_model"); 
			$this->data['roles'] = $this->roles_model->getAllById();   
			$this->data['role_id'] =   (!empty($data))?$data[0]->role_id:"";
			  
			$this->data['content'] = 'admin/privilleges/detail_v'; 
			$this->load->view('admin/layouts/page',$this->data); 
		}   
	} 

	public function dataList()
	{
		$columns = array( 
            0 =>'id',  
            1 =>'roles.name', 
            2=> ''
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
           		"roles.name"=>$search_value
           	); 
           	$totalFiltered = $this->roles_model
           					->getCountAllBy($limit,$start,$search,$order,$dir); 
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
     			$view_url = "";
     		
            	if($this->data['is_can_edit']){ 
            		$edit_url = "<a href='".base_url()."privileges/edit/".$data->id."' class='btn btn-sm btn-info white'><i class='fa fa-pencil'></i> Edit</a>";
            	}  
            
            	if($this->data['is_can_delete']){
            		$delete_url = "<a  href='#' url='".base_url()."privileges/destroy/".$data->id."' class='btn btn-sm btn-danger white delete'><i class='fa fa-trash-o'></i> Delete</a>";
            	}  

                $nestedData['id'] = $start+$key+1; 
                $nestedData['role_name'] = $data->name; 
           		$nestedData['action'] = $edit_url." ".$delete_url." ".$view_url;   
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

	public function destroy($id){
		$response_data = array();
        $response_data['status'] = false;
        $response_data['msg'] = "";
        $response_data['data'] = array();    
 		if(!empty($id)){ 
			$where = array(
				'role_id' => $id
			); 
			$update = $this->privilleges_model->delete($where);

        	$response_data['data'] = $where; 
         	$response_data['status'] = true;
 		}else{
 		 	$response_data['msg'] = "ID Harus Diisi";
 		}
		
        echo json_encode($response_data); 
	}
}
