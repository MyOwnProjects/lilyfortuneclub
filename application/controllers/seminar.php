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
		$d  = date_create("$year-$month-01");
		$first_date = date_format($d, 'Y-m-d 00:00:00');
		$last_date = date_format(date_create("$year-$month-".date_format($d, 't')), 'Y-m-d 23:59:59');
		
		if(empty($this->user) || $this->user['grade'] == 'G'){
			$grade_access = " AND access='P'";
		}
		else{
			$grade_access = "";
		}
		$result = $this->schedule_model->get_list(
			"schedule_date_start < '$first_date' AND schedule_date_end >'$last_date'
			 OR schedule_date_start BETWEEN '$first_date' AND '$last_date'
			 OR schedule_date_end BETWEEN '$first_date' AND '$last_date' $grade_access", 
			array('schedule_date_start DESC')
		);
		$this->load_view('seminar', array('list' => $result, 'year' => $year, 'month' => $month));
	}
	
}