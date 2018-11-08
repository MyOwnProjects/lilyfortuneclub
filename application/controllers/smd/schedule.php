<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('smd_controller.php');
class Schedule extends Smd_Controller {

	public function __construct(){
		parent::__construct();
		if(empty($this->user) || $this->user['grade'] !== 'SMD'){
			header('location: '.base_url().'smd/ac/sign_in');
		}		
		$this->load->model('schedule_model');
		$this->nav_menus['schedule']['active'] = true;
	}
	
	public function index()
	{
		$this->nav_menus['schedule']['sub_menus']['']['active'] = true;
		$this->load_view('schedule');
	}
	
	public function add_schedule(){
		if($this->input->server('REQUEST_METHOD') == 'POST'){
			$ret = $this->schedule_model->insert($this->input->post());
			if($ret){
				$schedule_start_date = $this->input->post('schedule_start_date');
				$schedule_start_time = $this->input->post('schedule_start_time');
				$schedule_end_date = $this->input->post('schedule_end_date');
				$schedule_end_time = $this->input->post('schedule_end_time');
				$r = array('success' => true, 'data' => array(
					'id' => $ret,
					'start' => $schedule_start_date.(empty($schedule_start_time) ? '' : ' '.$schedule_start_time),
					'title' => $this->input->post('schedule_topic')
				));
				if(!empty($schedule_end_date)){
					$r['data']['end'] = $schedule_end_date
						.empty($schedule_end_time) ? '' : ' '.$schedule_end_time;
				}
				echo json_encode($r);
			}
			else{
				echo json_encode(array('success' => false));
			}
			return;
		}
		$d = $this->input->get('date');
			$items = array(
				array(
					'label' => 'Start',
					'name' => 'schedule_start',
					'tag' => 'combo',
					'type' => 'date_time',
					'value' => $d,
					'required' => true
				),
				array(
					'label' => 'End',
					'name' => 'schedule_end',
					'tag' => 'combo',
					'type' => 'date_time',
				),
				array(
					'label' => 'Topic',
					'name' => 'schedule_topic',
					'tag' => 'input',
					'required' => true
				),
				array(
					'label' => 'Presenter(s)',
					'name' => 'schedule_presenters',
					'placeholder' => 'Kun Yang, Min Zhu',
					'tag' => 'input',
				),
				array(
					'label' => 'Location',
					'name' => 'schedule_location',
					'placeholder' => 'city',
					'tag' => 'select',
					'options' => array(
						array('value' => 'Fremont', 'text' => 'Fremont'),
						array('value' => 'San Jose', 'text' => 'San Jose'),
						array('value' => 'Pleasanton', 'text' => 'Pleasanton'),
						array('value' => '0', 'text' => 'Other'),
					)
				),
				array(
					'label' => 'Address',
					'name' => 'schedule_address',
					'placeholder' => 'Full address',
					'tag' => 'input'
				),
				array(
					'label' => 'Comment',
					'name' => 'schedule_comment',
					'tag' => 'textarea'
				),
			);
			$this->load->view('smd/add_item', array('items' => $items));
	}
	
	public function import(){
		if($this->input->server('REQUEST_METHOD') == 'POST'){
			$values = array();
			$post = array();
			foreach($this->input->post() as $n => $v){
				$post[$n] = $v;
			}
			$count = count($post['schedule_start_date']);
			for($i = 0; $i < $count; ++$i){
				if(empty($post['schedule_start_date'][$i])){
					continue;
				}
				$schedule_topic = trim($post['schedule_topic'][$i]);
				if(empty($schedule_topic)){
					continue;
				}
				else{
					$schedule_topic = "'".addslashes($schedule_topic)."'";
				}
				$schedule_start_date = "'".$post['schedule_start_date'][$i]."'";
				$schedule_start_time = empty($post['schedule_start_time'][$i]) ? "NULL" : "'".$post['schedule_start_time'][$i]."'";
				$schedule_end_date = empty($post['schedule_end_date'][$i]) ? "NULL" : "'".$post['schedule_end_date'][$i]."'";
				$schedule_end_time = empty($post['schedule_end_time'][$i]) ? "NULL" : "'".$post['schedule_end_time'][$i]."'";
				$schedule_location = empty($post['schedule_location'][$i]) ? "NULL" : "'".$post['schedule_location'][$i]."'";
				$schedule_address = "'".trim($post['schedule_address'][$i])."'";
				$schedule_presenters = "'".addslashes(trim($post['schedule_presenters'][$i]))."'";
				$schedule_comment = "'".addslashes(trim($post['schedule_comment'][$i]))."'";
				$v = array($schedule_start_date, $schedule_start_time, $schedule_end_date, 
					$schedule_end_time, $schedule_topic, $schedule_presenters, $schedule_location, 
					$schedule_address, $schedule_comment);
				array_push($values, "(".implode(",", $v).")");
			}
			$this->schedule_model->bulk_insert(array('schedule_start_date', 'schedule_start_time', 'schedule_end_date', 
					'schedule_end_time', 'schedule_topic', 'schedule_presenters', 'schedule_location', 
					'schedule_address', 'schedule_comment'), $values);
			header("location: ".base_url()."smd/schedule/");
			
			return;
		}
		
		$this->load_view('schedule/import');
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */