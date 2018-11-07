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
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	public function get_schedule_list(){
		$search_str = trim($this->input->post('search'));
		$search = isset($search_str) && $search_str !== '' ? preg_split('/[^a-z0-9]/i', $search_str) : array();
		$current = $this->input->post('current');
		$row_count= $this->input->post('row_count');
		$sort = $this->input->post('sort');
		$filter = $this->input->post('filter');
		$where = '1=1 ';
		if(!empty($search)){
			$serch_where = array();
			foreach($search as $s){
				array_push($serch_where, "display_name LIKE '%$s%'");
			}
			$where .= " AND (".implode(" OR ", $serch_where).") ";
		}
		$where .= (empty($filter) || is_null($filter[key($filter)]) || $filter[key($filter)] == '' ? "" : " AND ".key($filter)."='".$filter[key($filter)]."'");
		$ret = array(
			'current' => 1,
			'last' => 0,
			'row_count' => $row_count,
			'search' => $search_str,
			'rows' => array(),
			'total' => 0
		);
		$total = $this->schedule_model->get_list_total($where);
		if($total > 0){
			$ret = paginate($total, $current, $row_count);
			$ret['search'] = $search_str;
			$order_by = array();
			if(!empty($sort)){
				foreach($sort as $k => $v){
					if($k == 'date'){
						array_push($order_by, "schedule_year DESC, schedule_month DESC");
					}
					else{
						array_push($order_by, "$k $v");
					}
				}
			}
			$result = $this->schedule_model->get_list($where, $order_by, (($ret['current'] - 1) * $ret['row_count']).", ".$ret['row_count']);
			foreach($result as $r){
				array_push($ret['rows'], array(
					'id' => $r['schedules_id'],
					'file' => '<a href="'.base_url().'src/schedule/'.$r['schedule_year'].'/'.$r['file'].'" target="_blank">'.$r['file'].'</a>',
					'access' => $r['access'] == 'M' ? 'Member Only' : 'Public',
					'office_name' => $r['office_name'],
					'date' => (isset($r['schedule_month']) ? str_pad( $r['schedule_month'], 2, '0', STR_PAD_LEFT).'/' : '').$r['schedule_year']
				));
			}
		}
		echo json_encode($ret);
	}

	public function add(){
		if($this->input->server('REQUEST_METHOD') == 'GET'){
			$locations = $this->schedule_model->get_all_locations();
			$location_options = array(array('value' => null, 'text' => 'Other'));
			foreach($locations as $l){
				array_push($location_options, array('value' => $l['offices_id'], 'text' => $l['office_name']));
			}
			$year_options = array();
			$y = date_format(date_create(), 'Y');
			for($i = $y - 2; $i <= $y + 2; ++$i){
				array_push($year_options, array('value'=> $i, 'text' => $i));
			}
			$month_options= array(array('value'=> null, 'text' => 'Unknown'));
			for($i = 1; $i <= 12; ++$i){
				array_push($month_options, array('value'=> $i, 'text' => $i));
			}
			$items = array(
				array(
					'label' => 'Access',
					'name' => 'access',
					'tag' => 'select',
					'options' => array(
						array('value' => 'M', 'text' => 'Member Only'),
						array('value' => 'P', 'text' => 'Public'),
					),
					'value' => array('M')
				),
				array(
					'label' => 'Start Date',
					'name' => 'schedule_date_start',
					'tag' => 'input',
					'type' => 'date',
					'required' => true
				),
				array(
					'label' => 'End Date',
					'name' => 'schedule_date_end',
					'tag' => 'input',
					'type' => 'date'
				),
				array(
					'label' => 'Office/Location',
					'name' => 'location',
					'tag' => 'select',
					'options' => $location_options,
					'value' => ''
				),
				array(
					'label' => 'Selecte File(s)',
					'name' => 'upload_files',
					'tag' => 'input',
					'type' => 'file',
					'multiple' => true
				),
			);
			$this->load->view('smd/add_item', array('items' => $items));
		}
		else{
			$access = $this->input->post('access');
			$schedule_date_start = $this->input->post('schedule_date_start');
			$schedule_date_end = $this->input->post('schedule_date_end');
			$location = $this->input->post('location');
			$upload_files =$this->input->post('upload_files');
			$upload_files = empty($upload_files) ? array() : explode(',', $upload_files);
			$schedule_year = date_format(date_create($schedule_date_start), 'Y');

			$files = array();
			foreach($upload_files as $file){
				//$pos = strpos($file, '.');
				//$name =  substr($file, $pos + 1);
				$dir = getcwd().'/src/schedule/'.$schedule_year;
				if(!file_exists($dir)){
					mkdir($dir);
				}
				if(rename(getcwd().'/application/documents/temp/'.$file, $dir.'/'.$file)){
					array_push($files, array(
						'file' => $file,
						'access' => $access,
						'schedule_date_start' => $schedule_date_start,
						'schedule_date_end' => $schedule_date_end,
						'location' => $location
					));
				}
			}
			$success = $this->schedule_model->insert($files);
			echo json_encode(array('success' => $success));
		}
	}
	
	public function update($field){
		if($this->input->server('REQUEST_METHOD') == 'GET'){
			switch($field){
				case 'location':
					$locations = $this->schedule_model->get_all_locations();
					$location_options = array(array('value' => null, 'text' => 'Other'));
					foreach($locations as $l){
						array_push($location_options, array('value' => $l['offices_id'], 'text' => $l['office_name']));
					}
					$items = array(
						array(
							'label' => 'Office/Location',
							'name' => 'location',
							'tag' => 'select',
							'options' => $location_options,
							'value' => ''
						),
					);
					break;
				case 'access':
					$items = array(
						array(
							'label' => 'Access',
							'name' => 'access',
							'tag' => 'select',
							'options' => array(
								array('value' => 'M', 'text' => 'Member Only'),
								array('value' => 'P', 'text' => 'Public'),
							),
							'value' => array('M')
						),
					);
					break;
				case 'time':
					$year_options = array();
					$y = date_format(date_create(), 'Y');
					for($i = $y - 2; $i <= $y + 2; ++$i){
						array_push($year_options, array('value'=> $i, 'text' => $i));
					}
					$month_options= array(array('value'=> null, 'text' => 'Unknown'));
					for($i = 1; $i <= 12; ++$i){
						array_push($month_options, array('value'=> $i, 'text' => $i));
					}
					$items = array(
						array(
							'label' => 'Date',
							'name' => array('year' => 'schedule_year', 'month' => 'schedule_month'),
							'tag' => 'combo',
							'type' => 'year_month',
							'options' => array(
								'year' => $year_options,
								'month' => $month_options,
							),
							'value' => array('year' => $y, 'month' => 1)
						),
					);
					break;
				default:
			}
			$this->load->view('smd/add_item', array('items' => $items));
		}
		else{
			switch($field){
				case 'location':
					$location = $this->input->post('location');
					$prop = array('location' => $location== '' ? NULL : $location);
					break;
				case 'access':
					$access = $this->input->post('access');
					$prop = array('access' => $access);
					break;
				case 'time':
					$schedule_year = $this->input->post('schedule_year');
					$schedule_month = $this->input->post('schedule_month');
					$prop = array('schedule_year' => $schedule_year, 'schedule_month' => $schedule_month == '' ? NULL : $schedule_month);
					break;
				default:
			}
			$selected_ids = $this->input->post('selected_ids');
			$this->schedule_model->update($prop, "schedules_id IN ('".implode("','", $selected_ids)."')");
			echo json_encode(array('success' => true));
		}
	}

	public function upload_files(){
		$this->load->library('upload');
		$uniq_id = uniqid();
		$dir = getcwd().'/application/documents/temp/';
		$this->upload->set_upload_path($dir);
		$this->upload->set_allowed_types('*');
		if($this->upload->do_upload('ajax-upload-file')){
			$data = $this->upload->data();
			$data['final_file_name'] = $uniq_id.'.'.$data['file_name'];
			rename($dir.$data['file_name'], $dir.$data['final_file_name']);
			echo json_encode(array('success' => true, 'data' => $data));
		}
		else{
			echo json_encode(array('success' => false, 'error' => $this->upload->display_errors()));
		}
	}
	
	public function delete(){
		if($this->input->server('REQUEST_METHOD') == 'POST'){
			$ids = $this->input->post('selected_ids');
			
			$this->schedule_model->delete("schedules_id IN ('".implode("','", $ids)."')");
			echo json_encode(array('success' => true));
		}
		else{
			$items = array(
					array(
						'tag' => 'text', 'text' => 'Do you want to delete the schedule(s)?' 
					)
				);
			$this->load->view('smd/add_item', array('items' => $items));
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */