<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('base.php');
class About extends Base_Controller {

	public function __construct(){
		parent::__construct();
	}
	
	public function index()
	{
		$this->load_view('about');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */