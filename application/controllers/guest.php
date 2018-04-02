<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('base.php');
class Guest extends Base_Controller {
	public function __construct(){
		parent::__construct();
		header('location:'.base_url().'ac/sign_in?as=guest');
	}
	
}

