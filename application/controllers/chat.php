<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chat extends CI_Controller {

	public function __construct(){
		parent::__construct();
		if(!$this->input->is_ajax_request()){
			exit;
		}
	}
	
	public function index(){
		if($this->input->server('REQUEST_METHOD') == 'POST'){
			$session_id = $this->input->get('session');
			$message = trim(strip_tags($this->input->post('message')));
			if(strlen($message) == 0){
				echo json_encode(array());
				return;
			}
			$now = date_create();
			if(empty($session_id)){
				$this->load->model('live_chat_model');
				$session_id = uniqid();
				$name = $this->input->post('name');
				$email = $this->input->post('email');
				$id = $this->live_chat_model->initiate_session($session_id, $name, $email);
				if($id === false){
					echo json_encode(array());
				}
				$this->live_chat_model->insert_chat_message($id, $message, 'REQ', date_format($now, 'Y-m-d H:i:s'));
			}
			echo json_encode(array('session' => $session_id, 'sender' => 'guest', 'message' => $message, 'time' => date_format($now, 'H:i:s')));
		}
		else{
			$session_id = $this->input->get('session');
			$this->load->model('live_chat_model');
			$results = $this->live_chat_model->get_response_messages($session_id);
			$message_ids = array();
			$messages = array();
			foreach($results as $r){
				array_push($messages, array('message' => $r['message_text'], 'time' => date_format(date_create($r['timestamp']), 'H:i:s')));
				array_push($message_ids, $r['live_chat_message_id']);	
			}
			if(!empty($message_ids)){
				$this->live_chat_model->delete_messages($message_ids);
			}
			echo json_encode(array('session' => $session_id, 'respondent' => empty($results) ? null : $results[0]['respondent'], 'messages' => $messages));
		}
	}
	
	public function init_session(){
		$name = $this->input->post('name');
		$email = $this->input->post('email');
		$session_id = uniqid();
		$this->load->model('live_chat_model');
		if($this->live_chat_model->initiate_session($session_id, $name, $email)){
			
		}
		else{
			
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */