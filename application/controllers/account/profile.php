<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('account_base.php');
class Profile extends Account_base_controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
	}
	
	public function index(){
		$error = '';
		$success = '';
		$result = $this->user_model->get_user_by_id($this->user['users_id']);
		$this->load_view('profile', array('error' => $error, 'success' => $success, 'user' => $result));
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */