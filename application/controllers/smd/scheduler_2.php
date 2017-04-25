<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('smd_controller.php');
class Scheduler extends Smd_Controller {

	public function __construct(){
		parent::__construct();
	}
	
	public function index()
	{
		$this->load->view('smd/template', array('view' => 'scheduler', 'user' => $this->user));
	}
	
	public function get_events(){
		if($this->is_ajax()){
			$this->load->model('event_model');
			$start_date = $this->input->get('start');
			$end_date = $this->input->get('end');
			$result = $this->event_model->get_events_by_date($start_date, $end_date, $this->user['users_id']);
			$events = array();
			foreach($result as $r){
				if(!array_key_exists($r['events_id'], $events)){
					$events[$r['events_id']] = array('subject' => $r['subject']);
					$events[$r['events_id']]['time'] = array();
				}
				array_push($events[$r['events_id']]['time'], 
					array($r['event_date'].' '.$r['event_start_time'], $r['event_date'].' '.$r['event_end_time'])
				);
			}
			echo json_encode($events);
		}
	}
	
	public function get_event(){
		$event_id = $this->input->get('id');
		if($event_id <= 0){
			//get All users
			echo $this->load->view('smd/event_modal', array('is_new' => true));
		}
		else{
			$this->load->model('event_model');
			$result = $this->event_model->get_event_by_id($this->user['users_id'], $event_id);
			if(count($result) <= 0)
				return;
			$event = array('subject' => $result[0]['subject'], 'detail' => $result[0]['detail'], 'user_id' => $result[0]['user_id'], 'time' => array());
			foreach($result as $r){
				array_push($event['time'], 
					array($r['event_date'].' '.$r['event_start_time'], $r['event_date'].' '.$r['event_end_time']));
			}
			echo $this->load->view('smd/event_modal', array('is_new' => false, 'event' => $event));
		}
	}
	
	public function update_event(){
		if(!$this->is_ajax()){
			echo json_encode(array('success' => false));
			return;
		}

		$id = $this->input->post('id');
		$subject = $this->input->post('subject');
		$detail = $this->input->post('detail');
		$time = $this->input->post('time');
		$this->load->model('event_model');
		$res = $this->event_model->update_event($this->user['users_id'], $id, strip_tags($subject), strip_tags($detail), $time);
		echo json_encode(array('success' => $res !== false));
	}
	
	public function delete_event(){
		if(!$this->is_ajax()){
			echo json_encode(array('success' => false));
			return;
		}

		$id = $this->input->get('id');
		$this->load->model('event_model');
		$res = $this->event_model->delete_event($this->user['users_id'], $id);
		echo json_encode(array('success' => $res !== false));
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */