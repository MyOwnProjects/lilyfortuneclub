<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('base.php');
class Index extends Base_Controller {
	public function __construct(){
		parent::__construct();
	}
	
	public function index(){
		if($this->not_signed_in()){
			$this->load_view('home');
		}
		else{
			$this->load_view('account/home');
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */