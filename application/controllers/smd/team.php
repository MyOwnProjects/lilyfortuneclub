<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('smd_controller.php');
class Team extends Smd_Controller {
	public function __construct(){
		parent::__construct();
		//	$this->re_signin();
		if(empty($this->user) || $this->user['grade'] !== 'SMD'){
			$this->re_signin();
			//header('location: '.base_url().'smd/ac/sign_in');
		}		
		$this->nav_menus['team']['active'] = true;
	}
	
	public function index()
	{
		$this->nav_menus['team']['sub_menus']['']['active'] = true;
		$this->load_view('team/list');
	}

	public function get_member_list(){
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
		$total = $this->user_model->get_total("smd='".$this->user['users_id']."'", $search);
		if($total > 0){
			$ret = paginate($total, $current, $row_count);
			$ret['search'] = $search_str;
			$ret['rows'] = $this->user_model->get_list("smd='".$this->user['users_id']."'", $sort, (($ret['current'] - 1) * $ret['row_count']).", ".$ret['row_count'], $search);
			foreach($ret['rows'] as $i => $r){
				$ret['rows'][$i]['name'] = $r['name'].(isset($ret['rows'][$i]['nick_name']) && trim($ret['rows'][$i]['nick_name']) != '' ? ' ('.$ret['rows'][$i]['nick_name'].')' : '');
				$ret['rows'][$i]['status'] = $ret['rows'][$i]['status'] == 'active' ? '<span class="label label-success">Active</span>' : '<span class="label label-default">Inactive</span>';
				$ret['rows'][$i]['location'] = empty($r['state']) ? $r['country'] : $r['state'].'/'.$r['country'];
				$ret['rows'][$i]['action'] = array('view' => base_url().'smd/team/member/'.$r['users_id']);
			}
		}
		echo json_encode($ret);
	}

	private function _get_all_smd_members($smd){
		$member_list = $this->user_model->get_list("users_id='$smd' OR smd='$smd'", array('name' => 'ASC'), "", array());
		$upline_opt = array();
		foreach($member_list as $m){
			array_push($upline_opt, array('text'=>$m['name'].(empty($m['nick_name']) ? "" : " (".$m['nick_name'].")"), 'value' => $m['users_id']));
		}
		return $upline_opt;
	}	
	
	public function add_member(){
		$this->load->model('user_model');
		if($this->input->server('REQUEST_METHOD') == 'POST'){
			$prop = $this->input->post();
			$prop['smd'] = $this->user['users_id'];
			$prop['username']= $prop['membership_code'];
			$prop['password']= sha1(strtoupper(trim($prop['membership_code']).trim($prop['last_name'])));
			$res = $this->user_model->new_user($prop);
			if($res){
				echo json_encode(array('success' => true));
				return;
			}
			else{
				echo json_encode(array('success' => false, 'message' => 'Failed to add member'));
			}
		}
		$upline_opt = $this->_get_all_smd_members($this->user['users_id']);
		$items = array(
			array(
				'name' => 'auto-fill',
				'fill_type' => 'team_member',
			),
			array(
				'label' => 'Membership Code',
				'name' => 'membership_code',
				'tag' => 'input',
				'required' => true,
			),
			array(
				'label' => 'Upline',
				'name' => 'parent',
				'tag' => 'select',
				'class' => 'selectpicker',
				'options' => $upline_opt
			),
			array(
				'label' => 'Start Date',
				'name' => 'start_date',
				'tag' => 'input',
				'type' => 'date',
				'placeholder' => 'YYYY-MM-DD',
			),
			array(
				'label' => 'First Name',
				'name' => 'first_name',
				'tag' => 'input',
				'required' => true,
			),
			array(
				'label' => 'Last Name',
				'name' => 'last_name',
				'tag' => 'input',
				'required' => true,
			),
			array(
				'label' => 'Nick Name',
				'name' => 'nick_name',
				'tag' => 'input',
			),
			array(
				'label' => 'Email',
				'name' => 'email',
				'tag' => 'input',
			),
			array(
				'label' => 'Date of Birth',
				'name' => 'date_of_birth',
				'tag' => 'input',
				'type' => 'date',
				'placeholder' => 'YYYY-MM-DD',
			),
			array(
				'label' => 'Phone',
				'name' => 'phone',
				'tag' => 'input',
			),
			array(
				'label' => 'Street',
				'name' => 'street',
				'tag' => 'input',
			),
			array(
				'label' => 'City',
				'name' => 'city',
				'tag' => 'input',
			),
			array(
				'label' => 'State',
				'name' => 'state',
				'tag' => 'input',
				'value' => 'CA'
			),
			array(
				'label' => 'Zipcode',
				'name' => 'zipcode',
				'tag' => 'input',
			),
			array(
				'label' => 'Country',
				'name' => 'country',
				'tag' => 'input',
				'value' => 'US'
			),
			array(
				'label' => 'Level',
				'name' => 'grade',
				'tag' => 'select',
				'options' => array(
					array('value' => 'G', 'text' => 'Guest'),
					array('value' => 'TA', 'text' => 'Trainee Associate'),
					array('value' => 'A', 'text' => 'Associate'),
					array('value' => 'SA', 'text' => 'Senior Associate'),
					array('value' => 'MD', 'text' => 'Margeting Director')
				),
				'value' => 'TA',
			),
		);
		$this->load->view('smd/add_item', array('items' => $items));
	}

	public function member($id = 0){
		$this->load->model('user_model');
		$result = $this->user_model->get_user_by(array('users_id' => $id, 'smd'=> $this->user['users_id']));
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
	
	public function Hierarchy($id = 0){
		$error = '';
		if(empty($id)){
			$id = $this->user['users_id'];
		}
		if($id != $this->user['users_id']){
			$result = $this->user_model->get_user_by(array('users_id' => $id, 'smd' => $this->user['users_id']));
			if(count($result) == 0){
				$error = "The member does not exist, or you don't have permission";
			}
		}
		$this->nav_menus['team']['sub_menus']['hierarchy']['active'] = true;
		$this->load_view('team/hierarchy', array('error' => $error, 'parent' => $id));
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
		
		$total = $this->user_model->get_total("parent='".$id."'", $search);
		if($total > 0){
			$ret = paginate($total, $current, $row_count);
			$ret['search'] = $search_str;
			$ret['rows'] = $this->user_model->get_list("parent='".$id."'", $sort, ($ret['current'] - 1).", ".$ret['row_count'], $search);
			foreach($ret['rows'] as $i => $r){
				$ret['rows'][$i]['name'] = $r['name'].(isset($ret['row'][$i]['nick_name']) && trim($ret['rows'][$i]['nick_name']) != '' ? ' ('.$ret['rows'][$i]['nick_name'].')' : '');
				$ret['rows'][$i]['status'] = $ret['rows'][$i]['status'] == 'active' ? '<span class="label label-success">Active</span>' : '<span class="label label-default">Inactive</span>';
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

	public function get_direct_downline($user_id= null){
		$this->load->model('user_model');
		$result = $this->user_model->get_child_users($user_id, $this->user['users_id']);
		if(count($result) == 0){
			$data = 'No downline';
		}
		else{
			$data = array();
			foreach($result as $r){
				$t = $r['grade'];
				$t .= ", ".($r['status'] == 'active' ? '<span class="label label-success">Active</span>' : '<span class="label label-default">Inactive</span>');
				$t .= ", ".($r['count'] == 0 ? '<span class="text-danger">No downline</span>' : '<span class="text-success">'.$r['children'].' downline , '.$r['count'].' direct downline</span>');
				
				if(isset($user_id)){
					$url = base_url().'smd/team/member/'.$r['users_id'];
				}
				else{
					$url = base_url().'smd';
				}
				array_push($data, array(
					'text' => '<a href="'.$url.'">'.$r['first_name'].' '.$r['last_name']
						.(empty($r['nick_name']) ? '' : '('.$r['nick_name'].')')."</a>&nbsp;"
						."[$t]"
					, 'child_count' => $r['count'] 
					, 'child_url' => base_url().'smd/team/get_direct_downline/'.$r['users_id']
				));
			}
		}
		echo json_encode(array('success' => true, 'data' => $data));		
	}	
	
	public function update_user($field = null, $id = 0){
		$result = $this->user_model->get_user_by(array('smd' => $this->user['users_id'], 'users_id' => $id));
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
					);
					break;
				case 'parent':
					$items = array(
						array(
							'label' => 'Upline',
							'name' => 'parent',
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
					}
					break;
				case 'address':
				case 'parent':
				case 'name':
				case 'date_of_birth':
				case 'start_date':
				case 'grade':
					foreach($this->input->post() as $n => $v){
						$values[$n] = trim($v);
					};
					break;
					
				//case 'SMD':
				//	break;
				case 'nick_name':
				case 'email':
				case 'username':
				case 'membership_code':
				case 'phone':
				case 'status':
					$values[$field] = $this->input->post($field);
					break;
				default:
					ajax_error(500, "Invalid field.");
			}
			if($this->user_model->update($id, $values)){
				echo json_encode(array('success' => true));
			}
			else{
				echo json_encode(array('success' => false, 'message' => 'Failed to update value.'));
			}
		}
	}
	
	
	public function email(){
	}
}

