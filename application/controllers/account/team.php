<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('account_base.php');
class Team extends Account_base_controller {
	public function __construct(){
		parent::__construct();
	}
	
	public function index(){
		$this->load_view('team');
	}
	
	public function get_member_info($code = 0){
		$this->load->model('user_model');
		$ancestors = $this->user_model->get_ancestors($code);
		$valid = false;
		foreach($ancestors as $r){
			if($r['membership_code'] == $this->user['membership_code']){
				$valid = true;
				break;
			}
		}
		if(!$valid){
			echo json_encode(array('success' => false, 'message' => "Invalid membership code."));
			return;
		}
		$result = $this->user_model->get_user_by(array('membership_code' => $code));
		echo json_encode(array('success' => true, 'info' => $result[0], 'ancestors' => $ancestors));
	}
	
	public function get_direct_downline($membership_code = null){
		$this->load->model('user_model');
		if(empty($membership_code)){
			//$membership_code = $this->user['membership_code'];
		}
		$result = $this->user_model->get_child_users($membership_code, $this->user['users_id']);
		if(count($result) == 0){
			$data = 'No downline';
		}
		else{
			$data = array();
			foreach($result as $r){
				$t = "[".($r['count'] == 0 ? '<span class="text-danger">No downline</span>' : '<span class="text-success">'.$r['children'].' baseshop, '.$r['count'].' direct downline</span>')."]";
				$t .= "  [".$r['grade'];
				$t .= ", start at ".$r['start_date']."]";
				array_push($data, array(
					'text' => '<a class="detail-url" href="javascript:void(0)" data-id="'.$r['membership_code'].'">'.$r['first_name'].' '.$r['last_name']
						.(empty($r['nick_name']) ? '' : ' ('.$r['nick_name'].')')." - ".$r['membership_code']."</a>"
					, 'child_count' => $r['count'] 
					, 'child_url' => base_url().'account/team/get_direct_downline/'.$r['membership_code']
				));
			}
		}
		echo json_encode(array('success' => true, 'data' => $data));		
	}	

	private function _get_baseshop($code){
		$result = $this->user_model->get_user_by();
		$baseshop = array();
		$recruiters = array($code);
		while(count($recruiters) > 0){
			$new_recruiters = array();
			foreach($result as $i => $r){
				if(in_array($r['recruiter'], $recruiters)){
					array_push($baseshop, $r);
					array_push($new_recruiters, $r['membership_code']);
				}
			}
			if(count($new_recruiters) == 0){
				break;
			}
			$recruiters = $new_recruiters;
		}
		return $baseshop;
	}
	
	public function get_baseshop($code = 0){
		if(empty($code)){
			$code = $this->user['membership_code'];
		}
		$this->load->model('user_model');
		$ancestors = $this->user_model->get_ancestors($code);
		$valid = false;
		foreach($ancestors as $r){
			if($r['membership_code'] == $this->user['membership_code']){
				$valid = true;
				break;
			}
		}
		if(!$valid){
			echo json_encode(array('success' => false, 'message' => "Invalid membership code."));
			return;
		}
		//echo 1;exit;
		$baseshop = $this->_get_baseshop($code);
		echo json_encode(array('success' => true, 'baseshop' => $baseshop));
	}
	
	
	public function get_recruits(){
		$type = $this->input->post('type');
		$code = $this->input->post('code');
		$from = $this->input->post('date_from');
		$to = $this->input->post('date_to');
		$this->load->model('user_model');
		$ancestors = $this->user_model->get_ancestors($code);
		$valid = false;
		foreach($ancestors as $r){
			if($r['membership_code'] == $this->user['membership_code']){
				$valid = true;
				break;
			}
		}
		if(!$valid){
			echo json_encode(array('success' => false, 'message' => "Invalid membership code."));
			return;
		}
		$where = "1=1";
		if(!empty($from)){
			$where .= " AND u.start_date >= '$from'"; 
		}
		if(!empty($to)){
			$where .= " AND u.start_date <= '$to'"; 
		}
		if($type == 'P'){
			$result = $this->user_model->get_recruits(array($code), $where);
		}
		else{
			$baseshop = $this->_get_baseshop($code);
			$result = array();
			foreach($baseshop as $b){
				if((empty($from) || strcmp($b['start_date'], $from) >= 0)
					&& (empty($to) || strcmp($b['start_date'], $to) <= 0)){
					array_push($result, $b);
				}
			}
			
			function sort_temp($a,$b){
				return strcmp($b['start_date'], $a['start_date']);
			}
			usort($result, "sort_temp");
		}
		echo json_encode(array('success' => true, 'data' => $result));
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */