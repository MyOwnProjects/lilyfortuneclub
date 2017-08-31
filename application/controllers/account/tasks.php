<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('account_base.php');
class Tasks extends Account_base_controller {
	public function __construct(){
		parent::__construct();
		if(!array_key_exists(ASSISTANT, $this->user['roles'])){
			header('location: '.base_url().'account/profile');
			exit;
		}
		$this->load->model('task_model');
	}
	
	public function index()
	{
		$status = $this->input->get('status');
		$priority = $this->input->get('priority');
		$priority_list = array();
		$status_list = array();
		$page = $this->input->get('pg');
		if($page <= 0)
			$page = 0;
		else
			$page -= 1;
		$where = "users_id='".$this->user['users_id']."'";
					
		$all_status = array('new' => '<span class="text-red glyphicon glyphicon-plus-sign"></span> New', 'pending' => '<span class="text-danger glyphicon glyphicon-question-sign"></span> Pending', 'reopen' => '<span class="text-danger glyphicon glyphicon-exclamation-sign"></span> Reopen', 'done' => '<span class="text-green glyphicon glyphicon-ok-sign"></span> Done');
		if(is_string($status) && array_key_exists($status, $all_status)){
			$where .= " AND tasks_status='$status'";
		}
		else{
			$status = '';
		}
		$all_priority = array('H' => '<span class="label label-danger">High</span>', 'M' => '<span class="label label-warning">Medium</span>', 'L' => '<span class="label label-success">Low</span>');
		if(is_string($priority) && array_key_exists($priority, $all_priority)){
			$where .= " AND tasks_priority='$priority'";
		}
		else{
			$priority = '';
		}
		$total = $this->task_model->get_list_total($where);
		$result = $this->task_model->get_list($where, array('tasks_update' =>'DESC'), ($page * 20).",20");
		$this->load_view('tasks/list', array('list' => $result, 'all_status' =>$all_status,  'status' => $status, 'all_priority' => $all_priority, 'priority' => $priority, 'current' =>$page +1, 'total' => ceil($total / 20)));
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */