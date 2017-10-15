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
					'text' => '<a class="hierarchy-url" href="javascript:void(0)" data-id="'.$r['membership_code'].'">'.$r['first_name'].' '.$r['last_name']
						.(empty($r['nick_name']) ? '' : ' ('.$r['nick_name'].')')." - ".$r['membership_code']."</a>"
					, 'child_count' => $r['count'] 
					, 'child_url' => base_url().'account/team/get_direct_downline/'.$r['membership_code']
				));
			}
		}
		echo json_encode(array('success' => true, 'data' => $data));		
	}	

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */