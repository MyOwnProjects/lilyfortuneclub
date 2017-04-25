<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chat extends CI_Controller {

	public function __construct(){
		parent::__construct();
		if(!$this->input->is_ajax_request()){
			exit;
		}
	}
	
	public function index()
	{
	}
	
	public function init_session(){
		$name = $this->input->post('name');
		$email = $this->input->post('email');
		$session_id = uniqid();
		$this->load->model('live_chat_model');
		if($this->live_chat_model->initiate_session($session_id, $name, $email)){
			
		}
		else{
			
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */