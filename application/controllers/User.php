<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/Admin_Controller.php';
class User extends Admin_Controller {
 	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('ion_auth_model');
		$this->load->model('roles_model');
		$this->load->model('user_roles_model');

	}
	public function index()
	{
		$this->load->helper('url');
		if($this->data['is_can_read']){ 
			$this->data['content'] = 'admin/user/list_v'; 	
			$this->data['roles'] = $this->roles_model->getAllById();
		}else{
			$this->data['content'] = 'errors/html/restrict'; 
		}
		
		$this->load->view('admin/layouts/page',$this->data);  
	}


	public function create()
	{ 
		$this->form_validation->set_rules('first_name',"Nama Lengkap", 'trim|required');
		//$this->form_validation->set_rules('phone',"No Ponsel", 'trim|required|is_unique[users.phone]');
		$this->form_validation->set_rules('email',"Email", 'trim|required|is_unique[users.email]');
		$this->form_validation->set_rules('role_id',"Role", 'trim|required');
		$this->form_validation->set_rules('password',"Password", 'trim|required');
		$this->form_validation->set_rules('password_confirm',"Konfirmasi Password", 'trim|required');
		if ($this->form_validation->run() === TRUE)
		{
			$role_id = $this->input->post('role_id');
			
			$data = array(
				'first_name' => $this->input->post('first_name'),
	
				'nik' 		 => $this->input->post('nik'),
				'email' 	 => $this->input->post('email'),
				'real_password' 	 => $this->input->post('password'),
				'roles'=> $this->input->post('role_id'),
				'active' 	 => 1,
				'is_deleted' => 0
			);
			$role = array($this->input->post('role_id'));
 			$username = $this->input->post('username');
 			$password = $this->input->post('password'); 
 			$email = $this->input->post('email'); 
			$insert = $this->ion_auth->register($username, $password,$email, $data,$role);
			 
			if ($insert)
			{ 	
				$this->session->set_flashdata('message','Berhasil Membuat User');
			 	redirect("user");
			
			}else{

				$this->session->set_flashdata('message_error', "Gagal Membuat User Baru");
				redirect("user");
			}
			 
		}else{ 
		 	$this->data['roles']   = $this->roles_model->getAllById();
			$this->data['content'] = 'admin/user/create_v'; 
			$this->load->view('admin/layouts/page',$this->data); 
		}
	} 


	public function edit($id)
	{ 
		$this->form_validation->set_rules('email',"Email", 'trim|required');  
		//$this->form_validation->set_rules('name',"Nama", 'trim|required'); 
		$this->form_validation->set_rules('role_id',"Role", 'trim|required');
		   
		if ($this->form_validation->run() === TRUE)
		{

  $identity = $this->input->post('email');
  $old_password = $this->input->post('old_password');
  $new_password = $this->input->post('new_password');

  if(!empty($new_password)){
   $real_password = $new_password;
   }else{
   $real_password = $old_password;
   }


			$data = array(
				'username' => $this->input->post('name'),
				'email' => $this->input->post('email'),
				'real_password' => $real_password,
			);
			$user_id = $this->input->post('id'); 
			$role_id = $this->input->post('role_id');
			$update = $this->ion_auth->update($user_id, $data);
			$update_R = $this->user_roles_model->update(array('role_id' => $role_id), array('user_id' => $user_id));

            

			   

				if(!empty($new_password)){
$change = $this->ion_auth->change_password($identity, $old_password, $new_password);
				}else{
		
				}

			

			if ($update)
			{ 
				$this->session->set_flashdata('message', "User Berhasil Diubah");
				redirect("user","refresh");
			}else{
				$this->session->set_flashdata('message_error', "User Gagal Diubah");
				redirect("user","refresh");
			}
		} 
		else
		{
			if(!empty($_POST)){ 
				$id = $this->input->post('id'); 
				$this->session->set_flashdata('message_error',validation_errors());
				return redirect("user/edit/".$id);	
			}else{
				$this->data['id']= $id;
				$this->load->model("roles_model");
				$this->data['roles'] 		= $this->roles_model->getAllById();
				$data = $this->user_model->getOneUserBy(array("users.id"=>$this->data['id'])); 
			  
			  	
				// echo $this->db->last_query();die;
				 

				$this->data['id'] 			=   (!empty($data))?$data->id:"";
				$this->data['first_name'] 	=   (!empty($data))?$data->first_name:"";
				$this->data['last_name'] 	=   (!empty($data))?$data->last_name:"";
				$this->data['username'] 	=   (!empty($data))?$data->username:"";
				$this->data['address'] 		=   (!empty($data))?$data->address:"";
				$this->data['email'] 		=   (!empty($data))?$data->email:""; 
				$this->data['phone']		=   (!empty($data))?$data->phone:"";  
				$this->data['role_id'] 		=   (!empty($data))?$data->role_id:""; 

				$this->data['photo'] 		=   (!empty($data))?$data->photo:"";

			
				$this->data['real_password'] 		=   (!empty($data))?$data->real_password:"";

				$this->data['content'] 		= 'admin/user/edit_v'; 
				$this->load->view('admin/layouts/page',$this->data); 
			}  
		}    
		
	} 

	public function dataList()
	{
		$columns = array( 
            0 =>'id',  
      		1 =>'role_name', 
            2 =>'users.first_name',
            3 =>'users.phone',
            4 => 'users.email', 
            5 => 'photo',
            6 => 'action'
        ); 
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
  		$search = array();
  		$where= array();
  		$limit = 0;
  		$start = 0;
        $totalData = $this->user_model->getCountAllBy($limit,$start,$search,$order,$dir,$where); 

        $searchColumn = $this->input->post('columns');
        $isSearchColumn = false;
        
        if(!empty($searchColumn[1]['search']['value'])){
        	$value = $searchColumn[1]['search']['value'];
        	$isSearchColumn = true;
         	$search['users.role_name'] = $value;
        }  

      	if(!empty($searchColumn[2]['search']['value'])){
        	$value = $searchColumn[2]['search']['value'];
        	$isSearchColumn = true;
         	$search['users.first_name'] = $value;
		}

		if(!empty($searchColumn[3]['search']['value'])){
        	$value = $searchColumn[3]['search']['value'];
        	$isSearchColumn = true;
         	$search['users.is_deleted'] = $value;
		}

    	if($isSearchColumn){
			$totalFiltered = $this->user_model->getCountAllBy($limit,$start,$search,$order,$dir,$where); 
        }else{
        	$totalFiltered = $totalData;
        } 
       
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
		$datas = $this->user_model->getAllBy($limit,$start,$search,$order,$dir,$where);
     	
        $new_data = array();
        if(!empty($datas))
        { 
            foreach ($datas as $key=>$data)
            {  

            	$edit_url = "";
     			$delete_url = "";
     		
            	if($this->data['is_can_edit'] && $data->is_deleted == 0){
            		$edit_url = "<a href='".base_url()."user/edit/".$data->id."' class='btn btn-primary btn-sm white'><i class='fa fa-pencil'></i> Ubah</a>";
            	}  
            	if($this->data['is_can_delete']){
	            	if($data->is_deleted == 0){
	        			$delete_url = "<button
	        				url='".base_url()."user/destroy/".$data->id."/".$data->is_deleted."'
	        				class='btn btn-danger btn-sm white delete' >NonAktifkan
	        				</button>";
	        		}else{
	        			$delete_url = "<button
	        				url='".base_url()."user/destroy/".$data->id."/".$data->is_deleted."'
	        				class='btn btn-danger btn-sm white delete' 
	        				 >Aktifkan
	        				</button>";
	        		}  
        		}
            	

                $nestedData['id'] = $start+$key+1;
                $nestedData['role_name'] = $data->role_name;  
                $nestedData['name'] = $data->first_name . ' ' . $data->last_name;
                $nestedData['phone'] = $data->phone; 
                $nestedData['email'] = $data->email;
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
 			$this->load->model("user_model");
			$data = array(
				'is_deleted' => ($is_deleted == 1)?0:1
			); 
			$update = $this->user_model->update($data,array("id"=>$id));

        	$response_data['data'] = $data; 
         	$response_data['status'] = true;
 		}else{
 		 	$response_data['msg'] = "ID Harus Diisi";
 		}
		
        echo json_encode($response_data); 
	}
}
