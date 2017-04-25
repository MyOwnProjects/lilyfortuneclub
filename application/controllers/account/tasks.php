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
	
	public function view($file){
		$result = $this->document_model->get_list("uniqid='$file'");
		if(count($result) != 1){
			$this->load_view('documents/view', array('error' => 'The document does not exist.'));
			return;
		}
		if(!empty($result[0]['file_name'])){
			$full_path = getcwd().'/application/documents/'.$result[0]['uniqid'].'.'.$result[0]['file_name'];
			if(!file_exists($full_path)){
				$this->load_view('documents/view', array('error' => 'The document does not exist.'));
				return;
			}
			$ext = pathinfo($result[0]['uniqid'].'.'.$result[0]['file_name'], PATHINFO_EXTENSION);
			$file = uniqid().'.'.$ext;
			$to = getcwd().'/src/temp/'.$file;
			if(!@copy($full_path, $to)){
				$this->load_view('documents/view', array('error' => 'The document does not exist.'));
				return;
			}
			$mime_type = mime_type($full_path);
			$content_mime_type = $mime_type[0];
		}
		else{
			$content_mime_type = $result[0]['mime_content_type'];
		}
		$this->load_view('documents/view', array('subject' => $result[0]['subject'], 'content_type' => $result[0]['content_type'], 'html_content' =>$result[0]['html_content'], 'mime_type' => $content_mime_type, 'file' => $file, 'name' => $result[0]['file_name'],
			/*infolab.stanford.edu/pub/papers/google.pdf'*/ 'src'=> 'https://docs.google.com/gview?url=%s&embedded=true'));
	}
	
	public function delete_temp_document(){
		$file = $this->input->get('file');
		unlink(getcwd().'/src/temp/'.$file);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */