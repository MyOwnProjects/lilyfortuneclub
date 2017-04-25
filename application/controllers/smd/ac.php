<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('smd_controller.php');
class Ac extends Smd_Controller {
	public function __construct(){
		parent::__construct();
	}
	
	public function sign_in()
	{
		$error = '';
		if($this->input->server('REQUEST_METHOD') == 'POST'){
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$save_password = $this->input->post('save_password');
			$this->set_session_user($username, $password, $save_password);
			if(empty($this->user)){
				$error = 'Incorrect username or password';
			}
			else if($this->user['grade'] !== 'SMD'){
				$error = 'You are authorized to access.';
			}
			else{
				$redirect = $this->input->get('redirect');
				if($redirect){
					redirect(base_url()."smd/".$redirect, "location");
				}
				else{
					redirect(base_url()."smd", "location");
				}
				exit;
			}
		}
		$this->load->view('smd/sign_in', array('error' => $error));
	}
	
	public function sign_out()
	{
		$this->unset_session_user();
		header('location: '.base_url().'smd/ac/sign_in');
	}
}

