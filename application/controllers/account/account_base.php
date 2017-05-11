<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(getcwd().'/application/controllers/base.php');
class Account_base_controller extends Base_Controller {
	public function __construct(){
		parent::__construct();
		if(empty($this->user)){
			header('location: '.base_url());
			exit;
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */