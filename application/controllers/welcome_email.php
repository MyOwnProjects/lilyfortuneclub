<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('base.php');
class Welcome_email extends Base_controller {
	public function __construct(){
		parent::__construct();		
		if($redirect = $this->not_signed_in()){
			header("location: $redirect");
			exit;
		}
	}
	
	public function index(){
		$result = $this->user_model->get_user_by();
		$this->load_view('account/welcome_email', array('members' => $result));
	}
	
	public function new_question(){
		$c_id = $this->input->post('category');
		$subject = $this->input->post('subject');
		$body = $this->input->post('body');
		$result = $this->editable_contents_model->new_question($this->user, $c_id, $subject, $body);
		echo json_encode(array('success' => $result));
	}
	
	public function update_question(){
		$g_id = $this->input->post('question');
		$subject = $this->input->post('subject');
		$body = $this->input->post('body');
		$result = $this->editable_contents_model->update_question($this->user, $g_id, $subject, $body);
		echo json_encode(array('success' => $result));
	}

	public function get_question($q_id = null){
		$result = $this->editable_contents_model->get_question($q_id);
		if(count($result) == 1){
			echo json_encode($result[0]);
		}
		else{
			echo json_encode(array());
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */