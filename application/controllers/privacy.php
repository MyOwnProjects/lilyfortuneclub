<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('base.php');
class Privacy extends Base_Controller {

	public function __construct(){
		parent::__construct();
	}
	
	public function index()
	{
		$this->load_view('privacy');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */