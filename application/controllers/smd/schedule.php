<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('smd_controller.php');
class Schedule extends Smd_Controller {
	private $color_list = array(
					'Fremont' => array('lime', '#000'),
					'San Jose' => array('yellow', '#000'),
					'Pleasanton' => array('pink', '#000'),
				);

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
	
	public function update_schedule($id=null){
		$l = $this->schedule_model->get_list("schedule_id='$id'");
		if(count($l) != 1){
			echo json_encode(array('success' => false, 'message' => 'The schedule does not exist.'));
			return;
		}
		if($this->input->server('REQUEST_METHOD') == 'POST'){
			$ret = $this->schedule_model->update_schedule($this->input->post(), "schedule_id='$id'");
			if($ret){
				$result = $this->schedule_model->get_list("schedule_id='$id'");
				$schedule_start_date = $result[0]['schedule_start_date'];
				$schedule_start_time = $result[0]['schedule_start_time'];
				$schedule_end_date = $result[0]['schedule_end_date'];
				$schedule_end_time = $result[0]['schedule_end_time'];
				$t = explode("\n", $this->input->post('schedule_topic'));
				$p = explode("\n", $this->input->post('schedule_presenters'));
				$tt = array();			
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
				$data = array(
					'id' => $id,
					'start' => $schedule_start_date.(empty($schedule_start_time) ? '' : ' '.$schedule_start_time),
					'title' => implode('<br/>', $tt),
					
				);
				$sl = $this->input->post('schedule_location');
				if(array_key_exists($sl, $this->color_list)){
					$data['backgroundColor'] =  $this->color_list[$sl][0];
					$data['borderColor'] =  $this->color_list[$sl][0];
					$data['textColor'] =  $this->color_list[$sl][1];
				}
				
				$r = array('success' => true, 'data' => $data);
				if(!empty($schedule_end_date)){
					$r['data']['end'] = $schedule_end_date
						.empty($schedule_end_time) ? '' : ' '.$schedule_end_time;
				}
				echo json_encode($r);
			}
			else{
				echo json_encode(array('success' => false, 'message' => 'Failed to update schedule.'));
			}
			return;
		}
			$items = array(
				array(
					'label' => 'Start',
					'name' => 'schedule_start',
					'tag' => 'combo',
					'type' => 'date_time',
					'value' => $l[0]['schedule_start_date'].' '.$l[0]['schedule_start_time'],
					'required' => true
				),
				array(
					'label' => 'End',
					'name' => 'schedule_end',
					'tag' => 'combo',
					'type' => 'date_time',
					'value' => $l[0]['schedule_end_date'].' '.$l[0]['schedule_end_time'],
				),
				array(
					'label' => 'Location',
					'name' => 'schedule_location',
					'placeholder' => 'city',
					'tag' => 'select',
					'value' => $l[0]['schedule_location'],
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
					'value' => $l[0]['schedule_address'],
					'tag' => 'input'
				),
				array(
					'label' => 'Topic',
					'name' => 'schedule_topic',
					'tag' => 'textarea',
					'value' => $l[0]['schedule_topic'],
					'required' => true
				),
				array(
					'label' => 'Presenter(s)',
					'name' => 'schedule_presenters',
					'placeholder' => 'Kun Yang, Min Zhu',
					'value' => $l[0]['schedule_presenters'],
					'tag' => 'textarea',
				),
				array(
					'label' => 'Comment',
					'name' => 'schedule_comment',
					'value' => $l[0]['schedule_comment'],
					'tag' => 'textarea'
				),
			);
			$this->load->view('smd/add_item', array('items' => $items, 'width' => '600'));
	}
	
	public function add_schedule(){
		if($this->input->server('REQUEST_METHOD') == 'POST'){
			$params = $this->input->post();
			$schedule_start_date = $this->input->post('schedule_start_date');
			$schedule_start_time = $this->input->post('schedule_start_time');
			$schedule_length = $this->input->post('schedule_length');
			$date_end = date_add(date_create($schedule_start_date.' '.$schedule_start_time), date_interval_create_from_date_string("$schedule_length hours"));
			$schedule_end_date = date_format($date_end, 'Y-m-d');
			$schedule_end_time = date_format($date_end, 'H:i:s');
			unset($params['schedule_length']);
			$params['schedule_end_date'] = $schedule_end_date;
			$params['schedule_end_time'] = $schedule_end_time;
			$ret = $this->schedule_model->insert($params);
			if($ret){
				
				$t = explode("\n", $this->input->post('schedule_topic'));
				$p = explode("\n", $this->input->post('schedule_presenters'));
				$tt = array();			
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
				$data = array(
					'id' => $ret,
					'start' => $schedule_start_date.(empty($schedule_start_time) ? '' : ' '.$schedule_start_time),
					'title' => implode('<br/>', $tt),
					
				);
				$sl = $this->input->post('schedule_location');
				if(array_key_exists($sl, $this->color_list)){
					$data['backgroundColor'] =  $this->color_list[$sl][0];
					$data['borderColor'] =  $this->color_list[$sl][0];
					$data['textColor'] =  $this->color_list[$sl][1];
				}
				
				$r = array('success' => true, 'data' => $data);
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
					'label' => 'Length (hours)',
					'name' => 'schedule_length',
					'tag' => 'input',
					'type' => 'number',
					'value' => 2,
					'step' => 1,
					'min' => 1
				),
				/*array(
					'label' => 'End',
					'name' => 'schedule_end',
					'tag' => 'combo',
					'type' => 'date_time',
				),*/
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
					'label' => 'Topic',
					'name' => 'schedule_topic',
					'tag' => 'textarea',
					'required' => true
				),
				array(
					'label' => 'Presenter(s)',
					'name' => 'schedule_presenters',
					'placeholder' => 'Kun Yang, Min Zhu',
					'tag' => 'textarea',
				),
				array(
					'label' => 'Comment',
					'name' => 'schedule_comment',
					'tag' => 'textarea'
				),
			);
			$this->load->view('smd/add_item', array('items' => $items, 'width' => '600'));
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
	
	public function delete_schedule($id = null){
		if($this->schedule_model->delete_schedule("schedule_id='$id'")){
			echo json_encode(array('success' => true)); 
		}
		else{
			echo json_encode(array('success' => false, 'message' => 'Failed to delete schedule.')); 
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */