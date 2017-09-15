<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('smd_controller.php');
class Live extends Smd_Controller {

	public function __construct(){
		parent::__construct();
		if(empty($this->user) || $this->user['grade'] !== 'SMD'){
			header('location: '.base_url().'smd/ac/sign_in');
		}		
		$this->load->model('live_model');
		$this->nav_menus['live']['active'] = true;
	}
	
	public function index()
	{
		$this->nav_menus['live']['sub_menus']['']['active'] = true;
		$this->load_view('live/list');
	}
	
	public function get_live_event_list(){
		$search_str = trim($this->input->post('search'));
		$search = isset($search_str) && $search_str !== '' ? preg_split('/[^a-z0-9]/i', $search_str) : array();
		$current = $this->input->post('current');
		$row_count= $this->input->post('row_count');
		$sort = $this->input->post('sort');
		$filter = $this->input->post('filter');
		$where = '1=1 ';
		if(!empty($search)){
			$search_where = array();
			foreach($search as $s){
				array_push($search_where, "title LIKE '%$s%' OR desc LIKE '%$s%' OR youtube_code LIKE '%$s%' OR uniqid LIKE '%$s%'");
			}
			$where .= " AND (".implode(" OR ", $search_where).") ";
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
		$total = $this->live_model->get_list_total($where);
		if($total > 0){
			$ret = paginate($total, $current, $row_count);
			$ret['search'] = $search_str;
			$order_by = array();
			if(!empty($sort)){
				foreach($sort as $k => $v){
					array_push($order_by, "$k $v");
				}
			}
			$ret['rows'] = $this->live_model->get_list($where, $order_by, (($ret['current'] - 1) * $ret['row_count']).", ".$ret['row_count']);
			foreach($ret['rows'] as $i => $r){
				$ret['rows'][$i]['id'] = $r['uniqid'];
				$ret['rows'][$i]['title'] = $r['title'];
				$ret['rows'][$i]['desc'] = $r['desc'];
				$ret['rows'][$i]['youtube_code'] = $r['youtube_code'];
				$ret['rows'][$i]['start_time'] = date_format(date_create($r['start_time']), 'Y-m-d H:i');
				$ret['rows'][$i]['timezone'] = $r['timezone'];
				$ret['rows'][$i]['dst'] = $r['dst'] == 'Y' ? 'Yes' : 'No';
				$ret['rows'][$i]['end_time'] = empty($r['end_time']) ? '' : date_format(date_create($r['end_time']), 'Y-m-d H:i');
				$ret['rows'][$i]['uniqid'] = $r['uniqid'];
				$ret['rows'][$i]['action'] =  array(
					'update' => base_url().'smd/live/edit/'.$r['uniqid']
				);
			}
		}
		echo json_encode($ret);
	}
	
	public function item($uniqid){
		$result = $this->document_model->get_list("uniqid='$file'");
		if(count($result) != 1){
			$this->load_view('documents/view', array('error' => 'The document does not exist.'));
			return;
		}
		$full_path = getcwd().'/application/documents/'.$result[0]['uniqid'].'.'.$result[0]['file_name'];
		if(!file_exists($full_path)){
			$this->load_view('documents/view', array('error' => 'The document does not exist.'));
			return;
		}
		$ext = pathinfo($result[0]['uniqid'].'.'.$result[0]['file_name'], PATHINFO_EXTENSION);
		$file = uniqid().'.'.$ext;
		$to = getcwd().'/src/temp/'.$file;
		if(!@copy($full_path, $to)){
			$this->load_view('documents/view', array('error' => 'The document does not exist.'));
			return;
		}
		$mime_type = mime_type($full_path);
		$this->load_view('documents/view', array('mime_type' => $mime_type[0], 'file' => $file, 'name' => $result[0]['file_name'],
			/*infolab.stanford.edu/pub/papers/google.pdf'*/ 'src'=> 'https://docs.google.com/gview?url=%s&embedded=true'));
	}
	
	public function create(){
		if($this->input->server('REQUEST_METHOD') == 'POST'){
			$title = $this->input->post('title');
			$desc = $this->input->post('desc');
			$youtube_code = $this->input->post('youtube_code');
			$time_zone = $this->input->post('time_zone');
			$start_time = $this->input->post('start_time');
			$end_time = $this->input->post('end_time');
			$uniqid = uniqid();
			$start_time_utc = date_format(date_timezone_set(date_create($start_time, timezone_open($time_zone)), timezone_open('UTC')), 'Y-m-d H:i::00');
			if(!empty($end_time)){
				$end_time_utc = date_format(date_timezone_set(date_create($end_time, timezone_open($time_zone)), timezone_open('UTC')), 'Y-m-d H:i::00');
			}
			if($this->live_model->insert($title, $desc, $youtube_code, $time_zone, $start_time_utc, $end_time_utc, $uniqid)){
				echo json_encode(array('success'=> true));
				return;
			}
			else{
				echo json_encode(array('success'=> false, 'message'=> 'Failed to create live event'));
				return;
			}
		}
		$timezone = $this->input->get('timezone');
		$dst = $this->input->get('dst');
		$options = array();
		$timezone_identifiers = DateTimeZone::listIdentifiers();
		foreach ($timezone_identifiers as $t) {
			array_push($options, array('value' => $t, 'text' => $t));
		}
		
		$items = array(
			array(
				'label' => 'Title',
				'name' => 'title',
				'tag' => 'input',
				'required' => true,
			),
			array(
				'label' => 'Description',
				'name' => 'desc',
				'tag' => 'textarea',
			),
			array(
				'label' => 'Youtube Code',
				'name' => 'youtube_code',
				'tag' => 'input',
				'required' => true,
			),
			array(
				'label' => 'Timezone',
				'name' => 'local_timezone',
				'type' => 'timezone',
				'tag' => 'select',
				'options' => $options,
				'value' => $timezone,
				'required' => true,
			),
			array(
				'label' => 'Daylight Saving Time',
				'name' => 'dst',
				'type' => 'dst',
				'tag' => 'select',
				'options' => array(
					array('value' => 'Y', 'text' => 'Yes'),
					array('value' => 'N', 'text' => 'No'),
				),
				'value' => $dst,
				'required' => true,
			),
			array(
				'label' => 'Start Time',
				'name' => 'start_time',
				'tag' => 'input',
				'type' => 'datetime-local',
				'required' => true,
			),
			array(
				'label' => 'End Time',
				'name' => 'end_time',
				'tag' => 'input',
				'type' => 'datetime-local'
			),
		);
		$this->load->view('smd/add_item', array('items' => $items));
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */