<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('smd_controller.php');
class Events extends Smd_Controller {

	public function __construct(){
		parent::__construct();
		if(empty($this->user) || $this->user['grade'] !== 'SMD'){
			header('location: '.base_url().'smd/ac/sign_in');
		}		
		$this->load->model('event_model');
		$this->nav_menus['events']['active'] = true;
	}
	
	public function index()
	{
		$this->nav_menus['events']['sub_menus']['']['active'] = true;
		$this->load_view('events/list');
	}
	
	public function get_event_list(){
		$search_str = trim($this->input->post('search'));
		$search = isset($search_str) && $search_str !== '' ? preg_split('/[\s,]+/', $search_str) : array();
		$current = $this->input->post('current');
		$row_count= $this->input->post('row_count');
		$sort = $this->input->post('sort');
		$filter = $this->input->post('filter');
		$where = '1=1 ';
		if(!empty($search)){
			$serch_where = array();
			foreach($search as $s){
				array_push($serch_where, "events_subject LIKE '%$s%' OR events_location LIKE '%$s%'");
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
		$total = $this->event_model->get_list_total($where);
		if($total > 0){
			if($current <= 0){
				$current = 1;
			}
			$ret = paginate($total, $current, $row_count);
			$ret['search'] = $search_str;
			$order_by = array();
			if(!empty($sort)){
				foreach($sort as $k => $v){
					array_push($order_by, "$k $v");
				}
			}
			$ret['rows'] = $this->event_model->get_list($where, $order_by, (($ret['current'] - 1) * $ret['row_count']).", ".$ret['row_count']);
			foreach($ret['rows'] as $i => $r){
				$ret['rows'][$i]['id'] = $r['events_id'];
				$ret['rows'][$i]['events_subject'] = '<a href="'.base_url().'events/item/'.$r['events_id'].'" target="_blank">'.$r['events_subject'].'</a>';
				$ret['rows'][$i]['events_start_time'] = date_format(date_create($r['events_start_time']), 'Y-m-d H:i');
				$ret['rows'][$i]['events_end_time'] = date_format(date_create($r['events_end_time']), 'Y-m-d H:i');
				$ret['rows'][$i]['events_city'] = $r['events_city'];
				$ret['rows'][$i]['event_guests'] = intval($r['event_guests']);
				$ret['rows'][$i]['action'] =  array(
					'update' => base_url().'smd/events/edit/'.$r['events_id']
				);
			}
		}
		echo json_encode($ret);
	}
	
	public function create(){
		$error = '';
		if($this->input->server('REQUEST_METHOD') == 'POST'){
			$subject = trim($this->input->post('events_subject'));
			$street = trim($this->input->post('events_street'));
			$city = trim($this->input->post('events_city'));
			$state = trim($this->input->post('events_state'));
			$zipcode = trim($this->input->post('events_zipcode'));
			$start_time = trim($this->input->post('events_start_time'));
			$end_time = trim($this->input->post('events_end_time'));
			$detail = update_content(trim($this->input->post('events_detail')), 'src/img/events');
			if($this->event_model->insert_event($subject, $street, $city, $state, $zipcode, $start_time, $end_time, $detail)){
				header('location: '.base_url().'smd/events');
				exit;
			}
			$error = 'Failed to create event';
		}
		$this->load_view('events/create', array_merge($this->input->post() ? $this->input->post() : array(), array('error' => $error)));
	}
	
	public function edit($id){
		if($this->input->server('REQUEST_METHOD') == 'POST'){
			$prop = $this->input->post();
			foreach($prop as $n => $v){
				if($n == 'events_detail'){
					$prop[$n] = update_content(trim($v), 'src/img/events');
				}
				else{
					$prop[$n] = $v;
				}
			}
			if($this->event_model->update_event("events_id='$id'", $prop)){
				header('location: '.base_url().'smd/events');
				exit;
			}
			$ret = $this->input->post();
			$ret['error'] = 'Failed to edit event';
		}
		else{
			$result = $this->event_model->get_events("events_id='$id'");
			$ret = array();
			if(count($result) > 0){
				$ret['events_id'] = $result[0]['events_id'];
				$ret['events_subject'] = $result[0]['events_subject'];
				$ret['events_detail'] = $result[0]['events_detail'];
				$ret['events_start_time'] = date_format(date_create($result[0]['events_start_time']), 'Y-m-d H:i');
				$ret['events_end_time'] = date_format(date_create($result[0]['events_end_time']), 'Y-m-d H:i');
				$ret['events_street'] = $result[0]['events_street'];
				$ret['events_city'] = $result[0]['events_city'];
				$ret['events_state'] = $result[0]['events_state'];
				$ret['events_zipcode'] = $result[0]['events_zipcode'];
				$ret['event_guests'] = array();
				foreach($result as $r){
					if(isset($r['event_guests_id'])){
						array_push($ret['event_guests'], $r);
					}
				}
			}
			else{
				$ret['error'] = 'Invalid event id';
			}
		}
		$this->load_view('events/create', $ret);
	}

	public function delete(){
		if($this->input->server('REQUEST_METHOD') == 'POST'){
			$ids = $this->input->post('selected_ids');
			$this->event_model->delete_events("events_id IN ('".implode("','", $ids)."')");
			echo json_encode(array('success' => true));
		}
		else{
			$items = array(
				array(
					'tag' => 'text', 'text' => 'Do you want to delete the event(s)?' 
				)
			);
			$this->load->view('smd/add_item', array('items' => $items));
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */