<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('account_base.php');
class First_access extends Account_base_controller {
	public function __construct(){
		parent::__construct();
		if($this->user['first_access'] == 'N'){
			header('location: '.base_url().'account');
			exit;
		}
		$this->load->model('user_model');
	}
	
	public function index(){
		$email = $this->user['email'];
		$error = '';
		if($this->input->server('REQUEST_METHOD') == 'POST'){
			$email = trim($this->input->post('email'));
			$password = trim($this->input->post('password'));
			$confirm_password = trim($this->input->post('confirm_password'));
			if($password != $confirm_password){
				$error = 'Confirm password does not match.';
			}
			else{
				if($this->user_model->update($this->user['users_id'], array('email' => $email, 'password' => $password, 'first_access' => 'N'))){
					header('location: '.base_url().'account');
					exit;
				}
				else{
					$error = 'Failed to update email and password.';
				}
			}
		}
		$this->load_view('first_access', array('email' => $email, 'error' => $error, 'first_name' => $this->user['first_name'], 'last_name' => $this->user['last_name'], ));
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */