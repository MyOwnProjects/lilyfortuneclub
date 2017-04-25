<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('smd_controller.php');
class Index extends Smd_Controller {
	public function __construct(){
		parent::__construct();
	}
	
	public function index()
	{
		header('location: '.base_url().'smd/account');
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */