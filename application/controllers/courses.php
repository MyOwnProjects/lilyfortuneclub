<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('base.php');
class Courses extends Base_controller {
	private $list_content;
	public function __construct(){
		parent::__construct();
		$this->load->model('courses_model');
	}
	
	public function index(){
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
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */