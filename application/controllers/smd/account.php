<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('smd_controller.php');
class Account extends Smd_Controller {
	public function __construct(){
		parent::__construct();
		if(empty($this->user) || $this->user['grade'] !== 'SMD'){
			header('location: '.base_url().'smd/ac/sign_in');
		}		
		$this->nav_menus['account']['active'] = true;
	}
	
	public function index()
	{
		$this->load->model('user_model');
		$result = $this->user_model->get_all_children($this->user['membership_code']);
		$grades = array();
		$statuses = array();
		foreach($result as $r){
			if(!array_key_exists($r['grade'], $grades)){
				$grades[$r['grade']] = 0;
			}
			if(!array_key_exists($r['status'], $statuses)){
				$statuses[$r['status']] = 0;
			}
			$grades[$r['grade']]++;
			$statuses[$r['status']]++;
		}
		
		$this->nav_menus['account']['sub_menus']['']['active'] = true;
		$this->load_view('account/dashboard', array('grades' => $grades, 'statuses' => $statuses));
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */