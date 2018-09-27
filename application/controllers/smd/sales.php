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
		$filter = $this->input->post('filter');
		$ret = array(
			'current' => 1,
			'last' => 0,
			'row_count' => $row_count,
			'search' => $search_str,
			'rows' => array(),
			'total' => 0
		);
		$total = $this->sales_model->get_total('', $search, $filter);
		if($total > 0){
			$ret = paginate($total, $current, $row_count);
			$ret['search'] = $search_str;
			$ret['rows'] = $this->sales_model->get_list('', $sort, (($ret['current'] - 1) * $ret['row_count']).", ".$ret['row_count'], $search, $filter);
			foreach($ret['rows'] as $i => $r){
				$ret['rows'][$i]['seq'] = ($current - 1) * $row_count + ($i + 1);
				$ret['rows'][$i]['sales_priority'] = $r['sales_priority'] > 0 ? '<span class="label label-danger">High</span>' : ($r['sales_priority'] == 0 ? '<span class="label label-warning">Medium</span>' : '<span class="label label-success">Low</span>');
				$ret['rows'][$i]['sales_policy_no'] = $r['sales_policy_no'];
				$ret['rows'][$i]['sales_client'] = $r['sales_insured'].(empty($r['sales_owner']) ? '' : ' / '.$r['sales_owner']);
				$ret['rows'][$i]['sales_agents'] = $r['agent1'].(empty($r['sales_split_agent']) ? '' : ' / '.$r['agent2']);
				$ret['rows'][$i]['sales_policy'] = $r['sales_provider'].' / '.$policy_types[$r['sales_policy_type']];
				$ret['rows'][$i]['sales_face_amount'] = number_to_english($r['sales_face_amount']);
				$ret['rows'][$i]['sales_status'] = $sales_status[$r['sales_status']];
				$ret['rows'][$i]['action'] = array('view' => base_url().'smd/sales/sales_case/'.$r['sales_id']);
			}
		}
		echo json_encode($ret);
	}
	
	public function sales_case($sales_id = null){
		$sales = $this->sales_model->get_sales($sales_id);
		$users = $this->user_model->get_list('', $sort = array('last_name' => 'ASC', 'first_name' => 'ASC'));
		$users1 = array();
		foreach($users as $u){
			array_push($users1, array('text' => $u['first_name'].' '.$u['last_name'].' ('.$u['membership_code'].')', 'value' => $u['membership_code']));
		}
		if($this->input->server('REQUEST_METHOD') == 'POST'){
			$prop = $this->input->post();
			foreach($prop as $k => $v){
				$v = trim(addslashes(strip_tags($v)));
				if($k == 'sales_split_agent' && $v == '0'){
					$prop[$k] = "NULL";
				}
				else if($k == 'sales_policy_no' && $v == ''){
					$prop[$k] = "NULL";
				}
				else if(($k == 'sales_date_closure' || $k == 'sales_insured_dob' || $k == 'sales_owner_dob') && $v == ''){
					$prop[$k] = "NULL";
				}
				else{
					$prop[$k] = "'$v'";
				}
			}
			if(count($sales) > 0){
				$res = $this->sales_model->update($sales[0]['sales_id'], $prop);
			}
			else{
				$res = $this->sales_model->insert($prop);
			}
			if($res){
				header('location: '.base_url().'smd/sales');
				return;
			}			
		}
		if(count($sales) > 0){
			$sale = $sales[0];
		}
		else{
			$sale = array();
		}
		$this->load_view('sales/new_case', array('sale' => $sale, 'users' => $users1));
	}

	public function member($membership_code = 0){
		$this->load->model('user_model');
		$result = $this->user_model->get_user_by(array('membership_code' => $membership_code, 'smd'=> $this->user['users_id']));
		if(count($result) == 1){
			$member = $result[0];
			$member_info = $this->user_model->get_user_info_by_user_id(array($member['users_id']), $this->user['users_id']);
		}
		$this->load_view('team/member', array('member' => $member, 'member_info' => $member_info));
	}
	
	public function delete_user_info($users_info_id = 0){
		$this->load->model('user_model');
		if(!$this->user_model->get_user_info($users_info_id, $this->user['users_id'])){
			ajax_error(500, "The user does not eists, or you don't have permission to access the user.");
			exit;
		}
		if($this->input->server('REQUEST_METHOD') == 'POST'){
			if($this->user_model->delete_user_info("users_info_id='$users_info_id'")){
				echo json_encode(array('success' => true));
			}
			else{
				echo json_encode(array('success' => false, 'message' => 'Failed to delete user info'));
			}
		}
		else{
			$items = array(
				array(
					'tag' => 'text', 'text' => 'Do you want to delete the user info?' 
				)
			);
			$this->load->view('smd/add_item', array('items' => $items));
		}
	}
	
	public function update_user_info($users_info_id = 0){
		$this->load->model('user_model');
		$user_info = $this->user_model->get_user_info($users_info_id, $this->user['users_id']);
		if(!$user_info){
			ajax_error(500, "The user does not eists, or you don't have permission to access the user.");
			exit;
		}
		if($this->input->server('REQUEST_METHOD') == 'POST'){
			$user_info_label = addslashes(trim($this->input->post('user_info_label')));
			$user_info_value = addslashes(trim($this->input->post('user_info_value')));
			if($user_info_label == ''){
				ajax_error(500, "Info name cannot be empty.");
				exit;
			}
			if($this->user_model->update_user_info(array('user_info_label' => $user_info_label, 'user_info_value' => $user_info_value), "users_info_id='$users_info_id'")){
				echo json_encode(array('success' => true));
			}
			else{
				echo json_encode(array('success' => false, 'message' => 'Failed to update user info'));
			}
		}
		else{
			$items = array(
				array(
					'label' => 'Info Name',
					'name' => 'user_info_label',
					'tag' => 'input',
					'value' => $user_info['user_info_label']
				),
				array(
					'label' => 'Info Value',
					'name' => 'user_info_value',
					'tag' => 'textarea',
					'value' => $user_info['user_info_value']
				),
			);
			$this->load->view('smd/add_item', array('items' => $items));
		}
	}

	public function add_user_info($user_id = 0){
		$this->load->model('user_model');
		$result = $this->user_model->get_user_by(array('smd' => $this->user['users_id'], 'users_id' => $user_id));
		if(count($result) == 0){
			ajax_error(500, "The user does not eists, or you don't have permission to access the user.");
			exit;
		}
		if($this->input->server('REQUEST_METHOD') == 'POST'){
			$user_info_label = addslashes(trim($this->input->post('user_info_label')));
			$user_info_value = addslashes(trim($this->input->post('user_info_value')));
			if($user_info_label == ''){
				ajax_error(500, "Info name cannot be empty.");
				exit;
			}
			if($this->user_model->insert_user_info($user_id, array(array('user_info_label' => $user_info_label, 'user_info_value' => $user_info_value)))){
				echo json_encode(array('success' => true, 'value' => $user_info_value));
			}
			else{
				echo json_encode(array('success' => false, 'message' => 'Failed to add user info'));
			}
		}
		else{
			$items = array(
				array(
					'label' => 'Info Name',
					'name' => 'user_info_label',
					'tag' => 'input',
				),
				array(
					'label' => 'Info Value',
					'name' => 'user_info_value',
					'tag' => 'textarea',
				),
			);
			$this->load->view('smd/add_item', array('items' => $items));
		}
	}
	
	public function Hierarchy($membership_code = ''){
		$error = '';
		if(empty($membership_code)){
			$membership_code = $this->user['membership_code'];
		}
		if($membership_code != $this->user['membership_code']){
			$result = $this->user_model->get_user_by(array('membership_code' => $membership_code, 'smd' => $this->user['users_id']));
			if(count($result) == 0){
				$error = "The member does not exist, or you don't have permission";
			}
		}
		$this->nav_menus['team']['sub_menus']['hierarchy']['active'] = true;
		$this->load_view('team/hierarchy', array('error' => $error, 'parent' => $membership_code));
	}
	
	public function get_downlines($id = 0){
		$search_str = trim($this->input->post('search'));
		$search = isset($search_str) && $search_str !== '' ? preg_split('/[^a-z0-9]/i', $search_str) : array();
		$current = $this->input->post('current');
		$row_count= $this->input->post('row_count');
		$sort = $this->input->post('sort');
		$ret = array(
			'current' => 1,
			'last' => 0,
			'row_count' => $row_count,
			'search' => $search_str,
			'rows' => array(),
			'total' => 0
		);
		if(empty($id)){
			$id = $this->user['users_id'];
		}
		if($id != $this->user['users_id']){
			$result = $this->user_model->get_user_by(array('users_id' => $id, 'smd' => $this->user['users_id']));
			if(count($result) == 0){
				echo json_encode($ret);
				return;
			}
		}
		
		$total = $this->user_model->get_total("recruiter='".$id."'", $search);
		if($total > 0){
			$ret = paginate($total, $current, $row_count);
			$ret['search'] = $search_str;
			$ret['rows'] = $this->user_model->get_list("recruiter='".$id."'", $sort, ($ret['current'] - 1).", ".$ret['row_count'], $search);
			foreach($ret['rows'] as $i => $r){
				$ret['rows'][$i]['name'] = $r['name'].(isset($ret['row'][$i]['nick_name']) && trim($ret['rows'][$i]['nick_name']) != '' ? ' ('.$ret['rows'][$i]['nick_name'].')' : '');
				$ret['rows'][$i]['membership_code'] = ' - '.$ret['rows'][$i]['membership_code'];
				$ret['rows'][$i]['start_date'] = ', Start: '.$ret['rows'][$i]['start_date'];
				$ret['rows'][$i]['action'] = array('view' => base_url().'smd/team/member/'.$r['users_id']);
				$ret['rows'][$i]['downline'] = $r['downline'] > 0 ? '<a href="'.base_url().'smd/team/hierarchy/'.$id.'">'.$r['downline'].'</a>' : '0';
			}
		}
		echo json_encode($ret);
		
	}
	
	private function _parse_uploade_team_file($target_file, $col_count){
		$this->load->library('PHPExcel');
		$input_file_type = PHPExcel_IOFactory::identify($target_file); // Might not need the case statement above
		$objReader = PHPExcel_IOFactory::createReader($input_file_type);
		$objReader->setReadDataOnly(true);
		$this->excel_reader = $objReader->load($target_file);
		$objWorksheet = $this->excel_reader->getActiveSheet();
		$highestRow   = $objWorksheet->getHighestRow();
		//$highestColumn = PHPExcel_Cell::columnIndexFromString($objWorksheet->getHighestColumn());
		$data = array();
		for($row = 2; $row < ($highestRow > 6 ? 6 : $highestRow) ; ++$row){
			$aRow = array();
			for($col = 0; $col < $col_count; ++$col){
				$cell = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
				array_push($aRow, $cell);
			}
			array_push($data, $aRow);
		}
		return $data;
	}
	
	public function import(){
		$this->load->model('user_model');
		$user_fields = 		$header = array('first_name', 'last_name', 'email', 'date_of_birth', 'membership_code', 
			'grade', 'phone', 'address', 'city', 'state', 'zipcode');
		$this->load->view('smd/template', array('view' => 'import', 'user' => $this->user, 'user_fields' => $user_fields));
	}
	
	public function upload(){
		if($_FILES['uploaded_file']['error']){
			echo json_encode(array('success' => false, 'error' => $_FILES['uploaded_file']['error']));
		}
		$file_ext = '';
		if($_FILES['uploaded_file']['type'] == 'application/vnd.ms-excel'){
			$file_ext = 'csv';
		}
		else if($_FILES['uploaded_file']['type'] == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'){
			$file_ext = 'xlsx';
		}
		else{
			echo json_encode(array('success' => false, 'error' => 'Invalid file type'));
				return;
		}
		
		$path = 'src/upload/'.str_replace(array('@', '.'), '_', $this->user['email']).'/';
		if(!file_exists($path)){
			if(!mkdir($path)){
				echo json_encode(array('success' => false, 'error' => "Failed to create path $path"));
				return;
			}
		}
		$target_file = $path."uploaded_team.$file_ext";
		if(!move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $target_file)){
			echo json_encode(array('success' => false, error => 'Failed to upload'));
		}
		
		$header = array('first_name', 'last_name', 'email', 'date_of_birth', 'membership_code', 
			'grade', 'phone', 'address', 'city', 'state', 'zipcode');
		$data = $this->_parse_uploade_team_file($target_file, count($header));
		$this->load->view('smd/uploaded_member_grid', array('header' => $header, 'body' => $data));
	}

	public function get_direct_downline($membership_code = null){
		$this->load->model('user_model');
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
				
				if(isset($membership_code)){
					$url = base_url().'smd/team/member/'.$r['membership_code'];
				}
				else{
					$url = base_url().'smd';
				}
				array_push($data, array(
					'text' => '<a href="'.$url.'">'.$r['first_name'].' '.$r['last_name']
						.(empty($r['nick_name']) ? '' : ' ('.$r['nick_name'].')')." - ".$r['membership_code']."</a>&nbsp;"
						."$t"
					, 'child_count' => $r['count'] 
					, 'child_url' => base_url().'smd/team/get_direct_downline/'.$r['membership_code']
				));
			}
		}
		echo json_encode(array('success' => true, 'data' => $data));		
	}	
	
	public function bulk_update_users(){
		$data = $this->input->post('data');
		$this->load->model('user_model');
		$this->user_model->bulk_update_level($data);
	}
	
	public function update_user($field = null, $membership_code = 0){
		$result = $this->user_model->get_user_by(array('smd' => $this->user['users_id'], 'membership_code' => $membership_code));
		if(count($result) == 0){
			ajax_error(500, "The user does not eists, or you don't have permission to access the user.");
			exit;
		}

		if($this->input->server('REQUEST_METHOD') == 'GET'){
			$items = array();
			switch($field){
				case 'name':
					$items = array(
						array(
							'label' => 'First Name',
							'name' => 'first_name',
							'tag' => 'input',
							'required' => true,
							'value' => $result[0]['first_name']
						),
						array(
							'label' => 'Last Name',
							'name' => 'last_name',
							'tag' => 'input',
							'required' => true,
							'value' => $result[0]['last_name']
						),
						array(
							'label' => 'Nick Name',
							'name' => 'nick_name',
							'tag' => 'input',
							'required' => true,
							'value' => $result[0]['nick_name']
						),
					);
					break;
				case 'password':
					$items = array(
						array(
							'label' => 'Password',
							'name' => 'password',
							'tag' => 'input',
							'required' => true,
							'type' => 'password'
						),
						array(
							'label' => 'Confirm Password',
							'name' => 'confirm_password',
							'tag' => 'input',
							'required' => true,
							'type' => 'password'
						),
					);
					break;
				case 'date_of_birth':
					$items = array(
						array(
							'label' => 'Date of Birth',
							'name' => 'date_of_birth',
							'tag' => 'input',
							'required' => true,
							'type' => 'date',
							'value' => $result[0]['date_of_birth']
						)
					);
					break;
				case 'start_date':
					$items = array(
						array(
							'label' => 'Start Date',
							'name' => 'start_date',
							'tag' => 'input',
							'required' => true,
							'type' => 'date',
							'value' => $result[0]['start_date']
						)
					);
					break;
				case 'original_start_date':
					$items = array(
						array(
							'label' => 'Original Start Date',
							'name' => 'original_start_date',
							'tag' => 'input',
							'required' => true,
							'type' => 'date',
							'value' => $result[0]['original_start_date']
						)
					);
					break;
				case 'grade':
					$items = array(
						array(
							'label' => 'Level',
							'name' => 'grade',
							'tag' => 'select',
							'required' => true,
							'value' => $result[0]['grade'],
							'options' => array(
								array('value' => 'G', 'text' => 'Guest'),
								array('value' => 'TA', 'text' => 'Trainee Associate'),
								array('value' => 'A', 'text' => 'Associate'),
								array('value' => 'SA', 'text' => 'Senior Associate'),
								array('value' => 'MD', 'text' => 'Margeting Director')
							),
						)
					);
					break;
				case 'status':
					$items = array(
						array(
							'label' => 'Status',
							'name' => 'status',
							'tag' => 'select',
							'required' => true,
							'value' => $result[0]['status'],
							'options' => array(
								array('value' => 'active', 'text' => 'Active'),
								array('value' => 'inactive', 'text' => 'Inactive'),
							),
						)
					);
					break;
				case 'address':
					$items = array(
						array(
							'label' => 'Street',
							'name' => 'street',
							'tag' => 'input',
							'value' => $result[0]['street']
						),
						array(
							'label' => 'City',
							'name' => 'city',
							'tag' => 'input',
							'value' => $result[0]['city']
						),
						array(
							'label' => 'State',
							'name' => 'state',
							'tag' => 'input',
							'value' => $result[0]['state']
						),
						array(
							'label' => 'Zipcode',
							'name' => 'zipcode',
							'tag' => 'input',
							'value' => $result[0]['zipcode']
						),
						array(
							'label' => 'Country',
							'name' => 'country',
							'tag' => 'input',
							'value' => $result[0]['country']
						),
					);
					break;
				case 'recruiter':
					$items = array(
						array(
							'label' => 'Upline',
							'name' => 'recruiter',
							'class' => 'selectpicker',
							'tag' => 'select',
							'required' => true,
							'value' => $result[0]['status'],
							'options' => $this->_get_all_smd_members($this->user['users_id']),
						)
					);
					break;
				//case 'SMD':
				//	break;
				case 'preference':
					$items = array(
						array(
							'label' => 'Prefernce',
							'name' => 'preference',
							'tag' => 'select',
							'value' => $result[0]['preference'],
							'options' => array(
								array('value' => 'E', 'text' => 'Learning More Financial Solution for My Family'),
								array('value' => 'B', 'text' => 'Starting a business/Career'),
								array('value' => 'BE', 'text' => 'Both of the Above'),
							)
						)
					);
					break;
				case 'nick_name':
				case 'email':
				case 'username':
				case 'membership_code':
				case 'phone':
					$item= array(
						'label' => ucwords($field),
						'name' => $field,
						'tag' => 'input',
						'type' => $field == 'email' ? 'email' : 'text',
						'value' => $result[0][$field]
					);
					if($field == 'username'){
						$item['required'] = true;
					}
					array_push($items, $item);
					break;
				case 'trck_top_25_list':
				case 'trck_business_plan':
				case 'trck_3_guest_to_BPM':
				case 'trck_financial_needs_analysis':
				case 'trck_fast_start_award':
				case 'trck_30_days_of_success':
				case 'trck_ceo_club':
				case 'trck_insurance_licensed':
				case 'trck_securities_registered':
				case 'trck_training_completed':
					$items = array(
						array(
							'label' => str_replace('_', ' ', substr($field, 5)),
							'name' => $field,
							'tag' => 'textarea',
							'value' => $result[0][$field]
						)
					);
					break;
				default:
					ajax_error(500, "Invalid field.");
			}
			$this->load->view('smd/add_item', array('items' => $items));
		}
		else{
			$values = array();
			switch($field){
				case 'password':
					$password = $this->input->post('password');
					$confirm_password = $this->input->post('confirm_password');
					if($password != $confirm_password){
						ajax_error(500, 'The confirm password does not match.');
					}
					else{
						$values['password'] = $password;
						$values['first_access'] = 'Y';
					}
					break;
				case 'address':
				case 'recruiter':
				case 'name':
				case 'date_of_birth':
				case 'start_date':
				case 'original_start_date':
				case 'grade':
					foreach($this->input->post() as $n => $v){
						$values[$n] = trim($v);
					}
					break;
					
				//case 'SMD':
				//	break;
				case 'nick_name':
				case 'email':
				case 'username':
				case 'membership_code':
				case 'phone':
				case 'status':
				case 'trck_top_25_list':
				case 'trck_business_plan':
				case 'trck_3_guest_to_BPM':
				case 'trck_financial_needs_analysis':
				case 'trck_fast_start_award':
				case 'trck_30_days_of_success':
				case 'trck_ceo_club':
				case 'trck_insurance_licensed':
				case 'trck_securities_registered':
				case 'trck_training_completed':
					$values[$field] = $this->input->post($field);
					break;
				default:
					ajax_error(500, "Invalid field.");
			}
			if($this->user_model->update($result[0]['users_id'], $values)){
				echo json_encode(array('success' => true));
			}
			else{
				echo json_encode(array('success' => false, 'message' => 'Failed to update value.'));
			}
		}
	}
	
	
	public function email(){
	}
	
	public function retrieve_member($code = ''){
		$url = "https://www.mywfg.com/Wfg.HierarchyTool/HierarchyDetails/AgentDetails?agentcodenumber=$code";
		$ret = file_get_contents($url);
		echo $ret;
	}
	
	public function update_recruiter(){
		$recruiters = array(
			array('16DWR','elaine shao'),
			array('16JMH','peng ding'),
			array('17UCC','min zhu'),
			array('193PI','thao xuan truong'),
			array('22BYB','min zhu'),
			array('23UZX','min zhu'),
			array('24KIZ','jonathan yu'),
			array('24SFN','min zhu'),
			array('24VHK','min zhu'),
			array('24YUE','min zhu'),
			array('25DJO','min zhu'),
			array('25HCS','min zhu'),
			array('25VOS','elaine shao'),
			array('26IWF','min zhu'),
			array('26QGX','min zhu'),
			array('26RSU','heng liu'),
			array('26SKV','qun zhang'),
			array('27BOU','min zhu'),
			array('27DQM','qun zhang'),
			array('27FXB','heng liu'),
			array('27EWX','heng liu'),
			array('27GOA','min zhu'),
			array('27HBQ','min zhu'),
			array('27KPD','heng liu'),
			array('27LRR','sophia wang'),
			array('27OJA','sophia wang'),
			array('27QUE','min zhu'),
			array('27RXV','thao xuan truong'),
			array('27TXS','min zhu'),
			array('27WXJ','thao xuan truong'),
			array('12NHX','thao xuan truong'),
			array('28JII','min zhu'),
			array('28KKC','min zhu'),
			array('28OTD','min zhu'),
			array('28QQR','kent mckinney'),
			array('28RSS','kent mckinney'),
			array('28SLT','min zhu'),
			array('28WIJ','min zhu'),
			array('29ACT','sherry hu'),
			array('29BKZ','changyi song'),
			array('29FNS','min zhu'),
			array('29MWY','zhongfa yang'),
			array('29MRI','zhongfa yang'),
			array('29OOV','zhongfa yang'),
			array('29QZO','changyi song'),
			array('30CXW','min zhu'),
			array('10DBQ','elaine shao'),
			array('30GHF','thao xuan truong'),
			array('30GXT','thao xuan truong'),
			array('30HYL','thao xuan truong'),
			array('30MCO','thao xuan truong'),
			array('30OUG','thao xuan truong'),
			array('30PLU','min zhu'),
			array('03NPN','min zhu'),
			array('30ZFH','min zhu'),
			array('31BCZ','triet minh vo'),
			array('31DGU','min zhu'),
			array('31DMR','min zhu'),
			array('31KYS','lingwei bao'),
			array('31RFQ','lingwei bao'),
			array('31SCI','min zhu'),
			array('31TEI','yanjie xu'),
			array('31TIX','lingwei bao'),
			array('31TTY','min zhu'),
			array('31UGZ','min zhu'),
			array('32GDW','min zhu'),
			array('32GJW','jia li'),
			array('32LYZ','min zhu'),
			array('32OLF','thao xuan truong'),
			array('32OKV','thao xuan truong'),
			array('32OPZ','zhongfa yang'),
			array('33CCN','min zhu'),
			array('33CCM','thao xuan truong'),
			array('33CCM','thao xuan truong'),
			array('33CCM','thao xuan truong'),
			array('11FLI','min zhu'),
			array('33VTS','min zhu'),
			array('34AEJ','min zhu'),
			array('34QEM','min zhu'),
			array('387PM','min zhu'),
			array('34ZHW','rodrigo alonso'),
			array('35DSP','thao xuan truong'),
			array('35LCG','jian yao'),
			array('35LCG','jian yao'),
			array('35LCG','jian yao'),
			array('35LCG','jian yao'),
			array('35NJY','jian yao'),
			array('35VFD','min zhu'),
			array('35YJP','jian yao'),
			array('36CJL','min zhu'),
			array('36DOE','min zhu'),
			array('36FWJ','jian yao'),
			array('36THF','jian yao'),
			array('36WOD','min zhu'),
			array('36YBT','amy mu'),
			array('37GVI','sherry hu'),
			array('37GYC','min zhu'),
			array('37HIT','jian yao'),
			array('37UEN','jian yao'),
			array('37ZJP','min zhu'),
			array('38ONE','ying song'),
			array('38QCV','min zhu'),
			array('38RVJ','thao xuan truong'),
			array('38UQI','min zhu'),
			array('38VCD','jennifer thu tran'),
			array('39BPR','jennifer thu tran'),
			array('632GH','min zhu'),
			array('39DSL','min zhu'),
			array('39JQX','jennifer thu tran'),
			array('39TEU','ying song'),
			array('40GYJ','min zhu'),
			array('40GWB','hadi kusumo'),
			array('40KWN','jian yao'),
			array('40RKN','ying song'),
			array('40TAH','min zhu'),
			array('40VEX','jennifer thu tran'),
			array('41AXE','min zhu'),
			array('41AXT','min zhu'),
			array('41AQI','thao xuan truong'),
			array('41DLO','jennifer thu tran'),
			array('41DPU','jennifer thu tran'),
			array('41DPN','min zhu'),
			array('41FCD','min zhu'),
			array('41MLW','sam low'),
			array('41NHM','ying song'),
			array('41MSK','ying song'),
			array('01ELM','minh xuan thi nguyen'),
			array('41YEJ','min zhu'),
			array('42AQH','jennifer thu tran'),
			array('42GTC','jian yao'),
			array('42GEA','jacklyn le'),
			array('42EEV','thao xuan truong'),
			array('42HZY','jennifer thu tran'),
			array('42ICV','jennifer thu tran'),
			array('42HVH','jennifer thu tran'),
			array('42KJE','jennifer thu tran'),
			array('42KLB','jennifer thu tran'),
			array('42KLZ','jennifer thu tran'),
			array('42KNI','triet minh vo'),
			array('42OHP','diane dao'),
			array('42OJU','min zhu'),
			array('42PKI','lan le'),
			array('42RLH','khoi nguyen'),
			array('42QFC','anthony trinh'),
			array('42QFC','anthony trinh'),
			array('43DTW','jennifer thu tran'),
			array('43IVN','min zhu'),
			array('43QWT','jian yao'),
			array('43RTW','jennifer thu tran'),
			array('43SEM','min zhu'),
			array('43WXV','gary manley poon'),
			array('43ZDB','homeira zarghamnia'),
			array('43ZIK','jian yao'),
			array('44EYO','yanjie xu'),
			array('44XEM','yanjie xu'),
			array('45EWB','min zhu'),
			array('45IKW','min zhu'),
			array('06TRAC','min zhu'),
			array('45PGD','christopher davis'),
			array('45QAT','jennifer thu tran'),
			array('45QUI','jian yao'),
			array('45WVN','jennifer thu tran'),
			array('45XUF','yanjie xu'),
			array('46EIH','min zhu'),
			array('46DFR','jennifer thu tran'),
			array('46ERZ','min zhu'),
			array('46FIS','ji song'),
			array('070HXC','min zhu'),
			array('070TMC','min zhu'),
			array('46JPC','min zhu'),
			array('46JVP','min zhu'),
			array('46NNK','thao xuan truong'),
			array('46RTK','elaine shao'),
			array('46RWA','min zhu'),
			array('46QVX','elaine shao'),
			array('46QNH','elaine shao'),
			array('46TYO','min zhu'),
			array('46UNB','elaine shao'),
			array('46WVN','min zhu'),
			array('46YTI','min zhu'),
			array('46XVE','thao xuan truong'),
			array('0770VC','min zhu'),
			array('47KSJ','elaine shao'),
			array('47ONX','min zhu'),
			array('47PGM','min zhu'),
			array('47PGM','min zhu'),
			array('03KGE','min zhu'),
			array('079MHC','min zhu'),
			array('47QKI','min zhu'),
			array('47QWA','min zhu'),
			array('47WHP','yanjie xu'),
			array('47YOO','fei zou'),
			array('48BGS','min zhu'),
			array('48CQG','yanjie xu'),
			array('48DPJ','min zhu'),
			array('48DZP','robert wang'),
			array('48FZW','min zhu'),
			array('07DTMC','yan lin'),
			array('48GXN','min zhu'),
			array('48OBM','robert wang'),
			array('48OON','thao xuan truong'),
			array('48OOZ','robert wang'),
			array('48OZC','min zhu'),
			array('48QRT','robert wang'),
			array('48TAN','shirley ng'),
			array('48SZN','min zhu'),
			array('48XGZ','yang zhang'),
			array('48ZTW','min zhu'),
			array('49BKI','min zhu'),
			array('49AYM','yang zhang'),
			array('49CKY','thao xuan truong'),
			array('49DPV','min zhu'),
			array('49FFA','elaine shao'),
			array('49IMF','yang zhang'),
			array('49KQF','min zhu'),
			array('49KLF','yanjie xu'),
			array('49LRW','elaine shao'),
			array('49NAD','robert wang'),
			array('49LVD','robert wang'),
			array('49OHP','shirley ng'),
			array('49RXO','min zhu'),
			array('49RQQ','min zhu'),
			array('49SZE','sridhar verose'),
			array('49XGJ','elaine shao'),
			array('49YPM','elaine shao'),
			array('49YFI','sherry hu'),
			array('50BUU','jin delong'),
			array('50BCV','shirley ng'),
			array('04MAV','sherry hu'),
			array('05NDC','yanjie xu'),
			array('50CDT','min zhu'),
			array('50CDF','amy ho'),
			array('50DAF','sherry hu'),
			array('50EEE','jin delong'),
			array('50FMP','sherry hu'),
			array('50ERU','sherry hu'),
			array('50IBL','min zhu'),
			array('50RAY','yanjie xu'),
			array('50YSW','min zhu'),
			array('51BRN','robert wang'),
			array('51DBI','robert wang'),
			array('51DLT','sherry hu'),
			array('51DMD','sherry hu'),
			array('51ERE','kevin gao'),
			array('51FCO','sherry hu'),
			array('51GCY','kevin gao'),
			array('51GTV','robert wang'),
			array('51GVA','min zhu'),
			array('51GVA','min zhu'),
			array('51FRO','sherry hu'),
			array('51IAT','sherry hu'),
			array('51JFI','yanjie xu'),
			array('51LKJ','kevin gao'),
			array('51MIH','sherry hu'),
			array('51NQQ','sherry hu'),
			array('51NQQ','sherry hu'),
			array('51NQQ','sherry hu'),
			array('51NZJ','jason xiong chen'),
			array('5636G','jason xiong chen'),
			array('51PHY','sherry hu'),
			array('51TSZ','robert wang'),
			array('51WJA','min zhu'),
			array('51XSS','sherry hu'),
			array('52BEO','shirley ng'),
			array('52BWF','cammi tam'),
			array('52CLB','sherry hu'),
			array('52CRW','elaine shao'),
			array('52HKJ','min zhu'),
			array('52IGC','shirley ng'),
			array('52LEC','cammi tam'),
			array('52LKS','shirley ng'),
			array('52LLR','ching chiu'),
			array('52MSK','shirley ng'),
			array('52OAI','sherry hu'),
			array('52PSC','sherry hu'),
			array('52PJK','min zhu'),
			array('52QSV','kevin gao'),
			array('52QSW','sherry hu'),
			array('52TUB','yiqing du'),
			array('52TUV','hui li'),
			array('52TUQ','sherry hu'),
			array('52VFS','robert wang'),
			array('53GSN','yiqing du'),
			array('13MNA','sherry hu'),
			array('53QXM','gloria chung'),
			array('53RGF','gloria chung'),
			array('53VQT','thao xuan truong'),
			array('53XMC','sherry hu'),
			array('53ZGU','minna millare'),
			array('54AVH','gloria chung'),
			array('54EPQ','gloria chung'),
			array('54LGU','min zhu'),
			array('54YOZ','amy mu'),
			array('099ETC','min zhu'),
			array('55GKA','min zhu'),
			array('55KPX','robert wang'),
			array('55KZN','sherry hu'),
			array('55NGR','linda munch'),
			array('55OFO','linda munch'),
			array('55OFL','linda munch'),
			array('55PUT','minna millare'),
			array('55PWK','minna millare'),
			array('55PWJ','minna millare'),
			array('55QRS','minna millare'),
			array('55SLA','sherry hu'),
			array('55SKP','linda munch'),
			array('55TTS','minna millare'),
			array('55UQN','linda munch'),
			array('55WVJ','honghong wang'),
			array('55XMW','minna millare'),
			array('55ZCJ','min zhu'),
			array('55ZTW','min zhu'),
			array('56AQL','melanie ann villanueva'),
			array('55YMC','sherry hu'),
			array('56CPH','melanie ann villanueva'),
			array('56BSZ','minna millare'),
			array('56BTN','melanie ann villanueva'),
			array('56EMV','melanie ann villanueva'),
			array('56ERF','thao xuan truong'),
			array('56FMP','min zhu'),
			array('56GPN','krizzia ramos'),
			array('56HWQ','yiqing du'),
			array('56HWX','yiqing du'),
			array('09MHXC','lucy chan'),
			array('56IUI','robert wang'),
			array('56IUQ','min zhu'),
			array('09MVMC','lucy chan'),
			array('56KSQ','sherry hu'),
			array('56MNF','sherry hu'),
			array('825PK','minna millare'),
			array('56NAW','cammi tam'),
			array('56NVR','robert yabes'),
			array('56NXP','joy zhao'),
			array('56PBY','robert wang'),
			array('56BTK','minna millare'),
			array('09RCLC','laurie luo'),
			array('56QSQ','joy zhao'),
			array('56RRQ','major lai'),
			array('56SME','kevin gao'),
			array('56SBR','thao xuan truong'),
			array('56SOV','robert wang'),
			array('09FTZ','kevin gao'),
			array('56YIC','minna millare'),
			array('08CCE','kevin gao')
		);
		
		$users = array(
			array('Lily','Min','Zhu','24KIZ'),
			array('','Peggy','Abusaidi','39BPR'),
			array('','Amit','Adalti','51MIH'),
			array('','Rodrigo','Alonso','33CCN'),
			array('','Ritesh','Anand','34ZHW'),
			array('','Amy','Auyeung','49OHP'),
			array('','Sherry','Azizi','28RSS'),
			array('','Ranyue','Bai','31RFQ'),
			array('','Don','Balza','48QRT'),
			array('','Lingwei','Bao','31DGU'),
			array('','Daniel','Barreras','51DBI'),
			array('','Michael','Brown','45QAT'),
			array('Christine','Li','Cen','632GH'),
			array('','Bella','Chan','52LEC'),
			array('','Lei','Chang','47PGM'),
			array('','Haigang','Chen','49BKI'),
			array('','Hong','Chen','52PSC'),
			array('','Song cindy','Chen','51GCY'),
			array('','Jason xiong','Chen','51GTV'),
			array('','Wei','Chen','51PHY'),
			array('','Bilong','Chen','31TIX'),
			array('','Gui zhen','Chen','27FXB'),
			array('','Wen ying','Chen','24SFN'),
			array('','Karl','Cheng','06TRAC'),
			array('','Nikki nguyen','Cheng','31SCI'),
			array('','Pauline','Cheung','26RSU'),
			array('','Yushi','Cheung','27BOU'),
			array('','Amber','Childress','28WIJ'),
			array('Amber','Ching','Chiu','52LKS'),
			array('','W morris','Chubb','46EIH'),
			array('','GLORIA','CHUNG','48TAN'),
			array('','Fabio','Costa','30GHF'),
			array('','Jiarui','Cui','070TMC'),
			array('','Tony binh','Dao','42OHP'),
			array('','Kenneth','Delong','50BUU'),
			array('','Jin','Delong','11FLI'),
			array('','Peng','Ding','29MWY'),
			array('','Bo','Ding','39TEU'),
			array('','Feng','Dong','35LCG'),
			array('','Jun','Dong','34QEM'),
			array('','Danielle','Dragon','52CLB'),
			array('','Joe','Duong','42QFC'),
			array('','Jesse','Frye','33CCM'),
			array('','Lei','Fukuda','50EEE'),
			array('','Tong','Gao','51WJA'),
			array('','Ting','Gong','51NQQ'),
			array('Joseph','Xueyang','Gong','51GVA'),
			array('','Su','Gu','48FZW'),
			array('','Mei','Guo','52CRW'),
			array('','Yuan','Guo','41AXE'),
			array('','Steve','Guzman','51TSZ'),
			array('','Xuan','Han','50YSW'),
			array('','Yun','Hao','36YBT'),
			array('','Sharon','Hasenbein','32OLF'),
			array('','Zi wen','He','07DTMC'),
			array('','Rong','He','49LRW'),
			array('','Yuen lei','Ho','48OBM'),
			array('','Hoa thanh','Ho','52LLR'),
			array('','Zhiyong','Hou','46RTK'),
			array('','Mingkai','Hsueh','49RXO'),
			array('','Chaohui','Hu','43ZIK'),
			array('','Rong','Hu','27HBQ'),
			array('','Rong','Hu','37GVI'),
			array('','Janelle','Hua','48OON'),
			array('','Ruo hong','Huang','22BYB'),
			array('','Margaret','Hurtado','42GTC'),
			array('','Jake','Huynh','31BCZ'),
			array('','An','Huynh','52MSK'),
			array('','Yunan','Jiang','47ONX'),
			array('','Wei','Jiang','49IMF'),
			array('','Mengying','Jiang','48ZTW'),
			array('','Xihua','Jiang','32GDW'),
			array('','Xin','Jin','37GYC'),
			array('','Yu','Jin','49KQF'),
			array('','Priscilla','Johnson','50DAF'),
			array('','MAJOR','LAI','52BWF'),
			array('','Van','Le','49CKY'),
			array('','Truyen','Le','42GEA'),
			array('','Jacklyn','Le','41DLO'),
			array('','Nhu','Le','12NHX'),
			array('','Eunice somin','Lee','27KPD'),
			array('','Frank','Leonardi','51BRN'),
			array('','Sally hang yu','Leun','5636G'),
			array('','Evans','Leung','50BCV'),
			array('','Stephen','Li','50IBL'),
			array('','Qingfeng','Li','52QSV'),
			array('','Hui','Li','52TUB'),
			array('','Zheng bin','Li','49DPV'),
			array('','Enling','Li','48OZC'),
			array('','Jin','Li','27DQM'),
			array('','Rui','Li','40GYJ'),
			array('','Lin','Li','35VFD'),
			array('','Xinyan','Liang','39DSL'),
			array('','Xueyan','Liang','25DJO'),
			array('','Celine yi hong','Liang','28SLT'),
			array('','Min','Liao','31UGZ'),
			array('','Jonathan','Lien','30MCO'),
			array('','Weijing','Lin','25VOS'),
			array('','Ling','Lin','24YUE'),
			array('','Yan','Lin','0770VC'),
			array('','Boyan','Lin','41AXT'),
			array('','Yilena','Liu','48CQG'),
			array('','Zhenying','Liu','46JPC'),
			array('','Xiaoyuan','Liu','52OAI'),
			array('','Chang','Liu','52PJK'),
			array('','Xiang','Liu','50FMP'),
			array('','Yang','Liu','51ERE'),
			array('','Yun','Long','32LYZ'),
			array('','Chao','Lu','40TAH'),
			array('','Yamin','Lu','079MHC'),
			array('','Ling','Lu','31KYS'),
			array('','Hailey','Lu','42OJU'),
			array('','Tylor chei','Lum perreira','32OKV'),
			array('','Mingjing','Luo','40RKN'),
			array('','Jian','Ma','32OPZ'),
			array('','Wen li','Ma','10DBQ'),
			array('','Xiaoke','Ma','49XGJ'),
			array('','Kent','Mckinney','28JII'),
			array('','Thrudy','Medina','44XEM'),
			array('','John','Mejia','50ERU'),
			array('','Jiulong','Meng','37HIT'),
			array('','Chelisa','Merrick','42RLH'),
			array('','Gail','Mirchandani','26IWF'),
			array('','Wei','Mo','47YOO'),
			array('','Amy','Mu','36WOD'),
			array('','Manuel','Navales','35DSP'),
			array('','Steven','Neely','28QQR'),
			array('','Albert','Nguyen','30GXT'),
			array('','Lillian','Nguyen','43DTW'),
			array('','Danny','Nguyen','42HZY'),
			array('','Tam','Nguyen','42ICV'),
			array('','Kiet','Nguyen','42KJE'),
			array('','Hoa','Nguyen','42EEV'),
			array('','Thy','Nguyen','41DPU'),
			array('','Minh xuan thi','Nguyen','39JQX'),
			array('','Khoi','Nguyen','40GWB'),
			array('','John','Nguyen','43RTW'),
			array('','Jennifer','Nguyen','46DFR'),
			array('','Tamara nicole','Nolen love','28OTD'),
			array('','Kang shing','Pei','51XSS'),
			array('','Bach','Pho','42HVH'),
			array('','Jimmy','Phoen','27EWX'),
			array('','Chenghao','Piao','41DPN'),
			array('','Pavel','Pimenau','49NAD'),
			array('','Sung','Poon','43WXV'),
			array('','Gary manley','Poon','27RXV'),
			array('','Salman','Qamar','43QWT'),
			array('','Yi','Qu','51DLT'),
			array('','Omar','Ramich','30OUG'),
			array('','Sonny','Rataul','43ZDB'),
			array('','Patricia','Reynoso','46UNB'),
			array('','Zheng','Rong','16DWR'),
			array('','Sudi','Sabet','46RWA'),
			array('','Neelam','Saluja','41YEJ'),
			array('','Chanh hung','Sam','52BEO'),
			array('','Ganesh','Sapate','46FIS'),
			array('','Ramon','Sepulveda','50RAY'),
			array('','Yuki','Seto','29BKZ'),
			array('','Yi','Shan','29MRI'),
			array('ELAINE','Yi','Shao','46JVP'),
			array('','Jennifer','Sheu','51NZJ'),
			array('','Heng chun','Sim','36THF'),
			array('','Anastasia','Slack','30HYL'),
			array('','Xiao jie','Song','27TXS'),
			array('','Wei','Sun','29QZO'),
			array('','Hongyu','Sun','17UCC'),
			array('','Shuhua','Sun','36DOE'),
			array('','Chenhang','Sun','35NJY'),
			array('','Lisa','Sun','50CDT'),
			array('','Yu','Sun','52TUV'),
			array('','Vera','Sun','46YTI'),
			array('Tom','Liangcai','Tan','04MAV'),
			array('','Shuang','Tang','27LRR'),
			array('','Virginia','Tang','46XVE'),
			array('','Christina','Taylor','45QUI'),
			array('','Debesay','Teklemariam','49KLF'),
			array('','Tiffany','Ton','27WXJ'),
			array('','Mary','Tran','45PGD'),
			array('','Kien','Tran','50CDF'),
			array('','Long','Trinh','45WVN'),
			array('','Anthony','Trinh','42PKI'),
			array('','Sridhar','Verose','47QKI'),
			array('','Sucharitha','Verose','49SZE'),
			array('','Tina','Vien','46NNK'),
			array('','Zosimo iii','Villadarez','44EYO'),
			array('','Monique','Vo','01ELM'),
			array('','Vu','Vo','42KLB'),
			array('','Khanh','Vo','42KLZ'),
			array('','Toan','Vo','42KNI'),
			array('','Mi','Wang','27GOA'),
			array('','Yaming','Wang','30CXW'),
			array('','Fusheng','Wang','45EWB'),
			array('','Yuyang','Wang','46ERZ'),
			array('','Yalei','Wang','48BGS'),
			array('','Frank','Wang','48DZP'),
			array('','Brian','Wang','49LVD'),
			array('','Jing','Wang','49RQQ'),
			array('','Yi','Wang','51FCO'),
			array('','David','Wang','52VFS'),
			array('','Hao','Wang','52QSW'),
			array('Jas','Honghong','Wang','52HKJ'),
			array('Vivian','Wei','Wang','52IGC'),
			array('','Isma','Waqas','38UQI'),
			array('','Lina','Wen','30PLU'),
			array('','Gary c','Wong','41MLW'),
			array('','Qin','Worwag','45XUF'),
			array('','Daichen','Wu','51FRO'),
			array('','Dongju','Wu','35YJP'),
			array('','Jun','Wu','33VTS'),
			array('','Norman','Wudel','47WHP'),
			array('','Lu','Xiao','48GXN'),
			array('','Yun','Xie','36FWJ'),
			array('','Bin','Xu','49AYM'),
			array('','Ye','Xu','46TYO'),
			array('','Xiaofei','Xu','52TUQ'),
			array('','Jin bao','Xue','387PM'),
			array('','Hong','Xue','34AEJ'),
			array('','Yingjie','Yang','38ONE'),
			array('','Wen','Yang','29OOV'),
			array('','Kun','Yang','27QUE'),
			array('','Jihui','Yang','03KGE'),
			array('','Xiaohong','Yang','05NDC'),
			array('','Jian','Yao','32GJW'),
			array('','Ting','Ye','41NHM'),
			array('','Scott','Yen','42AQH'),
			array('','Fei','Yin','48XGZ'),
			array('','Margarita','Yip endo','38QCV'),
			array('','Xuekui','Yu','49YPM'),
			array('','Li','Yuan','46WVN'),
			array('','Chunyan','Yuan','16JMH'),
			array('','Fuko','Zagol','51IAT'),
			array('','Homeira','Zarghamnia','43SEM'),
			array('','Jin','Zeng','31DMR'),
			array('','Yibing','Zeng','41MSK'),
			array('','Carrie','Zhang','43IVN'),
			array('','Fujun','Zhang','40KWN'),
			array('','Liying','Zhang','37ZJP'),
			array('','Ming','Zhang','31TTY'),
			array('','Weilei','Zhang','03NPN'),
			array('','Yang','Zhang','25HCS'),
			array('','Lu','Zhang','45IKW'),
			array('','Li','Zhang','47KSJ'),
			array('','Cuiqin','Zhang','47QWA'),
			array('','Yuyi','Zhang','53GSN'),
			array('','Lingyi','Zhao','41FCD'),
			array('','Zhaohui','Zhong','51JFI'),
			array('','Xiaoyan','Zhou','070HXC'),
			array('','Zhenyu','Zhu','27OJA'),
			array('','Guofen','Zhu','37UEN'),
			array('','Ke','Zhu','49FFA'),
			array('','Pei min','Zou','46QVX'),
			array('','Lucy ying lin','Chan','31TEI'),
			array('','Diane','Dao','41AQI'),
			array('','YIQING','DU','51LKJ'),
			array('KEVIN','QINGHONG','GAO','49YFI'),
			array('Sherry','Xin','Hu','48SZN'),
			array('','Lan','Le','40VEX'),
			array('','Heng','Liu','26QGX'),
			array('','SHIRLEY','NG','48OOZ'),
			array('','Pinhao','Qiu','29ACT'),
			array('','Changyi','Song','28KKC'),
			array('','Ying','Song','36CJL'),
			array('','Cammi','Tam','51DMD'),
			array('','Jennifer thu','Tran','38RVJ'),
			array('Tiffanie','Thao Xuan','Truong','26SKV'),
			array('','Triet minh','Vo','38VCD'),
			array('','ROBERT','WANG','48DPJ'),
			array('Angie','Yanjie','Xu','23UZX'),
			array('','Zhongfa','Yang','29FNS'),
			array('','Qun','Zhang','24VHK'),
			array('','Fei','Zou','46QNH'),
			array('','Honglei','Bu','13MNA'),
			array('','Jinpei','Li','30ZFH'),
			array('','Minna','Millare','53VQT'),
			array('','Linda','Munch','55KPX'),
			array('','Garima','Rai','55PUT'),
			array('','Gerardo','Segarra','53ZGU'),
			array('Helena','Hang','Tan','54LGU'),
			array('','Eva','White','54YOZ'),
			array('','LILY','XU','53XMC'),
			array('Joy','Xin','Zhao','55SLA'),
			array('','Melanie Ann','Villanueva','55PWK'),
			array('','Olivia','Alejandro','55TTS'),
			array('','KRIZZIA','RAMOS','56CPH'),
			array('','ASHLEY','DEGUZMAN','56GPN'),
			array('Bill','XINSHUANG','WANG','56FMP'),
			array('','NICOLE','TORRES','56EMV'),
			array('','ROBERT','YABES','56ERF'),
			array('','David','Haubert','55ZCJ'),
			array('','Wen','Wei','55ZTW'),
			array('','MARY ANN','ARINI','55UQN'),
			array('','MENGSHA','DING','55WVJ'),
			array('','DEMASTER SURVINE','IV','56HWQ'),
			array('','HAZEL','SURVINE','56HWX'),
			array('','ANA SONIA','CRUZ','55PWJ'),
			array('','ZEMIRA','DELCUPOLO','55XMW'),
			array('','RICARDO','DIAS','56BSZ'),
			array('','NATALIE','HOFFSETH','55NGR'),
			array('','TIMOTHY','LEE','56BTN'),
			array('','JURG','MUNCH','55OFO'),
			array('','RAHUL','PURI','55QRS'),
			array('','MARIA','SLOAN','55OFL'),
			array('','EDVIN','TALUSAN','56AQL'),
			array('','WANG','TENNNT','55SKP'),
			array('','MEIHUA','TIAN','55YMC'),
			array('','LUCY','CHAN','099ETC'),
			array('','HELENA','FENG','55GKA'),
			array('','LIJIE','YU','55KZN'),
			array('','STEPHEN','CHANG','09MHXC'),
			array('','JOHN','CHOU','53QXM'),
			array('','JERRY','LIU','54AVH'),
			array('','CLAIRE','SONG','53RGF'),
			array('','WENDY','WU','54EPQ'),
			array('Hellina','HONG','HO','56KSQ'),
			array('','HAI CHAO','WANG','09MVMC'),
			array('','MIKE','MCERLAIN','56IUI'),
			array('','JIANSONG','ZHU','56IUQ'),
			array('','NINGFENG','LIANG','56MNF'),
			array('','Lana','Ho','825PK'),
			array('','BETTY','LAU','56NAW'),
			array('','BHARAT','AGGARWAL','56NVR'),
			array('GRACE','ZHIMIN','LI','56NXP'),
			array('','WEI','ZHANG','56PBY'),
			array('','SIMONA','NEGULESCU','09RCLC'),
			array('MARCO','MARCO','CHOW','56QSQ'),
			array('','RUPA','GUMMADI','56RRQ'),
			array('','MANOLITO','AGRA','56SME'),
			array('','DILLON','HARTWIG','56SBR'),
			array('','ANAKA','PETTIT','56BTK'),
			array('','KIT-LING','WANG','56SOV'),
			array('','ED','HO','193PI'),
			array('','Shirley','Lee','09FTZ'),
			array('','JOHN','DOULL','56YIC'),
			array('','Della','Ding','08CCE'),
		);

		foreach($recruiters as $r){
			$p = strrpos($r[1], ' ');
			$l_first_name = strtolower(trim(substr($r[1], 0, $p)));
			$l_last_name = strtolower(trim(substr($r[1], $p + 1)));

			$find = false;
			foreach($users as $u){
				$v_last_name = strtolower(trim($u[2]));
				$v_first_name = strtolower(trim($u[1]));
				$v_nick_name = strtolower(trim($u[0]));
				if($l_last_name == $v_last_name && 
					( $l_first_name == $v_first_name || $l_first_name == $v_nick_name)){
						$find = true;
						echo "UPDATE users SET recruiter='".$u[3]."' WHERE membership_code='".$r[0]."';<br/>";
						break;
				}
			}
			if(!$find){
				echo "UPDATE users SET recruiter=NULL WHERE membership_code='".$r[0]."';<br/>";
			}
		}
	}
	
	private function _construct_tree_node(&$nodes, $result){
		$next_nodes = array();
		foreach($nodes as $key => $node){
			foreach($result as $r){
				if($r['recruiter'] == $key){
					$nodes[$key]['children'][$r['membership_code']] = array('count' => 0, 'children' => array()); 
					$next_nodes[$r['membership_code']] = &$nodes[$key]['children'][$r['membership_code']];
				}
			}
		}
		if(!empty($next_nodes)){
			$this->_construct_tree_node($next_nodes, $result);
		}
		return;
	}
	
	private function _cal_children_count(&$node, $code){
		$node['count'] += count($node['children']);
		foreach($node['children'] as $k => $c){
			$node['count'] += $this->_cal_children_count($node['children'][$k], $k);
		}
		//echo "UPDATE users SET children=".$node['count']." WHERE membership_code='$code';<br/>";
		return $node['count'];
	}
	
	public function cal_children(){
		$this->load->model('user_model');
		$result = $this->user_model->get_list();
		$tree = array('24KIZ' => array('count' =>0, 'children' => array()));
		$this->_construct_tree_node($tree, $result);
		$this->_cal_children_count($tree['24KIZ']['children']['23UZX'], '23UZX');//$tree['24KIZ']);
		print_r($tree['24KIZ']['children']['23UZX']);
	}
	
	public function get_base_shop($code = null){
		if($this->input->is_ajax_request()){
			$code = $this->input->get('code');
			$start = $this->input->get('start');
			$ret = file_get_contents("https://www.mywfg.com/Wfg.HierarchyTool/Hierarchy/LoadHierarchyTableResults?iDisplayStart=$start&iDisplayLength=5&agentCodeNumber=$code&baseType=0&agentLevel1=-1&lastName=&firstName=&city=&jurisdictionId=&zipCode=&isdowwnline=1");
			echo $ret;
			return;
			$str = array();
			for($i = 0; $i < 12; ++$i){
				$ret = file_get_contents("https://www.mywfg.com/Wfg.HierarchyTool/Hierarchy/LoadHierarchyTableResults?iDisplayStart=".($i * 5)."&iDisplayLength=5&agentCodeNumber=$code&baseType=0&agentLevel1=-1&lastName=&firstName=&city=&jurisdictionId=&zipCode=&isdowwnline=1");
				array_push($str, $ret);
			}
			echo "[".implode(",", $str)."]";
		}
		else{
			$this->load_view('team/baseshop');
		}
	}
	public function sync_members(){
			$this->load_view('team/new_members');
	}
	
	public function get_new_members(){
		if($this->input->is_ajax_request()){
			$this->load->model('user_model');
			$existing_code_list = array();
			$result = $this->user_model->get_list();
			foreach($result as $r){
				$existing_code_list[$r['membership_code']] = $r['grade'];
			}
			echo json_encode($existing_code_list);
		}
	}
	
	public function export($item = 'all'){
		$this->load->model('user_model');
		$result = $this->user_model->get_list();
		header('Content-Type: text/csv; charset=utf-8');
		header("Content-Disposition: attachment; filename=team-members.csv");
		$output = fopen('php://output', 'w');
		if(count($result) > 0){
			$headers = array();
			if($item == 'all'){
				foreach($result[0] as $k => $v){
					array_push($headers, $k);
				}
				fputcsv($output, $headers);
				foreach($result as $r){
					fputcsv($output, $r);
				}
			}
			else if($item == 'mobile_phone'){
				$headers = array('Code', 'Name', 'Mobile Phone');
				fputcsv($output, $headers);
				foreach($result as $r){
					$phone = $r['phone'];
					$pl = explode(',', $phone);
					$tl = array();
					foreach($pl as $p){
						$tl[$p[0]] = $p;
					}
					$mp = '';
					if(array_key_exists('M', $tl)){
						$mp = $tl['M'];
					}
					else if(array_key_exists('H', $tl)){
						$mp = $tl['H'];
					}
					if(!empty($mp)){
						$mp = str_replace(array(' ', '(', ')', '-'), '', (substr($mp, 2)));
					}
					fputcsv($output, array($r['membership_code'], $r['first_name'].' '.$r['last_name'], $mp));
				}
			}
			else if($item == 'google_import'){
				$headers = array('First Name', 'Last Name','E-mail Address', 
					'Home Phone', 'Mobile Phone', 'Home Address', 'Home Street', 
					'Home City', 'Home State', 'Home Postal Code', 'Home Country',
					'Business Phone');
				fputcsv($output, $headers);
				foreach($result as $r){
					$tl = array('H' => '', 'M' => '', 'B' => '');
					$pl = explode(',', $r['phone']);
					foreach($pl as $p){
						$tl[$p[0]] = str_replace(array(' ', '(', ')', '-'), '', (substr($p, 2)));
					}
					$address = $r['street'].', '.$r['city'].', '.$r['state'].' '.$r['zipcode'].', '.$r['country'];
					fputcsv($output, array($r['first_name'], $r['last_name'], $r['email'],
						$tl['H'], $tl['M'], $address, $r['street'], $r['city'], $r['state'], 
						$r['zipcode'], $r['country'], $tl['B']));
				}
			}
		}
		else{
			echo "No data is returned.";
		}
	}
	/*public function retrieve_and_update_member($code = ''){
		$url = "https://www.mywfg.com/Wfg.HierarchyTool/HierarchyDetails/AgentDetails?agentcodenumber=$code";
		$ret = file_get_contents($url);
		$content_array = trim($ret).explode('\n');
		$name = null;
		$phone_list = array();
		$address = array();
		foreach(content_array as $line){
				$line = trim($line);
				if($line != ''){
					$len = strlen($line);
					if(substr($line, -1) == ':'){
						$name = substr($line, 0, $len - 1);
					}
					else{
						switch($name){
							case 'Name':
								$lpos = strpos($line, '(');
								rpos = line.indexOf(')');
								code_len = rpos - lpos - 1;
								$('#membership_code').val(line.substr(line.length - (code_len + 1), code_len)); 
								line = line.substr(0, line.length - (code_len + 2)).trim();
								var pos = line.lastIndexOf(' ');
								$('#first_name').val(line.substr(0, pos));
								$('#last_name').val(line.substr(pos + 1, line.length - pos));
								break;
							case 'Level':
								$('#grade').val(line);
								break;
							case 'Start Date':
								var date = new Date(line);
								var date_str = date.getFullYear() + '-' + String(date.getMonth() + 1).padStart(2, '0') + '-' + String(date.getDate()).padStart(2, '0');
								$('#start_date').val(date_str);
								break;
							case 'DOB':
								var date = new Date(line + ' 2017');
								var date_str = '1900-' + String(date.getMonth() + 1).padStart(2, '0') + '-' + String(date.getDate()).padStart(2, '0');
								$('#date_of_birth').val(date_str);
								break;
							case 'Home Phone':
								phone_list.push('H:' + line);
								break;
							case 'Business Phone':
								phone_list.push('B:' + line);
								break;
							case 'Mobile Phone':
								phone_list.push('M:' + line);
								break;
							case 'Personal Email':
								$('#email').val(line);
								break;
							case 'Home Address':
								address.push(line);
								break;
							case 'Recruiter':
								var p = line.lastIndexOf(' ');
								var l_first_name = line.substr(0, p).toLowerCase();
								var l_last_name = line.substr(p + 1).toLowerCase();
								for(var ii = 0; ii < $('#recruiter option').length; ++ii){
									var obj = $('#recruiter option:nth-child(' + (ii + 1) + ')');
									var v = $(obj).html().trim().toLowerCase();
									var p1 = v.indexOf('(');
									var p2 = v.indexOf(')');
									if(p1 >= 0 && p2 >= 3){
										var v_nick_name = v.substr(p1 + 1, p2 - p1 - 1);
										v = v.substr(0, p1).trim();
									}
									var p = v.lastIndexOf(' ');
									var v_first_name = v.substr(0, p).toLowerCase();
									var v_last_name = v.substr(p + 1).toLowerCase();
									if(l_last_name == v_last_name && 
										( l_first_name == v_first_name || l_first_name == v_nick_name)){
										$('#recruiter').val($(obj).val()).selectpicker('refresh');
										break;
									}
								}
								break;
						}
					}
				}
			}
			if(address.length >= 2){
				$('#street').val(address[0]);
				var ar = address[1].split(',');
				$('#city').val(ar[0].trim());
				ar = ar[1].split('-');
				$('#country').val(ar[1].trim());
				ar = ar[0].trim().split(' ');
				$('#state').val(ar[0].trim());
				$('#zipcode').val(ar[1].trim());
			}
			$('#phone').val(phone_list.join(','));		
		echo $ret;
	}*/
}

