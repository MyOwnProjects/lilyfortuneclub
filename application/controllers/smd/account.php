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
		$birthday1 = array();
		$birthday2 = array();
		foreach($result as $r){
			if(!array_key_exists($r['grade'], $grades)){
				$grades[$r['grade']] = 0;
			}
			if(!array_key_exists($r['status'], $statuses)){
				$statuses[$r['status']] = 0;
			}
			$grades[$r['grade']]++;
			$statuses[$r['status']]++;
			
			$ds = explode('-', $r['date_of_birth']);
			$d = date_create(date_format(date_create(), 'Y')."-$ds[1]-$ds[2]");
			$today = date_create();
			$diff=date_diff($today,$d);
			$d = $diff->format("%R%a");
			if($d == 0){
				array_push($birthday1, $r);
			}
			else if($d > 0 && $d < 3){
				array_push($birthday2, $r);
			}
		}
		$this->nav_menus['account']['sub_menus']['']['active'] = true;
		$this->load_view('account/dashboard', array('grades' => $grades, 
			'statuses' => $statuses,
			'birthday1' => $birthday1,
			'birthday2' => $birthday2
		));
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */