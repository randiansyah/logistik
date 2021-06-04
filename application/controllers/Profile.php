<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/Admin_Controller.php';
class Profile extends Admin_Controller {
 	public function __construct()
	{
		parent::__construct();
		$this->load->model('profile_model');
	}  
	public function index()
	{ 

		if (!empty($_POST))
		{
			if(!empty($this->input->post('new_password')))
			{
				// print_r($_POST);
				
				$data = array(
					
					'real_password' => $this->input->post('new_password')
				); 

				$user_id = $this->input->post('id'); 

				$update = $this->profile_model->update($data,array("id"=>$user_id));
				$identity = $this->session->userdata('identity');
				$old_password = $this->input->post('old_password');
				$confirm_password = $this->input->post('confirm_password');
				$new_password = $this->input->post('new_password');

				if($new_password == $confirm_password){
	$change = $this->ion_auth->change_password($identity, $old_password, $new_password);
				}else{
					$this->session->set_flashdata('message_error', 'Password Tidak Sama');
					redirect('profile', 'refresh');
				}
				if ($change)
				{
					//if the password was successfully changed
					$this->session->set_flashdata('message', 'Data Berhasil Diupdate');
					redirect('profile', 'refresh');
				}
				else
				{
					//if the password was successfully changed
					$this->session->set_flashdata('message', 'Data Berhasil Diupdate');
					redirect('profile', 'refresh');
				} 
			}else{
				$this->session->set_flashdata('message_error', 'Tidak ada yang di ubah');
					redirect('profile', 'refresh');
			}
			
		} 
		else
		{
			$data = $this->data['users'];
			$this->data['id'] =   (!empty($data))?$data->id:"";
			// $this->data['name'] =   (!empty($data))?$data->first_name:"";
			$this->data['user_name'] =   (!empty($data))?$data->username:"";
			$this->data['email'] =   (!empty($data))?$data->email:""; 
			// $this->data['phone'] =   (!empty($data))?$data->phone:""; 
			// $this->data['address'] =   (!empty($data))?$data->address:"";  
			$this->data['real_password'] =   (!empty($data))?$data->real_password:"";  
			$this->data['identity'] = $this->session->userdata('identity');
			$this->data['content'] = 'admin/profile/edit_v'; 
			$this->load->view('admin/layouts/page',$this->data);  

		}    
		
	}  
		public function gantiEmail()
	{ 

		if (!empty($_POST))
		{
			if(!empty($this->input->post('user_name')))
			{
				// print_r($_POST);
				$data = array(
					
					'username' => $this->input->post('user_name'),
					'email'   => $this->input->post('email')
				); 
				$user_id = $this->input->post('id'); 

				$update = $this->profile_model->update($data,array("id"=>$user_id));
		
			
				if ($update)
				{
					//if the password was successfully changed
					$this->session->set_flashdata('message', 'Data Berhasil Diupdate');
					redirect('auth/logoutEmail', 'refresh');
				}
				else
				{
					$this->session->set_flashdata('message_error', 'Data Gagal Diupdate');
					redirect('profile/gantiEmail', 'refresh');
				} 
			}else{
				$this->session->set_flashdata('message_error', 'Tidak ada yang di ubah');
					redirect('profile', 'refresh');
			}
			
		} 
		else
		{
			$data = $this->data['users'];
			$this->data['id'] =   (!empty($data))?$data->id:"";
			// $this->data['name'] =   (!empty($data))?$data->first_name:"";
			$this->data['user_name'] =   (!empty($data))?$data->username:"";
			$this->data['email'] =   (!empty($data))?$data->email:""; 
			// $this->data['phone'] =   (!empty($data))?$data->phone:""; 
			// $this->data['address'] =   (!empty($data))?$data->address:"";  
			$this->data['real_password'] =   (!empty($data))?$data->real_password:"";  
			$this->data['identity'] = $this->session->userdata('identity');
			$this->data['content'] = 'admin/profile/edit_email_v'; 
			$this->load->view('admin/layouts/page',$this->data);  

		}    
		
	} 
}
