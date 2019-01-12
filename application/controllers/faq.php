<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('base.php');
class Faq extends Base_controller {
	public function __construct(){
		parent::__construct();		
		if($redirect = $this->not_signed_in()){
			header("location: $redirect");
			exit;
		}
		$this->load->model('editable_contents_model');
	}
	
	public function index(){
		$active_page = intval($this->input->get('active_page'));
		$result = $this->editable_contents_model->get_all();
		$c = array();
		foreach($result as $r){
			$c_id = $r['editable_contents_categories_id'];
			if($r['parent'] == 0){
				if(!array_key_exists($c_id, $c)){
					$c[$c_id] = array('text' => $r['editable_contents_categories_text'], 
						'sub_c' => array()
					);
				}
			}
			else{
				$c[$r['parent']]['sub_c'][$c_id] = array('text' => $r['editable_contents_categories_text'], 
					'questions' => array());
			}
		}
		foreach($result as $r){
			$c_id = $r['editable_contents_categories_id'];
			if(isset($r['editable_contents_id'])){
				$c[$r['parent']]['sub_c'][$c_id]['questions'][$r['editable_contents_id']] = array(
					'subject' => $r['editable_contents_subject'], 
					'body' => $r['editable_contents_body'],
					'editable' => $r['editable_contents_editable']
				);
			}
		}
		$this->load_view('account/faq', array('editable_contents' => $c, 'active_page' => $active_page));
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