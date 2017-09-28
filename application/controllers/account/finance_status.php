<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('account_base.php');
class Finance_status extends Account_base_controller {
	public function __construct(){
		parent::__construct();
	}
	
	public function index(){
		$this->load_view('finance_status');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */