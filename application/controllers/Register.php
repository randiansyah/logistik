<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {
	
    public function __construct()
    {
        parent::__construct();
        $this->load->model('packages_model');
        $this->load->model('billing_model');
    }	

	public function index() {

		$packages = $this->packages_model->getAllById();
		
		$data = array(	'title'		=> 'Register - Juragan Web',
						'packages'	=> $packages,
						'content'   => 'front/register/content'
					);
		$this->load->view('front/layouts/wrapper',$data);
	}

	public function package($id) {

		$this->form_validation->set_rules('first_name',"Nama Depan", 'trim|required');
		$this->form_validation->set_rules('last_name',"Nama Belakang", 'trim|required');
		$this->form_validation->set_rules('phone',"No Ponsel", 'trim|required|is_unique[users.phone]');
		$this->form_validation->set_rules('email',"Email", 'trim|required|is_unique[users.email]');
		$this->form_validation->set_rules('password',"Password", 'trim|required');
		if ($this->form_validation->run() === TRUE)
		{
			$role_id = $this->input->post('role_id');
			
			$data = array(
				'phone' 	 => $this->input->post('phone'),
				'email' 	 => $this->input->post('email'),
				'first_name' => $this->input->post('first_name'),
				'last_name'  => $this->input->post('last_name'),
				'active' 	 => 1,
				'is_deleted' => 0
			);
			$role = array($this->input->post('role_id'));
 			$username = $this->input->post('email');
 			$password = $this->input->post('password'); 
 			$email = $this->input->post('email'); 
			$insert = $this->ion_auth->register($username,$password,$email,$data,$role);
			 
			if ($insert)
			{ 	
				$data = array(
					'user_id' 	 => $insert,
					'package_id' => $this->input->post('package_id'),
					'is_active'  => 0
				);
				$billing = $this->billing_model->insert($data);
				$this->session->set_flashdata('message','Anda berhasil daftar, silahkan login disini');
			 	redirect("login");
			
			}else{

				$this->session->set_flashdata('message_error', "Terjadi Kesalahan");
				redirect("register/detail/".$id);
			}
			 
		}else{ 

		$package = $this->packages_model->getOneBy(array("id"=>$id)); 
		
		$data = array(	'title'		=> 'Detail Register - Juragan Web',
						'package'	=> $package,
						'content'   => 'front/register/detail');
		$this->load->view('front/layouts/wrapper',$data);

		}
	}	
}