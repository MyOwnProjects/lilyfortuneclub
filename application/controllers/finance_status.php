<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Finance_status extends CI_Controller {

	public function __construct(){
		parent::__construct();
		header('location: '.base_url());
		exit;
		$this->load->model('auth_model');
	}
	
	public function index()
	{
		if(!array_key_exists('finance_status_info', $_SESSION)){
			$_SESSION['finance_status_info'] = array();
		}
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$step = array_key_exists('step', $_POST) ? $_POST['step'] : 0;			
			$_SESSION['finance_status_info'][''] = '';
			$step++;
		}
		else{
			$fresh = array_key_exists('fresh', $_GET) ? $_GET['fresh'] : 0;
			if($fresh == 1)
				$_SESSION['finance_status_info'] = array();
			$step = array_key_exists('step', $_GET) ? $_GET['step'] : 0;					
		}
		$this->load->view('template', array('data' => array('view'=>'finance_status/step', 'step'=>$step, 'finance_status_info'=>$_SESSION['finance_status_info'])));
	}
}

