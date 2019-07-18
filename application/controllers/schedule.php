<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('base.php');
class Schedule extends Base_controller {
	private $list_content;
	private $default_events = array(
		'Monday' => array(
			'schedule_id' => 'e0',
			'schedule_start_date' => '',
			'schedule_start_time' => '10:00:00',
			'schedule_end_date' => null,
			'schedule_end_time' => '12:00:00',
			'schedule_location' => 'San Jose',
			'schedule_address' => null,
			'schedule_topic' => "Case Study Training",
			'schedule_presenters' => "",
			'schedule_comment' => null
		),
		'Tuesday' => array(
			'schedule_id' => 'e1',
			'schedule_start_date' => '',
			'schedule_start_time' => '19:00:00',
			'schedule_end_date' => null,
			'schedule_end_time' => '21:00:00',
			'schedule_location' => 'San Jose',
			'schedule_address' => null,
			'schedule_topic' => "BPM\nProfessional Training",
			'schedule_presenters' => "",
			'schedule_comment' => null
		),
		'wednesday' => array(
			'schedule_id' => 'e2',
			'schedule_start_date' => '',
			'schedule_start_time' => '19:00:00',
			'schedule_end_date' => null,
			'schedule_end_time' => '21:00:00',
			'schedule_location' => 'Fremont',
			'schedule_address' => null,
			'schedule_topic' => "BPM\nProfessional Training",
			'schedule_presenters' => "",
			'schedule_comment' => null
		),
		'Thursday' => array(
			'schedule_id' => 'e3',
			'schedule_start_date' => '',
			'schedule_start_time' => '19:00:00',
			'schedule_end_date' => null,
			'schedule_end_time' => '21:00:00',
			'schedule_location' => 'Online',
			'schedule_address' => null,
			'schedule_topic' => "Distance Training",
			'schedule_presenters' => "",
			'schedule_comment' => '<br/>Zoom - <a href="https://zoom.us/j/797669485" target="_blank">https://zoom.us/j/797669485</a><br/>Phone - 6699006833, 4086380968, 6468769923'
		),
		'Saturday' => array(
			'schedule_id' => 'e4',
			'schedule_start_date' => '',
			'schedule_start_time' => '10:00:00',
			'schedule_end_date' => null,
			'schedule_end_time' => '12:00:00',
			'schedule_location' => 'Fremont',
			'schedule_address' => null,
			'schedule_topic' => "BPM\nProfessional Training",
			'schedule_presenters' => null,
			'schedule_comment' => null
		),
	);
	
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
			foreach($this->default_events as $de){
				if($de['schedule_id'] == $id){
					$start = $this->input->get('start');
					$de['schedule_start_date'] = date_format(date_create($start), 'Y-m-d');
					$c = count(explode("\n", $de['schedule_topic']));
					$de['schedule_presenters'] = "TDB";
					for($i = 1; $i < $c; ++$i){
						$de['schedule_presenters'] .= "\nTBD";
					}
					echo $this->load->view('schedule_event_view', $de, true);
					break;
				}
			}
		}
		else{
			echo $this->load->view('schedule_event_view', $result[0], true);
		}
	}
	
	private function _default_events($the_day, $result){
		$result1 = array();
		$current_year = date_format(date_create(), 'Y');
		$next_year = intval($current_year) + 1;
		$startDate = strtotime("$current_year-01-01");
		$endDate = strtotime("$next_year-01-01");
		for($j = strtotime($the_day, $startDate); $j < $endDate; $j = strtotime('+1 week', $j)){
			$date_str = date('Y-m-d', $j);
			$this->default_events[$the_day]['schedule_start_date'] = $date_str;
			$this->default_events[$the_day]['schedule_end_date'] = $date_str;
			$exist = false;
			for($i = 0; $i < count($result); ++$i){
				if($result[$i]['schedule_start_date'] == $this->default_events[$the_day]['schedule_start_date']
					&& $result[$i]['schedule_start_time'] == $this->default_events[$the_day]['schedule_start_time']
					&& $result[$i]['schedule_end_date'] == $this->default_events[$the_day]['schedule_end_date']
					&& $result[$i]['schedule_end_time'] == $this->default_events[$the_day]['schedule_end_time']
					&& $result[$i]['schedule_location'] == $this->default_events[$the_day]['schedule_location']){
					$exist = true;
					break;
				}
			}
			if(!$exist){
				array_push($result1, $this->default_events[$the_day]);
			}
		}
		return $result1;
		
	}
	
	public function get_events(){
		$ret = array();
		$color_list = array(
			'Fremont' => array('lime', '#000'),
			'San Jose' => array('yellow', '#000'),
			'Pleasanton' => array('pink', '#000'),
			'Online' => array('blue', '#fff'),
		);
		$result = $this->schedule_model->get_list();
		
		$result1 = array();
		foreach($this->default_events as $the_day => $event){
			$result1 = array_merge($result1, $this->_default_events($the_day, $result));
		}
		$result = array_merge($result, $result1);
		foreach($result as $r){
			$t = explode("\n", $r['schedule_topic']);
			$p = explode("\n", $r['schedule_presenters']);
			$tt = array($r['schedule_location']);
			
			for($i = 0; $i < max(count($t), count($p)); ++$i){
				$l = array();
				if($i < count($t)){
					array_push($l, $t[$i]);
				}
				if($i < count($p)){
					array_push($l, $p[$i]);
				}
				//echo implode(' ', $l).'    ';
				array_push($tt, implode(' ', $l));
			}
			$e = array(
				'id' => $r['schedule_id'], 
				'title' => implode("<br/>", $tt),
				'start' => $r['schedule_start_date'].' '.$r['schedule_start_time'],
				'end' => $r['schedule_end_date'].' '.$r['schedule_end_time'],
			);
			if(array_key_exists($r['schedule_location'], $color_list)){
				$e['backgroundColor'] =  $color_list[$r['schedule_location']][0];
				$e['borderColor'] =  $color_list[$r['schedule_location']][0];
				$e['textColor'] =  $color_list[$r['schedule_location']][1];
			}
			array_push($ret, $e);
		}
		
		echo json_encode($ret);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */