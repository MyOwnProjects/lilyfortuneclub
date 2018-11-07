<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('base.php');
class Schedule extends Base_controller {
	private $list_content;
	public function __construct(){
		parent::__construct();
		$this->load->model('schedule_model');
	}
	
	public function index(){
		$this->load_view('schedule');
		return;
		$result = $this->courses_model->get_course_list();
		$courses = array();
		foreach($result as $r){
			if(!array_key_exists($r['courses_id'], $courses)){
				$courses[$r['courses_id']]= array('courses_topic' => $r['courses_topic'], 'courses_desc' => $r['courses_desc'],
					'courses_type' => $r['courses_type'], 'docs' => array());
			}
			if(!empty($r['uniqid'])){
				array_push($courses[$r['courses_id']]['docs'], array('uniqid' => $r['uniqid'], 
					'mime_content_type' => $r['mime_content_type'], 'subject' => $r['subject'], 'file_name' => $r['file_name']));
			}
		}
		$this->load_view('courses', array('courses' => $courses));
	}
	
	public function get_event($id = 0){
		$result = $this->schedule_model->get_list("schedule_id='$id'");
		if(count($result)<= 0){
			echo "Invalid event id.";
		}
		else{
			echo $this->load->view('schedule_event_view', $result[0], true);
		}
	}
	
	public function get_events(){
		$result = $this->schedule_model->get_list();
		$ret = array();
		foreach($result as $r){
			array_push($ret, array(
				'id' => $r['schedule_id'], 
				'title' => '<br/>'.'Topic: '.$r['schedule_topic']
					.(empty($r['schedule_presenters']) ? '' : '<br/>Presenters: '.$r['schedule_presenters'])
					.(empty($r['location']) ? '' : '<br/>'.$r['location']),
				'start' => $r['schedule_start_date'].' '.$r['schedule_start_time'],
				'end' => $r['schedule_end_date'].' '.$r['schedule_end_time']
			));
		}
		echo json_encode($ret);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */