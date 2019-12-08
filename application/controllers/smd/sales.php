<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('smd_controller.php');
class Sales extends Smd_Controller {
	public function __construct(){
		parent::__construct();
		if(empty($this->user) || $this->user['grade'] !== 'SMD'){
			$this->re_signin();
		}		
		$this->nav_menus['sales']['active'] = true;
		$this->load->model('sales_model');
	}
	
	public function index()
	{
		$this->nav_menus['sales']['sub_menus']['']['active'] = true;
		$this->load_view('sales/list');
	}

	public function import_sales2(){
		$provider = $this->input->post('provider');
		$file = fopen($_FILES["policies"]["tmp_name"],"r");
		$data = array();
		$n = 0;
		$pending = false;
		while(!feof($file)){
			$line = fgetcsv($file);
			if($provider == 'Transamerica'){
				if($line[0] == 'Agent Name'){
					if($line[3] == 'Policy Closure Date'){
						$pending = true;
					}
					continue;
				}
				$n++;
				$f = trim($line[0]);
				if(empty($f)){
					continue;
				}
				if($pending){
					$agent = filter_char($line[1]);
					$closure_date = date_format_convertion(trim($line[3]));
					$policy = filter_char($line[4]);
					$owner = trim($line[5]);
					$insured = trim($line[6]);
					$submitted_date = date_format_convertion(trim($line[7]));
					$status = trim($line[8]);
					$product = trim($line[9]);
					$data[$policy] = "'".implode("','", array($agent, $policy, $owner, $insured, $closure_date, $submitted_date, $status, 'Transamerica', $product))."'";
				}
				else{
					$agent = filter_char($line[1]);
					$policy = filter_char($line[3]);
					$owner = trim($line[4]);
					$insured = trim($line[5]);
					$issue_date = date_format_convertion(trim($line[6]));
					$status = trim($line[7]);
					$product = trim($line[8]);
					$data[$policy] = array($agent, $policy, $owner, $insured, $issue_date, $status, 'Transamerica', $product);
					//"'".implode("','", array($agent, $policy, $owner, $insured, $issue_date, $status, 'Transamerica', $product))."'";
				}
			}
			else if($provider == 'PacLife'){
				$f = trim($line[0]);
				if(empty($f)){
					continue;
				}
				$insured = trim($line[1]).' '.trim($line[0]);
				$policy = filter_char($line[2]);
				$issue_date = date_format_convertion(trim($line[4]));
				$product = trim($line[6]);
				$dob = date_format_convertion(trim($line[7]));
				$status = trim($line[8]);
				$agent = filter_char($line[9]);
				$data[$policy] = array($agent, $policy, $insured, $dob, $issue_date, $status, 'PacLife', $product);
				//"'".implode("','", array($agent, $policy, $insured, $dob, $issue_date, $status, 'PacLife', $product))."'";
			}
			else if($provider == 'Nationwide'){
				$f = trim($line[0]);
				if(empty($f)){
					continue;
				}
				$owner = trim($line[2]).' '.trim($line[1]);
				$insured = trim($line[4]).' '.trim($line[3]);
				$policy = filter_char($line[0]);
				$face_amount = filter_digit($line[5]);
				$data[$policy] = array($policy, $owner, $insured, 'Nationwide', $face_amount);
				//"'".implode("','", array($agent, $policy, $insured, $dob, $issue_date, $status, 'PacLife', $product))."'";
			}
		}
		fclose($file);
		$result = $this->sales_model->get_policy_list();
		if($provider == 'Transamerica'){
			if($pending){
				$fields = array('policies_writing_agent', 'policies_number'
					, 'policies_owner_name', 'policies_insured_name', 'policies_closure_date', 'policies_submitted_date', 
					'policies_status',
					'policies_provider', 'policies_product');
			}
			else{
				$fields = array('policies_writing_agent', 'policies_number'
					, 'policies_owner_name', 'policies_insured_name', 'policies_issue_date', 'policies_status',
					'policies_provider', 'policies_product');
			}
			foreach($result as $r){
				if(array_key_exists($r['policies_number'], $data)){
					if($pending){
						$prop = array(
							'policies_writing_agent' => $data[$r['policies_number']][0],
							'policies_owner_name' => $data[$r['policies_number']][2], 
							'policies_insured_name' => $data[$r['policies_number']][3], 
							'policies_closure_date' => $data[$r['policies_number']][4], 
							'policies_submitted_date' => $data[$r['policies_number']][5], 
							'policies_status' => $data[$r['policies_number']][6],
							'policies_provider' => $data[$r['policies_number']][7], 
							'policies_product' => $data[$r['policies_number']][8]
						);
					}
					else{
						$prop = array(
							'policies_writing_agent' => $data[$r['policies_number']][0],
							'policies_owner_name' => $data[$r['policies_number']][2], 
							'policies_insured_name' => $data[$r['policies_number']][3], 
							'policies_issue_date' => $data[$r['policies_number']][4], 
							'policies_status' => $data[$r['policies_number']][5],
							'policies_provider' => $data[$r['policies_number']][6], 
							'policies_product' => $data[$r['policies_number']][7]
						);
					}
					unset($data[$r['policies_number']]);
					$this->sales_model->update_policy($prop, "policies_number='".$r['policies_number']."'");
				}
			}
		}
		else if($provider == 'PacLife'){
			$fields = array('policies_writing_agent', 'policies_number'
				, 'policies_insured_name', 'policies_insured_dob', 'policies_issue_date', 'policies_status',
				'policies_provider', 'policies_product');
			foreach($result as $r){
				if(array_key_exists($r['policies_number'], $data)){
					$prop = array(
						'policies_writing_agent' => $data[$r['policies_number']][0],
						'policies_insured_name' => $data[$r['policies_number']][2],
						'policies_insured_dob' => $data[$r['policies_number']][3],
						'policies_issue_date' => $data[$r['policies_number']][4], 
						'policies_status' => $data[$r['policies_number']][5],
						'policies_provider' => $data[$r['policies_number']][6], 
						'policies_product' => $data[$r['policies_number']][7]
					);
					unset($data[$r['policies_number']]);
					$this->sales_model->update_policy($prop, "policies_number='".$r['policies_number']."'");
				}
			}
		}
		else if($provider == 'Nationwide'){
			$fields = array('policies_number'
				, 'policies_owner_name', 'policies_insured_name', 'policies_provider', 'policies_face_amount');
					echo 2;exit;
		
			foreach($result as $r){
				if(array_key_exists($r['policies_number'], $data)){
					$prop = array(
						'policies_owner_name' => $data[$r['policies_number']][1],
						'policies_insured_name' => $data[$r['policies_number']][2],
						'policies_provider' => $data[$r['policies_number']][3], 
						'policies_face_amount' => $data[$r['policies_number']][4]
					);
					unset($data[$r['policies_number']]);
					$this->sales_model->update_policy($prop, "policies_number='".$r['policies_number']."'");
				}
			}
		}

		if(!empty($data)){
			foreach($data as $i => $d){
				$data[$i] = "'".implode("','", $d)."'";
			}
			$this->sales_model->insert_policies($fields, $data);
		}
		header("location:".base_url()."smd/sales");
	}
	
