<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('base.php');
class Legal_notice extends Base_Controller {

	public function __construct(){
		parent::__construct();
	}
	
	public function index()
	{
		$this->load_view('legal_notice');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */