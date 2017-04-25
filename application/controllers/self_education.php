<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Self_education extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('auth_model');
		$user = $this->auth_model->get_user();
		if(!$user || $user->priority != 'M'){
			header("location: sign_in?redirect=".base_url()."self_education");
			exit;
		}
	}
	
	public function index()
	{
		echo "hello World";
	}
}

