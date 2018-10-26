<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('account_base.php');
class Sales extends Account_base_controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('sales_model');
	}
	
	public function index(){
		$sales = $this->sales_model->get_list("sales_writing_agent='".$this->user['membership_code']."' OR sales_split_agent='".$this->user['membership_code']."'");
		$this->load_view('sales', array('sales' => $sales));
	}
	
	public function case_view($sales_id = null){
		$sales = $this->sales_model->get_list("sales_id='$sales_id' AND (sales_writing_agent='".$this->user['membership_code']."' OR sales_split_agent='".$this->user['membership_code']."')");
		if(count($sales) <= 0){
			header('location: '.base_url().'account/sales/sales_case');
			return;
		}
		foreach($sales[0] as $n => $v){
			$sales[0][$n] = trim($v);
		}
		$this->load_view('case_view', array('sales_id' => $sales_id, 'sale' => $sales[0]));
		
	}
	
	public function sales_case($sales_id = null){
		$sale = array();
		if(isset($sales_id)){
			$sales = $this->sales_model->get_list("sales_id='$sales_id' AND (sales_writing_agent='".$this->user['membership_code']."' OR sales_split_agent='".$this->user['membership_code']."')");
			if(count($sales) > 0){
				$sale = $sales[0];
			}
			else{
				$sales_id = null;
			}
		}
		$error = array();
		$this->load->model('user_model');
		$users = $this->user_model->get_list('', $sort = array('last_name' => 'ASC', 'first_name' => 'ASC'));
		$users1 = array();
		foreach($users as $u){
			array_push($users1, array('text' => $u['first_name'].' '.$u['last_name'].' ('.$u['membership_code'].')', 'value' => $u['membership_code']));
		}

		if($this->input->server('REQUEST_METHOD') == 'POST'){
			$prop = $this->input->post();
			if($prop['sales_writing_agent'] != $this->user['membership_code'] 
				&& $prop['sales_split_agent'] != $this->user['membership_code']){
				$error = array('text'=> 'Neither writing agent nor split agent is yourself.', 'fields' => array(
					'sales_writing_agent', 'sales_split_agent'
				));
			}
			else if($prop['sales_writing_agent'] == $prop['sales_split_agent']){
				$error = array('text'=> 'Writing agent cannot be same as split agent.', 'fields' => array(
					'sales_writing_agent', 'sales_split_agent'
				));
			}
			else{
				foreach($prop as $k => $v){
					$v = trim(addslashes(strip_tags($v)));
					if($k == 'sales_split_agent' && $v == '0'){
						$prop[$k] = "NULL";
					}
					else if($k == 'sales_policy_no' && $v == ''){
						$prop[$k] = "NULL";
					}
					else if(in_array($k, array('sales_date_submission', 'sales_date_closure', 'sales_insured_dob', 'sales_owner_dob', 'sales_payor_dob',
						'sales_primary_beneficiary_dob', 'sales_contingent_beneficiary_1_dob', 'sales_contingent_beneficiary_2_dob')) 
						&& empty($v)){
						$prop[$k] = "NULL";
					}
					else{
						$prop[$k] = "'$v'";
					}
				}
				if(count($sales) > 0){
					$res = $this->sales_model->update($sales[0]['sales_id'], $prop);
					if($res){
						header('location: '.base_url().'account/sales/case_view/'.$sales[0]['sales_id']);
						return;
					}			
				}
				else{
					$res = $this->sales_model->insert($prop);
					if($res){
						header('location: '.base_url().'account/sales/case_view/'.$res);
						return;
					}			
				}
			}
			if(!empty($error)){
				foreach($prop as $k => $v){
					$sale[$k] = $v;
				}
			}
		}
		
		$this->load_view('sales_case', array('error' => $error, 'sales_id' => $sales_id, 'sale' => $sale, 'users' => $users1, 'me' => $this->user));
	}
	
	public function upload_file($sales_id){
		$config['upload_path'] = getcwd().'\\application\\documents\\sales';
        $config['allowed_types']        = 'pdf';
        $config['max_size']             = 1024 * 1024 * 4;
		$config['file_name'] = date_format(date_create(), 'YmdHisu').'_'.$sales_id.'_'.$_FILES['file']['name'];
		$this->load->library('upload', $config);
        if ( ! $this->upload->do_upload('file')){
            echo json_encode(array('error' => $this->upload->display_errors()));
		}
		else{
			echo json_encode(array());
		}		
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */