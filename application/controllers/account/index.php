<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('account_base.php');
class Index extends Account_base_controller {

	public function __construct(){
		parent::__construct();
	}
	
	public function index()
	{
		header('location: '.base_url().'account/startup');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */