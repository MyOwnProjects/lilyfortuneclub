<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('smd_controller.php');
class Tools extends Smd_Controller {

	public function __construct(){
		parent::__construct();
		if(empty($this->user) || $this->user['grade'] !== 'SMD'){
			header('location: '.base_url().'smd/ac/sign_in');
		}		
		$this->nav_menus['tools']['active'] = true;
	}
	
	public function index()
	{
		$this->nav_menus['tools']['sub_menus']['']['active'] = true;
		$this->load_view('tools/direct_query');
	}
	
	public function direct_query(){
		$sql = $this->input->post('sql');
		$this->load->model('my_database_model');
		$this->my_database_model->trans_begin();
		try{
			$result = $this->my_database_model->query_obj($sql);
			$this->my_database_model->trans_rollback();
			echo json_encode(array('success' => true, 'result' => $result));
		}
		catch(Exception $e){
			$this->my_database_model->trans_rollback();
			echo json_encode(array('success' => false, 'message' => $e->getMessage()));
		}
		$this->my_database_model->trans_rollback();
	}
	
	public function elite_qualification(){
		$sql = "select users.membership_code, u.start_date from users INNER JOIN users u ON u.recruiter=users.membership_code where u.start_date BETWEEN '2017-04-01' AND '2017-10-01'";
		$recruiters = array();
		foreach($result as $r){
			$code = $r['recruiter_membership_code']; 
			if(!array_key_exists($code, $recruiters)){
				$recruiters[$code] = array();
				$start_date = strtotime($start_date) / 86400;
				for($date = $start_date; $date <= $start_date; $date++){
					$recruiters[$code][$date] = array('count' => 0);
				}
			}
			$recruit_date = strtotime($r['start_date']) /86400;
			array_push($recruiters[$code], array());
		}
		foreach($users as $code => $recruits){
			foreach($recruites as $r){
			}
		}
	}
	
	public function javascript_code(){
		$this->nav_menus['tools']['sub_menus']['javascript_code']['active'] = true;
		$this->load_view('tools/javascript_code');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */