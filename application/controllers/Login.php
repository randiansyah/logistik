<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->helper('url');

		$this->load->view('auth/login');
	}
	public function register()
	{
		$this->load->helper('url');

		$this->load->view('auth/create_user');
	}
	public function forgot_password(){

		$this->load->model('user_model');
		if($this->input->post()){
			$this->session->set_flashdata('fg_email',$this->input->post('email'));
			$this->form_validation->set_rules('email','Email', 'required');
			if($this->form_validation->run()===TRUE){
				if($this->user_model->getOneUserBy(['users.email'=>$this->input->post('email')])){
					$detail = $this->user_model->getOneUserBy(['users.email'=>$this->input->post('email')]);
					$time = time()+$this->config->item('forgot_password_time');
					$this->user_model->update(['users.forgotten_password_code'=>md5($this->config->item('snc_loginkey_enc').$time),'users.forgotten_password_time'=>$time],['users.email'=>$this->input->post('email')]);
					$updateddetail = $this->user_model->getOneUserBy(['users.email'=>$this->input->post('email')]);
					$link = 'login/reset_password/'.$updateddetail->forgotten_password_code;
					if($this->send_mail($detail->email,$detail->first_name.' '.$detail->last_name,$link,$updateddetail->forgotten_password_code)){
						$this->session->set_flashdata('message_success','Berhasil Mengirim Email');
					}else{
						$this->session->set_flashdata('message_error','Gagal');
					}
					redirect('login/forgot_password');
				}else{
					$this->session->set_flashdata('message_error','Email Tidak Ditemukan');
					redirect('login/forgot_password');
				}
			}else{
				$this->session->set_flashdata('message_error','Semua Harus Diisi!');
				redirect('login/forgot_password');
			}
		}
		if(!empty($this->session->flashdata('fg_email'))){
			$this->data['email'] = $this->session->flashdata('fg_email');
		}else{			$this->data['email']='';
		}
		$this->data['title'] = 'Shirobyte | Lupa Password';
		$this->load->view('auth/forgot_pass',$this->data);
	}
	public function reset_password($code=NULL){
		if($this->data['logged']==true){
			redirect('/');
		}
		$this->load->model('user_model');
		if($this->input->post()){
			$this->form_validation->set_rules('kode','Password','trim|required');
			$this->form_validation->set_rules('password','Password','trim|required');
			$this->form_validation->set_rules('conf_password','Konfirmasi Password','trim|required');
			if($this->form_validation->run()===TRUE){
				if($this->input->post('password')==$this->input->post('conf_password')){
					$detail = $this->user_model->getOneUserBy(['users.forgotten_password_code'=>$this->input->post('kode')]);
					if($detail){
						$id = $detail->id;
						if($detail->forgotten_password_time >= time()){
							$this->ion_auth->update($id,['password'=>$this->input->post('password')]);
							$this->user_model->update(['forgotten_password_code'=>NULL,'forgotten_password_time'=>NULL],['users.id'=>$id]);
							$this->session->set_flashdata('message_success','Berhasil Reset Password');
							redirect('login');
						}else{
							$this->session->set_flashdata('message_success','Kode Kadaluarsa');
							redirect('login/reset_password');
						}
					}else{
						$this->session->set_flashdata('message_error','Kode Tidak Ditemukan');
						redirect('login/reset_password');
					}
				}
			}
		}
		if($code!=NULL){
			$detail = $this->user_model->getOneUserBy(['users.forgotten_password_code'=>$code]);
			$this->session->set_flashdata('reset_pass',FALSE);
			if($detail){
				$this->session->set_flashdata('reset_pass',TRUE);
				$this->session->set_flashdata('kode',$code);
				redirect('login/reset_password');
			}else{
				$this->session->set_flashdata('message_error','Kode Tidak Ditemukan');
				$this->session->set_flashdata('reset_pass',FALSE);
				redirect('login/reset_password');
			}
		}
		$this->data['title'] = 'Shirobyte | Reset Password';
		$this->load->view('auth/forgot_password',$this->data);
	}
	public function create_password($code = NULL){
		$this->load->model('user_model');
		if($code!=NULL){
			$detail = $this->user_model->getOneUserBy(['users.activation_code'=>$code]);
			if(!$detail){
				redirect('/');
			}
		}else{
			redirect('/');
		}
		if($this->input->post()){
			$this->form_validation->set_rules('password','Password','trim|required');
			$this->form_validation->set_rules('conf_password','Konfirmasi Password','trim|required');
			if($this->form_validation->run()===TRUE){
				if($this->input->post('password')==$this->input->post('conf_password')){
					$this->ion_auth->update($detail->id,['password'=>$this->input->post('password')]);
					$this->user_model->update(['activation_code'=>NULL,'is_verified'=>1],['users.id'=>$detail->id]);
					$this->session->set_flashdata('message_success','Berhasil!');
					redirect('login');
				}else{
					redirect('login/create_password/'.$code);
				}
			}
		}
		$this->data['title'] = 'Shirobyte | Buat Password';
		$this->load->view('user/layouts/header',$this->data);
		$this->load->view('user/layouts/create_pass',$this->data);
		$this->load->view('user/layouts/footer',$this->data);
	}
	private function send_mail($email,$name,$link,$code){
		date_default_timezone_set('Asia/Jakarta');
		$mail = new PHPMailer\PHPMailer\PHPMailer();
		$mail->isSMTP();
		$mail->SMTPDebug = 0;
		$mail->Debugoutput = 'html';
		$mail->Host = $this->config->item('smtp_server');
		$mail->Port = $this->config->item('smtp_port');
		$mail->SMTPSecure = 'tls';
		$mail->SMTPAuth = true;
		$mail->Username = $this->config->item('smtp_username');
		$mail->Password = base64_decode($this->config->item('smtp_password'));
		$mail->setFrom($this->config->item('mail_noreply'), $this->config->item('mail_signature'));
		//$mail->addReplyTo('replyto@example.com', 'First Last');
		$mail->addAddress($email, $name);
		$mail->Subject = 'Reset password akun Shirobyte';
		$this->data['nama'] = $name;
		$this->data['email'] = $email;
		$this->data['kode'] = $code;
		$this->data['linkreset'] = base_url($link);
		$mail->msgHTML($this->load->view('user/mail/forgot_password',$this->data,TRUE));
		if (!$mail->send()) {
			return false;
		} else {
			return true;
		}
	}
}
