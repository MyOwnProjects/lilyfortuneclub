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
	
	private function _valid_dob($date){
		$ds = explode('-', $date);
		$d = date_create(date_format(date_create(), 'Y')."-$ds[1]-$ds[2]");
		$today = date_create();
		$diff=date_diff($today,$d);
		$d = $diff->format("%R%a");
		return $d;
	}
	
	public function index()
	{
		$this->load->model('user_model');
		$this->load->model('sales_model');
		$result = $this->user_model->get_all_children($this->user['membership_code']);
		$result2 = $this->sales_model->get_list("sales_insured_dob IS NOT NULL OR sales_owner_dob IS NOT NULL");
		$grades = array();
		$statuses = array(); 
		$birthday1 = array();
		$birthday2 = array();
		$birthday3 = array();
		$birthday4 = array();
		foreach($result2 as $r){
			if(!empty($r['sales_insured_dob'])){
				$d = $this->_valid_dob($r['sales_insured_dob']);
				echo $r['sales_insured_dob'].' '.$d.' ';
				if($d == 0){
					echo 'a ';
					array_push($birthday1, array('sales_id' => $r['sales_id'], 'name' => $r['sales_insured'], 'dob' => $r['sales_insured_dob']));
				}
				else if($d > 0 && $d < 3){
					echo 'b ';
					array_push($birthday2, array('sales_id' => $r['sales_id'], 'name' => $r['sales_insured'], 'dob' => $r['sales_insured_dob']));
				}
			}
			if(!empty($r['sales_owner_dob'])){
				$d = $this->_valid_dob($r['sales_owner_dob']);
				echo $r['sales_owner_dob'].' '.$d.' ';
				if($d == 0){
					echo 'a ';
					array_push($birthday1, array('sales_id' => $r['sales_id'], 'name' => $r['sales_owner'], 'dob' => $r['sales_owner_dob']));
				}
				else if($d > 0 && $d < 3){
					echo 'b ';
					array_push($birthday2, array('sales_id' => $r['sales_id'], 'name' => $r['sales_owner'], 'dob' => $r['sales_owner_dob']));
				}
			}
		}exit;
		foreach($result as $r){
			if(!array_key_exists($r['grade'], $grades)){
				$grades[$r['grade']] = 0;
			}
			if(!array_key_exists($r['status'], $statuses)){
				$statuses[$r['status']] = 0;
			}
			$grades[$r['grade']]++;
			$statuses[$r['status']]++;
			$d = $this->_valid_dob($r['date_of_birth']);
			if($d == 0){
				array_push($birthday3, $r);
			}
			else if($d > 0 && $d < 3){
				array_push($birthday4, $r);
			}
		}
		$this->nav_menus['account']['sub_menus']['']['active'] = true;
		$this->load_view('account/dashboard', array('grades' => $grades, 
			'statuses' => $statuses,
			'birthday1' => $birthday1,
			'birthday2' => $birthday2,
			'birthday3' => $birthday3,
			'birthday4' => $birthday4
		));
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */