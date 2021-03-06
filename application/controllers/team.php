<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('base.php');
class Team extends Base_controller {
	public function __construct(){
		parent::__construct();
		if($redirect = $this->not_signed_in()){
			header("location: $redirect");
			exit;
		}
	}
	
	public function index(){
		$this->load_view('account/team');
	}
	
	public function member_info($code = 0){
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
		$result[0]['ancestors']= $ancestors;
		$this->load_view('account/team_member_info', $result[0]);
		//echo json_encode(array('success' => true, 'info' => $result[0], 'ancestors' => $ancestors));
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
					, 'child_url' => base_url().'team/get_direct_downline/'.$r['membership_code']
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

	private function _get_recuits($type, $code, $from, $to){
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
			return false;
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
		else if($type == 'T' || $type == '3_30' || $type == '6_30'){
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
			if($type == '3_30' || $type == '6_30'){
				$result1 = array();
				foreach($result as $r){
					$recruiter = $r['recruiter'];
					if(!array_key_exists($recruiter, $result1)){
						$result1[$recruiter] = array();
					}
					array_push($result1[$recruiter], $r);
				}
				$result = array();
				function check_30(&$result, $r, $number){
					$i = count($r) - 1;
					while($i >= 0){
						if($i - $number + 1 < 0){
							break;
						}
						$d1 = date_create($r[$i]['start_date']);
						$d2 = date_create($r[$i - $number + 1]['start_date']);
						$diff = date_diff($d2, $d1);
						$recruiter = $r[$i]['recruiter'];
						if($diff->format('%a') < 30){
							if(!array_key_exists($recruiter, $result)){
								$result[$recruiter] = array(
									'name' => $r[$i]['recruiter_name'],
									'matches' => array()
								);
							}
							$a = array();
							for($j = 0; $j < $number; ++$j){
								array_push($a, $r[$i - $j]);
							}
							array_push($result[$recruiter]['matches'], $a);
							$i -= $number;
						}
						else{
							$i--;
						}
					}
				}
				foreach($result1 as $recruiter => $r){
					check_30($result, $r, $type == '3_30' ? 3 : 6);
				}
			}
		}
		return $result;
	}
	
	public function export_recruits(){
		$type = $this->input->get('type');
		$code = $this->input->get('code');
		$from = $this->input->get('date_from');
		$to = $this->input->get('date_to');
		$result = $this->_get_recuits($type, $code, $from, $to);
		header('Content-Type: application/csv');
		header('Content-Disposition: attachment; filename="recuits.csv";');
		$f = fopen('php://output', 'w');
		fputcsv($f, array('Name', 'Code', 'Recuiter', 'Downline', 'Grade', 'Phone', 'Email'));
		foreach ($result as $r) {
			fputcsv($f, array($r['name'], $r['membership_code'], $r['recruiter'], $r['children'], $r['grade'], $r['phone'], $r['email']));
		}
	}
	
	public function get_recruits(){
		$type = $this->input->post('type');
		$code = $this->input->post('code');
		$from = $this->input->post('date_from');
		$to = $this->input->post('date_to');
		$result = $this->_get_recuits($type, $code, $from, $to);
		if($result === false){
			echo json_encode(array('success' => false, 'message' => "Invalid membership code."));
			return;
		}
		echo json_encode(array('success' => true, 'data' => $result));
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */