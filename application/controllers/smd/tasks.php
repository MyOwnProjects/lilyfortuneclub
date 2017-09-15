<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('smd_controller.php');
class Tasks extends Smd_Controller {
	public function __construct(){
		parent::__construct();
		if(empty($this->user) || $this->user['grade'] !== 'SMD'){
			$this->redirect('smd/ac/sign_in');
			//header('location: '.base_url().'smd/ac/sign_in');
		}		
		$this->load->model('task_model');
		$this->nav_menus['tasks']['active'] = true;
	}
	
	public function index()
	{
		$this->nav_menus['tasks']['sub_menus']['']['active'] = true;
		$this->load_view('tasks/list');
	}
	
	public function get_task_list(){
		$search_str = trim($this->input->post('search'));
		$search = isset($search_str) && $search_str !== '' ? preg_split('/[^a-z0-9]/i', $search_str) : array();
		$current = $this->input->post('current');
		$row_count= $this->input->post('row_count');
		$sort = $this->input->post('sort');
		$filter = $this->input->post('filter');
		$where = '1=1 ';
		if(!empty($search)){
			$serch_where = array();
			foreach($search as $s){
				array_push($serch_where, "tasks_subject LIKE '%$s%' OR first_name LIKE '%$s%' OR last_name LIKE '%$s%'");
			}
			$where .= " AND (".implode(" OR ", $serch_where).") ";
		}
		$where .= (empty($filter) || is_null($filter[key($filter)]) || $filter[key($filter)] == '' ? "" : " AND ".key($filter)."='".$filter[key($filter)]."'");
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
				$ret['rows'][$i]['tasks_id'] = str_pad($r['tasks_id'], 5, '0', STR_PAD_LEFT);
				$ret['rows'][$i]['subject'] = $r['tasks_subject'];
				if($r['tasks_priority']== 'H'){
					$c = 'label-danger';
					$t = 'High';
				}
				else if($r['tasks_priority']== 'M'){
					$c = 'label-warning';
					$t = 'Meduim';
				}
				else{
					$c = 'label-success';
					$t = 'Low';
				}
				$ret['rows'][$i]['tasks_priority'] = '<span class="label '.$c.'">'.$t.'</span>';
				
				if($r['tasks_status'] == 'new'){
					$c = 'text-red glyphicon glyphicon-plus-sign';
				}
				else if($r['tasks_status'] == 'pending'){
					$c = 'text-danger glyphicon glyphicon-question-sign';
				}
				else if($r['tasks_status'] == 'done'){
					$c = 'text-green glyphicon glyphicon-ok-sign';
				}
				else{//reopen
					$c = 'text-danger glyphicon glyphicon-exclamation-sign';
				}
				$ret['rows'][$i]['tasks_status'] = '<span class="'.$c.'"></span> '.$r['tasks_status'];
				$ret['rows'][$i]['tasks_update'] = date_format(date_create($r['tasks_update']), 'm/d g:i A');
				$ret['rows'][$i]['tasks_due'] = (isset($r['tasks_due_date']) ? date_format(date_create($r['tasks_due_date']), 'm/d ') : '').(isset($r['tasks_due_time']) ? date_format(date_create($r['tasks_due_time']), 'g:i A') : '');
				$ret['rows'][$i]['tasks_user'] = $r['first_name'].' '.$r['last_name'];
				$ret['rows'][$i]['action'] =  array(
					'view' => base_url().'smd/tasks/view/'.$r['tasks_id']
				);
			}
		}
		echo json_encode($ret);
	}
	
	
	public function view($id = 0){
		$this->load->model('user_model');
		$assistants = $this->user_model->get_all_assistants();
		$result = $this->task_model->get_list("tasks_id='$id'");
		if(count($result) == 0){
			$this->load_view('tasks/create', array('error' => 'The task does not exist.'));
			return;
		}
		
		$this->load_view('tasks/create', array('tasks_id' => $result[0]['tasks_id'], 'subject' => $result[0]['tasks_subject'], 'tasks_priority' => $result[0]['tasks_priority'],
			'tasks_user_id' => $result[0]['tasks_user_id'], 'tasks_detail' => $result[0]['tasks_detail'], 'assistants' => $assistants, ));
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
			$subject = trim($this->input->post('tasks_subject'));
			$priority = $this->input->post('tasks_priority');
			$user_id = $this->input->post('tasks_user_id');
			$due_date = $this->input->post('tasks_due_date');
			$due_time = $this->input->post('tasks_due_time');
			$detail = $this->input->post('tasks_detail');
			if($this->task_model->insert($user_id, $subject, $detail, $priority, $due_date, $due_time)){
				header('location: '.base_url().'smd/tasks');
				exit;
			}
			$error = 'Failed to create task';
		}
		$this->load->model('user_model');
		$assistants = $this->user_model->get_all_assistants();
		$this->load_view('tasks/create', array_merge($this->input->post() ? $this->input->post() : array(), array('assistants' => $assistants, 'error' => $error)));
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */