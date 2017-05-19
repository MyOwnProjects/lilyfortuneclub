<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('base.php');
class Events extends Base_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('event_model');
	}
	
	public function index()
	{
		$this->load_view('events');
	}

	public function get_list(){
		$result = $this->event_model->get_list("events_end_time>'".date_format(date_create(), 'Y-m-d 00:00:00')."'", array('events_start_time DESC'));
		foreach($result as $i => $r){
			$result[$i]['events_start_date'] = date_format(date_create($r['events_start_time']), 'M d');
			$result[$i]['events_end_date'] = date_format(date_create($r['events_end_time']), 'M d');
		}
		//header('Content-Type: application/json; charset=charset=ISO-8859-1');
		echo json_encode($result);
	}
	
	public function item($id = null){
		$days = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
		$result = $this->event_model->get_list("events_id='$id'");
		if(count($result) > 0){
			$result[0]['start_date'] = $days[date_format(date_create($result[0]['events_start_time']), 'w')].date_format(date_create($result[0]['events_start_time']), ', M d');
			$result[0]['start_time'] = date_format(date_create($result[0]['events_start_time']), 'h:i A');
			$result[0]['end_date'] = $days[date_format(date_create($result[0]['events_end_time']), 'w')].date_format(date_create($result[0]['events_end_time']), ', M d');
			$result[0]['end_time'] = date_format(date_create($result[0]['events_end_time']), 'h:i A');
			if($this->input->is_ajax_request()){
				echo json_encode($result[0]);
			}
		}
		if(!$this->input->is_ajax_request()){
			header('location: '.base_url().'events');
		}
	}
	
	public function sign_up(){
		$post = $this->input->post();
		$value = array(
			'event_guests_event_id' => $post['event_guests_event_id'],
			'event_guests_name' => strip_tags($post['event_guests_name']),
			'event_guests_email' => strip_tags($post['event_guests_email']),
			'event_guests_phone' => strip_tags($post['event_guests_phone']),
			'event_guests_referee' => strip_tags($post['event_guests_referee']),
		);
		echo json_encode(array('success' => $this->event_model->add_event_guest($value)));
	}
}

