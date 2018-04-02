<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('account_base.php');
class Welcome_guest extends Account_base_controller {
	public function __construct(){
		$this->guest_access_allowed = true;
		parent::__construct();
	}
	
	public function index(){
		$this->load_view('welcome_guest', array());
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */