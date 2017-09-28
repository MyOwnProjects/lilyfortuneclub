<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('account_base.php');
class Code_of_honor extends Account_base_controller {
	public function __construct(){
		parent::__construct();
		if($this->user['preference'] == 'E'){
			header('location:'.base_url().'account');
			exit;
		}
	}
	
	public function index(){
		$this->load_view('code_of_honor');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */