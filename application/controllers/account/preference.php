<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('account_base.php');
class Preference extends Account_base_controller {
	public function __construct(){
		parent::__construct();
		if(isset($this->user['preference'])){
			header('location:'.base_url().'account');
		}
	}
	
	public function index(){
		if($this->input->server('REQUEST_METHOD') == 'POST'){
			$preference = $this->input->post('preference');
			$this->load->model('user_model');
			$this->user_model->update($this->user['users_id'], array('preference' => $preference));
			header('location:'.base_url().'account');
		}
		else{
			$this->load_view('preference');
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */