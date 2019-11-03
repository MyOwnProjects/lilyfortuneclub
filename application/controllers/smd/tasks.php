<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('smd_controller.php');
class Tasks extends Smd_Controller {
	public function __construct(){
		parent::__construct();
		if(empty($this->user) || $this->user['grade'] !== 'SMD'){
			header('location: '.base_url().'smd/ac/sign_in');
		}		
		$this->load->model('task_model');
		$this->nav_menus['tasks']['active'] = true;
	}
	
	public function index()
	{
		$this->nav_menus['tasks']['sub_menus']['']['active'] = true;
		$this->load_view('tasks/list');
	}
	
	public function ajax_task_list(){
		if($this->input->is_ajax_request()){
			$result = $this->task_model->get_internal_task_list();
			echo json_encode($result);
		}
	}
	
	public function get_task_list(){
		$search_str = trim($this->input->post('search'));
		$search = isset($search_str) && $search_str !== '' ? preg_split('/[^a-z0-9]/i', $search_str) : array();
		$current = $this->input->post('current');
		$row_count= $this->input->post('row_count');
		$sort = $this->input->post('sort');
		$filter = $this->input->post('filter');
		$where = "1=1 ";
		if(!empty($search)){
			$serch_where = array();
			foreach($search as $s){
				array_push($serch_where, "tasks_subject LIKE '%$s%' OR tasks_case_no LIKE '%$s%' OR tasks_name LIKE '%$s%'");
			}
			$where .= " AND (".implode(" OR ", $serch_where).") ";
		}
		
		$fa = array();
		if($filter){
			foreach($filter as $k => $v){
				if(is_null($v) || $v == ''){
				}
				else if($k == 'tasks_due_date'){
					$today = date_create();
					$tomorrow = new DateTime('tomorrow');
					if($v == '2 days'){
						array_push($fa, "($k='".date_format($today, 'Y-m-d')."' OR $k='".date_format($tomorrow, 'Y-m-d')."')");
					}
					else if($v == 'future'){
						array_push($fa, "($k>='".date_format($today, 'Y-m-d')."')");
					}
				}
				else{
					array_push($fa, "$k='$v'");
				}
			}
		}
		$where .= empty($fa) ? "" : " AND (".implode(" AND ", $fa).")";
		$ret = array(
			'current' => 1,
			'last' => 0,
			'row_count' => $row_count,
			'search' => $search_str,
			'rows' => array(),
			'total' => 0
		);
		$total = $this->task_model->get_list_total($where);
		if($total > 0){
			$ret = paginate($total, $current, $row_count);
			$ret['search'] = $search_str;
			$ret['rows'] = $this->task_model->get_list($where, $sort, (($ret['current'] - 1) * $ret['row_count']).", ".$ret['row_count']);
			foreach($ret['rows'] as $i => $r){
				$ret['rows'][$i]['id'] = $r['tasks_id'];
				$ret['rows'][$i]['tasks_case_no'] = $r['tasks_case_no'];
				$ret['rows'][$i]['tasks_subject'] = $r['tasks_subject'];
				$ret['rows'][$i]['tasks_type'] = $r['tasks_type'];
				if($r['tasks_priority']== 'H'){
					$c = 'badge-danger';
					$t = 'High';
				}
				else if($r['tasks_priority']== 'M'){
					$c = 'badge-warning';
					$t = 'Meduim';
				}
				else{
					$c = 'badge-success';
					$t = 'Low';
				}
				$ret['rows'][$i]['tasks_priority'] = '<span class="badge '.$c.'">'.$t.'</span>';
				$ret['rows'][$i]['tasks_source'] = $r['tasks_source'];
				
				if($r['tasks_status'] == 'new'){
					$c = 'text-red fa fa-plus-circle';
				}
				else if($r['tasks_status'] == 'pending'){
					$c = 'text-danger fa fa-exclamation-circle';
				}
				else if($r['tasks_status'] == 'done'){
					$c = 'text-green fa fa-check-circle';
				}
				else{//reopen
					$c = 'text-danger fa fa-exclamation-circle';
				}
				$ret['rows'][$i]['tasks_status'] = '<i class="'.$c.'"></i> '.$r['tasks_status'];
				$ret['rows'][$i]['tasks_create'] = isset($r['tasks_create']) ? date_format(date_create($r['tasks_create']), 'M j') : '';
				$ret['rows'][$i]['tasks_due_date'] = isset($r['tasks_due_date']) ? date_format(date_create($r['tasks_due_date']), 'M j') : '';
				$ret['rows'][$i]['tasks_name'] = empty($r['first_name']) && empty($r['last_name']) && empty($r['nick_name']) ? $r['tasks_name'] : $r['first_name'].' '.$r['last_name'].(empty($r['nick_name']) ? '' : ' ('.$r['nick_name'].')');
				$ret['rows'][$i]['action'] =  array(
					'view' => base_url().'smd/tasks/view/'.$r['tasks_id']
				);
			}
		}
		echo json_encode($ret);
	}
	
	
	public function view($id = 0){
		$this->load->model('user_model');
		$result = $this->user_model->get_list('', $sort = array('last_name' => 'ASC', 'first_name' => 'ASC'));
		$users = array();
		foreach($result as $u){
			array_push($users, array('text' => ucwords(strtolower($u['last_name'])).', '.ucwords(strtolower($u['first_name'])).(empty($u['nick_name']) ? '' : ' ('.ucwords(strtolower($u['nick_name'])).')').' - '.$u['membership_code'], 'value' => $u['membership_code']));
		}
		
		$result = $this->task_model->get_list("tasks_id='$id'");
		if(count($result) == 0){
			$this->load_view('tasks/create', array('error' => 'The task does not exist.'));
			return;
		}
		$this->load_view('tasks/create', array('task' => $result[0], 'users' => $users));
		
		//$this->load_view('tasks/create', $result[0]);
	}
	
	public function update($id = 0){
		$result = $this->task_model->get_list("tasks_id='$id'");
		if(count($result) == 0){
			$this->load_view('tasks/create', array_merge($this->input->post(), array('error' => 'The task does not exist.')));
			return;
		}
		
		if($this->task_model->update($this->input->post(), "tasks_id='$id'")){
			header('location: '.base_url().'smd/tasks');
		}
		else{
			$this->load_view('tasks/create', array_merge($this->input->post(), array('error' => 'Failed to update task.')));
			return;
		}
	}
	
	public function delete(){
		if($this->input->server('REQUEST_METHOD') == 'POST'){
			$ids = $this->input->post('selected_ids');
			$where = "tasks_id IN ('".implode("','", $ids)."')";
			$this->task_model->delete($where);
			echo json_encode(array('success' => true));
		}
		else{
			$items = array(
				array(
					'tag' => 'text', 'text' => 'Do you want to delete the task(s)?' 
				)
			);
			$this->load->view('smd/add_item', array('items' => $items));
		}
	}
	
	public function create(){
		$error = '';
		if($this->input->server('REQUEST_METHOD') == 'POST'){
			$case_no = trim($this->input->post('tasks_case_no'));
			$name = trim($this->input->post('tasks_name'));
			$subject = trim($this->input->post('tasks_subject'));
			$detail = trim($this->input->post('tasks_detail'));
			$type = trim($this->input->post('tasks_type'));
			$source = trim($this->input->post('tasks_source'));
			$priority = $this->input->post('tasks_priority');
			$create = $this->input->post('tasks_create');
			$due_date = $this->input->post('tasks_due_date');
			$status = $this->input->post('tasks_status');
			if($this->task_model->insert($case_no, $name, $subject, $detail, $type, $source, $priority, $create, $due_date, $status)){
				header('location: '.base_url().'smd/tasks');
				exit;
			}
			$error = 'Failed to create task';
		}
		$this->load->model('user_model');
		$result = $this->user_model->get_list('', $sort = array('last_name' => 'ASC', 'first_name' => 'ASC'));
		$users = array();
		foreach($result as $u){
			array_push($users, array('text' => ucwords(strtolower($u['last_name'])).', '.ucwords(strtolower($u['first_name'])).(empty($u['nick_name']) ? '' : ' ('.ucwords(strtolower($u['nick_name'])).')').' - '.$u['membership_code'], 'value' => $u['membership_code']));
		}
		
		$this->load_view('tasks/create', array('task' => $this->input->post(), 'error' => $error, 'users' => $users));
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */