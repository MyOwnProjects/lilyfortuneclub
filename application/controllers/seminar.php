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
		$month = $this->input->get('month');
		//$location = $this->input->get('location');
		//$result = $this->schedule_model->get_all_locations();
		//$locations = array();
		//foreach($result as $r){
		//	array_push($locations, $r['office_name']);
		//}
		//$years = $this->schedule_model->get_all_years();
		//$page = $this->input->get('pg');
		//if($page <= 0)
		//	$page = 0;
		//else
		//	$page -= 1;
		//$where = "1=1";
		/*if($location == 'Other'){
			$where .= " AND office_name is NULL";
		}
		else if(!empty($location) && $location != 'All'){
			$where .= " AND office_name='$location'";
		} 
		
		if(!$this->user || $this->user['grade'] == 'G'){
			$where .= " AND access='P'";
		}*/
		//$where .= empty($year) || $year == 'All' ? "" : " AND schedule_year='$year'";
		//$total = $this->schedule_model->get_list_total($where);
		if(empty($year) || empty($month)){
			$now = date_create();
			$year = date_format($now, 'Y');
			$month = date_format($now, 'm');
		}
		$result = $this->schedule_model->get_list("YEAR(schedule_date_start)=$year AND MONTH(schedule_date_start)=$month OR YEAR(schedule_date_end)=$year AND MONTH(schedule_date_end)=$month", array('schedule_date_start DESC'));
		$this->load_view('seminar', array('list' => $result, 'year' => $year, 'month' => $month));
	}
	
}