	public function import_sales(){
		if($this->input->server('REQUEST_METHOD') == 'POST'){
			$provider = $this->input->post('provider');
			if($provider == 'Transamerica Inforce'){
				$count = array(
					'name' => 0,
					'telephone' => 0,
					'email' => 0,
					'address' => 0,
					'city' => 0,
					'state' => 0,
					'zip' => 0,
					'dateofbirth' => 0,//: 08/21/1975
					'gender' => 'gender',
				);	
				
				$transamerica_name_list = array(
						'policy#' => 'number',
						'status' => 'status',
						'issuedate' => 'issue_date',
						'Transamerica Financial Foundation IUL',
						'specifiedamount' => 'face_amount',
						'App Signed Date: 09/01/2018',
						'name' => 'name',
						'telephone' => 'telephone',
						'email' => 'email',
						'address' => 'address',
						'city' => 'city',
						'state' => 'state',
						'zip' => 'zip',
						'dateofbirth' => 'dob',//: 08/21/1975
						'gender' => 'gender',
						'name' => 'name',
						'telephone' => 'telephone',
						'email' => 'email',
						'address' => 'address',
						'city' => 'city',
						'state' => 'state',
						'zip' => 'zip',
						'dateofbirth' => 'dob',//: 08/21/1975
						'gender' => 'gender',
						'targetpremium' => 'target_premium'
				);
				$input_data1 = $this->input->post('text-input-1');
				$ll = explode("\n", $input_data1);
				$this->load->model('user_model');
				$rl = $this->user_model->get_list();
				$membership_codes = array();
				foreach($rl as $r){
					array_push($membership_codes, $r['membership_code']);
				}
				foreach($ll as $lll){
					$llla = explode("\t", trim($lll));
					$agent_code_list[trim($llla[0])] = trim($llla[1]);
				}
				$input_data = $this->input->post('text-input');
				$data_lines = explode("\n", $input_data);
				$data_array = array();
				$case_data = array('policies_provider' => 'Transamerica');
				foreach($data_lines as $line){
					$line = trim($line);
					if($line == 'This printed page w as generated by selecting the Print link.'){
						if(array_key_exists($case_data['policies_number'], $agent_code_list) 
							&& in_array($agent_code_list[$case_data['policies_number']], $membership_codes)){
							$case_data['policies_writing_agent'] = $agent_code_list[$case_data['policies_number']];
						}
						$data_array[$case_data['policies_number']] = $case_data;
						$case_data = array('policies_provider' => 'Transamerica');
						foreach($count as $n => $v){
							$count[$n] = 0;
						}
					}
					$ls = explode(":", $line);
					if(count($ls) == 0){
						continue;
					}
					$name = strtolower(str_replace(' ', '', trim($ls[0])));
					if(!array_key_exists($name, $transamerica_name_list)){
						continue;
					}
					$value = count($ls) > 1 ? trim($ls[1]) : null;
					if($name == 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL)){
						$value = null;
					}
					if($name == 'dateofbirth' || $name == 'issuedate'){
						$value = date_format(date_create($value), 'Y-m-d');
					}
					if($name == 'gender'){
						$value = $value == 'Male' ? 'M' : 'F';
					}
					
					if(array_key_exists($name, $count)){
						if($count[$name] == 0){
							$case_data['policies_owner_'.$transamerica_name_list[$name]] = $value;
						}
						else if($count[$name] == 1){
							$case_data['policies_insured_'.$transamerica_name_list[$name]] = $value;
						}
						else if($count[$name] == 2 && $name == 'name'){
							$case_data['policies_writing_agent'] = $value;
						}
						$count[$name]++;
					}
					else{
						if($name == 'specifiedamount' || $name == 'targetpremium'){
							$new_value = '';
							for($i = 0; $i < strlen($value); ++$i){
								$ord = ord($value[$i]);
								if(($ord >= 48 && $ord <= 57) || $value[$i] == '.'){
									$new_value .= $value[$i];
								}
							}
							$value = intval($new_value);
						}
						$case_data['policies_'.$transamerica_name_list[$name]] = $value;
					}
				}
				if(count($data_array) > 0){
					$fields = array();
					foreach(current($data_array) as $n => $v){
						array_push($fields, $n);
					}
					$values = array();
					foreach($data_array as $n => $row){
						$rv = array();
						foreach($fields as $s => $f){
							if(array_key_exists($f, $row)){
								array_push($rv, "'".addslashes($row[$f])."'");
							}
							else{
								array_push($rv, "NULL");
							}
						}
						array_push($values, implode(",", $rv));
					}
					$this->sales_model->insert_policies($fields, $values);
				}
			}
			header('location:'.base_url().'smd/sales');
			return;
		}
		$this->load_view('sales/import_cases', array('sales_numbers' => array()));
	}
	
	public function get_sales_list(){
		$policy_types = array(
			'IL' => 'IUL+LTC',
			'I' => 'IUL',
			'A' => 'Annuity',
			'T' => 'Term',
		);
		$sales_status = array(
			'P' => '<span class="text-danger">Pending</span>',
			'I' => '<span class="text-success">Inforced</span>',
			'C' => '<span class="text-muted">Closed</span>',
			'CA' => '<span class="text-muted">Canceled</span>',
		);
		$search_str = trim($this->input->post('search'));
		$search = isset($search_str) && $search_str !== '' ? preg_split('/[^a-z0-9]/i', $search_str) : array();
		$current = $this->input->post('current');
		$row_count= $this->input->post('row_count');
		$sort = $this->input->post('sort');
		if(empty($sort)){
			//$sort = array('sales_date_submission' => 'ASC');
		}
		$filter = $this->input->post('filter');
		$ret = array(
			'current' => 1,
			'last' => 0,
			'row_count' => $row_count,
			'search' => $search_str,
			'rows' => array(),
			'total' => 0
		);
		$total = $this->sales_model->get_policy_total('', $search, $filter);
		if($total > 0){
			$ret = paginate($total, $current, $row_count);
			$ret['search'] = $search_str;
			$ret['rows'] = $this->sales_model->get_policy_list('', $sort, (($ret['current'] - 1) * $ret['row_count']).", ".$ret['row_count'], $search, $filter, array($this->user['membership_code'], '27QUE'));
			foreach($ret['rows'] as $i => $r){
				$ret['rows'][$i]['seq'] = ($current - 1) * $row_count + ($i + 1);
				$ret['rows'][$i]['policies_number'] = '<img style="height:16px;margin-top:-5px;margin-right:5px" src="'.base_url().'src/img/'.$r['policies_provider'].'_logo.ico"><a href="'.base_url().'smd/sales/sales_case/'.$r['policies_id'].'" target="_blank">'.$r['policies_number'].'</a>';
				$ret['rows'][$i]['policies_status'] = $r['policies_status'];
				$ret['rows'][$i]['policies_name'] = $r['policies_insured_name'].'<br/>'.$r['policies_owner_name'];
				$ret['rows'][$i]['policies_payment_method'] = $r['policies_payment_method'];
				$ret['rows'][$i]['policies_issue_date'] = $r['policies_issue_date'];
				$ret['rows'][$i]['policies_closure_date'] = $r['policies_closure_date'] == '9999-01-01' ? '' : $r['policies_closure_date'];
				$writing_agent = empty($r['agent1']) ? $r['policies_writing_agent'] : $r['agent1'].'('.$r['policies_writing_agent'].')';
				$split_agent = '';
				if(!empty($r['writing_split_agent'])){
					if(!empty($r['agent2'])){
						$split_agent = $r['agent2'].'('.$r['policies_split_agent'].')';
					}
					else{
						$split_agent = $r['policies_split_agent'];
					}
				}
				$ret['rows'][$i]['policies_agents'] = $writing_agent.(empty($split_agent) ? "" : "<br/>$split_agent");
				$ret['rows'][$i]['notes'] = $r['policies_notes'];
				//$ret['rows'][$i]['action'] = array('view' => base_url().'smd/sales/sales_case/'.$r['policies_id']);
			}
		}
		echo json_encode($ret);
	}
	
	private function _generate_fields($policy){
		$users1 = $this->user_model->get_list('', $sort = array('last_name' => 'ASC', 'first_name' => 'ASC'));
		$users = array();
		foreach($users1 as $u){
			array_push($users, array('text' => ucwords(strtolower($u['last_name'])).', '.ucwords(strtolower($u['first_name'])).(empty($u['nick_name']) ? '' : ' ('.ucwords(strtolower($u['nick_name'])).')').' - '.$u['membership_code'], 'value' => $u['membership_code']));
		}
		
		$fields = array();
		foreach($policy as $n => $v){
			if($n == 'policies_id'){
				continue;
			}
			$fields[$n] = array();
			$fields[$n]['label'] = str_replace('_', ' ', substr($n, 9)); 
			if(in_array($n, array('policies_payment_method', 'policies_status', 'policies_provider', 'policies_owner_gender', 'policies_insured_gender'
				, 'policies_writing_agent', 'policies_split_agent'))){
				$fields[$n]['tag'] = 'dropdownedit';
				if($n == 'policies_owner_gender' || $n == 'policies_insured_gender'){
					$fields[$n]['readonly']= 'true';
					$fields[$n]['options']= array(
						array('value' => '', 'text' => 'Unknown'),
						array('value' => 'F', 'text' => 'Female'),
						array('value' => 'M', 'text' => 'Male'),
					);
				}
				else if($n == 'policies_provider'){
					//$fields[$n]['readonly']= 'true';
					$fields[$n]['options']= array(
						array('value' => 'Transamerica', 'text' => 'Transamerica'),
						array('value' => 'Nationwide', 'text' => 'Nationwide'),
						array('value' => 'PacLife', 'text' => 'Pacific Life'),
					);
				}
				else if($n == 'policies_payment_method'){
					//$fields[$n]['readonly']= 'true';
					$fields[$n]['options']= array(
						array('value' => 'Annually', 'text' => 'Annually'),
						array('value' => 'Monthly', 'text' => 'Monthly'),
						array('value' => '', 'text' => 'Other'),
					);
				}
				else if($n == 'policies_status'){
					//$fields[$n]['readonly']= 'true';
					$fields[$n]['options']= array(
						array('value' => 'Active', 'text' => 'Active'),
						array('value' => 'Approved', 'text' => 'Approved'),
						array('value' => 'Incomplete', 'text' => 'Incomplete'),
						array('value' => 'Pending', 'text' => 'Pending'),
						array('value' => 'Declined', 'text' => 'Declined'),
					);
				}
				else if(in_array($n, array('policies_writing_agent', 'policies_split_agent'))){
					$fields[$n]['options']= array();
					foreach($users as $u){
						array_push($fields[$n]['options'], array('value' => $u['value'], 'text' => $u['text']));
					}
				}
			}
			else if($n == 'policies_notes'){
				$fields[$n]['tag'] = 'textarea';
			}
			else{
				$fields[$n]['tag'] = 'input';
			}

			if(in_array($n, array('policies_issue_date', 'policies_closure_date', 'policies_submitted_date', 'policies_insured_dob', 'policies_owner_dob'))){
				$fields[$n]['type'] = 'date';
			}
			if(in_array($n, array('policies_face_amount', 'policies_target_premium'))){
				$fields[$n]['type'] = 'number';
			}
			$fields[$n]['value'] = $v;
			if(in_array($n, array('policies_target_premium', 'policies_owner_gender', 'policies_insured_gender'))){
				array_push($fields, 'split');
			}

		}
		return $fields;
	}
	
	public function new_case(){
		$post = array();
		if($this->input->server('REQUEST_METHOD') == 'POST'){
			$post = $this->input->post();
			$fields = array();
			$values = array();
			foreach($post as $n => $v){
				array_push($fields, $n);
				array_push($values, empty($v) ? "NULL" : "'".addslashes($v)."'");
			}
			if($this->sales_model->insert_policies($fields, array(implode(",", $values)))){
				header('location:'.base_url().'smd/sales');
				return;
			}
		}
		$fields = $this->sales_model->list_policies_fields();
		$policy = array();
		foreach($fields as $f){
			$policy[$f] = array_key_exists($f, $post) ? '' : null;
		}
		$fields = $this->_generate_fields($policy);
		$this->load_view('sales/case_view', array('policies_id' =>null, 'fields' => $fields));
	}
	
	public function sales_case($policies_id = null){
		if($this->input->server('REQUEST_METHOD') == 'POST'){
			$prop = $this->input->post();
			$res = $this->sales_model->update_policy($prop, "policies_id='$policies_id'");
			return;
		}
		
		$policies = $this->sales_model->get_policies($policies_id);
		if(count($policies) > 0){
			$policy = $policies[0];
		}
		else{
			$policy = array();
		}
		
		$fields = $this->_generate_fields($policy);
		$this->load_view('sales/case_view', array('policies_id' => $policy['policies_id'], 'fields' => $fields));
	}
	
	public function number_existing(){
		$number = $this->input->post('policies_number');
		$result = $this->sales_model->get_policies_where("policies_number='$number'");
		echo json_encode(array('exist' => count($result) > 0));
	}
}

