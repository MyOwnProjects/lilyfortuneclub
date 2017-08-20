<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('base.php');
class Seminar extends Base_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('schedule_model');
	}
	
	public function index()
	{
		$year = $this->input->get('year');
		$location = $this->input->get('location');
		$result = $this->schedule_model->get_all_locations();
		$locations = array();
		foreach($result as $r){
			array_push($locations, $r['office_name']);
		}
		$years = $this->schedule_model->get_all_years();
		$page = $this->input->get('pg');
		if($page <= 0)
			$page = 0;
		else
			$page -= 1;
		$where = "1=1";
		if($location == 'Other'){
			$where .= " AND office_name is NULL";
		}
		else if(!empty($location) && $location != 'All'){
			$where .= " AND office_name='$location'";
		} 
		
		if(!$this->user || $this->user['grade'] == 'G'){
			$where .= " AND access='P'";
		}
		$where .= empty($year) || $year == 'All' ? "" : " AND schedule_year='$year'";
		$total = $this->schedule_model->get_list_total($where);
		$result = $this->schedule_model->get_list($where, array('schedule_year DESC', 'schedule_month DESC'), ($page * 20).",20");
		$this->load_view('seminar', array('list' => $result, 'locations' => $locations, 'years' => $years, 'year' => in_array($year, $years) ? $year : 'All', 
			'location' => $location == 'Other' || in_array($location, $locations) ? $location : 'All', 'current' =>$page +1, 'total' => ceil($total / 20)));
	}
	
}