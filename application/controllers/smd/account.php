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
	
	private function _valid_ann($date){
		if(empty($date)){
			return false;
		}
		$da = explode('-', $date);
		date_default_timezone_set('America/Los_Angeles');
		$today = date_create();
		for($i = 0; $i < 14; ++$i){
			date_add($today,date_interval_create_from_date_string("1 days"));
			$ta = explode('-', date_format($today, 'Y-m-d'));
			if($ta[1] == $da[1] && $ta[2] == $da[2]){
				return true;
			}
		}
		$today = date_create();
		for($i = 0; $i < 14; ++$i){
			date_add($today,date_interval_create_from_date_string("-1 days"));
			$ta = explode('-', date_format($today, 'Y-m-d'));
			if($ta[1] == $da[1] && $ta[2] == $da[2]){
				return true;
			}
		}
		return false;
	}
	
	private function _valid_dob($date){
		$da = explode('-', $date);
		date_default_timezone_set('America/Los_Angeles');
		$today = date_create();
		$ta = explode('-', date_format($today, 'Y-m-d'));
		if($ta[1] == $da[1] && $ta[2] == $da[2]){
			return 0;
		}

		date_add($today,date_interval_create_from_date_string("1 days"));
		$ta = explode('-', date_format($today, 'Y-m-d'));
		if($ta[1] == $da[1] && $ta[2] == $da[2]){
			return 1;
		}
		
		date_add($today,date_interval_create_from_date_string("1 days"));
		$ta = explode('-', date_format($today, 'Y-m-d'));
		if($ta[1] == $da[1] && $ta[2] == $da[2]){
			return 2;
		}
		
		return 3;
	}
	
	public function index()
	{
		$this->load->model('user_model');
		$this->load->model('sales_model');
		$result = $this->user_model->get_all_children($this->user['membership_code']);
		//$result2 = $this->sales_model->get_policy_list("sales_insured_dob IS NOT NULL OR sales_owner_dob IS NOT NULL");
		$result2 = $this->sales_model->get_policy_list("");
		$grades = array();
		$statuses = array(); 
		$birthday1 = array();
		$birthday2 = array();
		$birthday3 = array();
		$birthday4 = array();
		$policy_ann = array();
		foreach($result2 as $r){
			if(!empty($r['policies_owner_dob'])){
				$d = $this->_valid_dob($r['policies_owner_dob']);
				if($d == 0){
					array_push($birthday1, array('policies_id' => $r['policies_id'], 'name' => $r['policies_owner_name'], 'dob' => $r['policies_owner_dob']));
				}
				else if($d > 0 && $d < 3){
					array_push($birthday2, array('policies_id' => $r['policies_id'], 'name' => $r['policies_owner_name'], 'dob' => $r['policies_owner_dob']));
				}
			}
			if($r['policies_owner_name'] != $r['policies_insured_name'] && !empty($r['policies_insured_dob'])){
				$d = $this->_valid_dob($r['policies_insured_dob']);
				if($d == 0){
					array_push($birthday1, array('policies_id' => $r['policies_id'], 'name' => $r['policies_insured_name'], 'dob' => $r['policies_insured_dob']));
				}
				else if($d > 0 && $d < 3){
					array_push($birthday2, array('policies_id' => $r['policies_id'], 'name' => $r['policies_insured_name'], 'dob' => $r['policies_insured_dob']));
				}
			}
			if($this->_valid_ann($r['policies_issue_date'])){
				array_push($policy_ann, array('policies_id' => $r['policies_id'], 'policies_provider' =>$r['policies_provider'],  'policies_number' => $r['policies_number'], 'policies_insured_name' => $r['policies_insured_name'], 'policies_issue_date' => $r['policies_issue_date']));
			}
		}
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
			'birthday4' => $birthday4,
			'policy_ann' => $policy_ann
		));
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */