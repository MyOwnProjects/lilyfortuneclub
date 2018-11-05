<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('base.php');
class Profile extends Base_controller {
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
		$result = $this->user_model->get_user_by_id($this->user['users_id']);
		$this->load_view('account/profile', array('error' => $error, 'success' => $success, 'user' => $result));
	}
	
	public function update_preference(){
		$preference = $this->input->post('preference');
		$result = $this->user_model->update($this->user['users_id'], array('preference' => $preference));
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */