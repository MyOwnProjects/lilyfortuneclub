<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('base.php');
class Password extends Base_controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		if($redirect = $this->not_signed_in()){
			header("location: $redirect");
			exit;
		}
	}
	
	public function index(){
		$error = '';
		$success = '';
		if($this->input->server('REQUEST_METHOD') == 'POST'){
			$password = $this->input->post('password');
			$confirm_password = $this->input->post('confirm_password');
			if(strlen($password) < 5){
				$error = "Password must be at least 5 characters.";
			}
			if(strpos($password, ' ') !== false){
				$error = "Password cannot contain space.";
			}
			else if($password != $confirm_password){
				$error = "Confirm password does not match.";
			}
			else{
				if(!$this->user_model->update($this->user['users_id'], array('password' => $password))){
					$error = "New password cannot be same as old one";
				}
				else{
					$success = 'Password has been changed successfully.';
				}
			}
		}
		if($this->input->is_ajax_request()){
			echo json_encode(array('success' => empty($error), 'error' => $error));
		}
		else{
			$this->load_view('account/password', array('error' => $error, 'success' => $success));
		}
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */