<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('account_base.php');
class Index extends Account_base_controller {

	public function __construct(){
		parent::__construct();
	}
	
	public function index()
	{
		if(isset($this->user['preference'])){
			header('location: '.base_url().'account/startup');
		}
		else{
			header('location: '.base_url().'account/preference');
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */