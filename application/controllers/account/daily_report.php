<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('account_base.php');
class Daily_report extends Account_base_controller {
	private $list_content;
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
	}
	
	public function index(){
		$this->load_view('daily_report');
	}
	
	public function get(){
		$this->load->model('user_model');
		$today = date_create();
		date_sub($today, date_interval_create_from_date_string("1 days"));
		$ret = $this->user_model->get_daily_report(date_format($today, 'Y-m-d'));
		
		$today = date_create();
		$mret = $this->user_model->get_monthly_report($today);
		$msort = $this->_sort($mret);
		date_sub($today, date_interval_create_from_date_string("1 days"));
		$dret = $this->user_model->get_daily_report(date_format($today, 'Y-m-d'));
		$dsort = $this->_sort($dret);
		$result = array();
		$len = count($dsort);
		$color = 'red';
		for($i = 0; $i < $len; ++$i){
			$v = array( 
				$ret[$i]['daily_report_id'],
				$ret[$i]['daily_report_name'],
				$ret[$i]['daily_report_appointment'],
				$ret[$i]['daily_report_personal_recruits'],
				$ret[$i]['daily_report_personal_products'],
				$ret[$i]['daily_report_baseshop_recruits'],
				$ret[$i]['daily_report_baseshop_products'],
				$ret[$i]['daily_report_base_elite'],
				
				'<span style="color:red">'.($i + 1).'</span>',
				$dsort[$i]['name'],
				(int)$dsort[$i]['data']['daily_report_personal_recruits'][0].' (<span style="color:'.$color.'">'.$dsort[$i]['data']['daily_report_personal_recruits'][1].'</span>)',
				(int)$dsort[$i]['data']['daily_report_personal_products'][0].' (<span style="color:'.$color.'">'.$dsort[$i]['data']['daily_report_personal_products'][1].'</span>)',
				(int)$dsort[$i]['data']['daily_report_baseshop_recruits'][0].' (<span style="color:'.$color.'">'.$dsort[$i]['data']['daily_report_baseshop_recruits'][1].'</span>)',
				(int)$dsort[$i]['data']['daily_report_baseshop_products'][0].' (<span style="color:'.$color.'">'.$dsort[$i]['data']['daily_report_baseshop_products'][1].'</span>)',
				(int)$dsort[$i]['data']['daily_report_personal_recruits'][1] 
					+ $dsort[$i]['data']['daily_report_personal_products'][1] 
					+ $dsort[$i]['data']['daily_report_baseshop_recruits'][1]
					+ $dsort[$i]['data']['daily_report_baseshop_products'][1],
				$msort[$i]['name'],
				(int)$msort[$i]['data']['daily_report_personal_recruits'][0].' (<span style="color:'.$color.'">'.$msort[$i]['data']['daily_report_personal_recruits'][1].'</span>)',
				(int)$msort[$i]['data']['daily_report_personal_products'][0].' (<span style="color:'.$color.'">'.$msort[$i]['data']['daily_report_personal_products'][1].'</span>)',
				(int)$msort[$i]['data']['daily_report_baseshop_recruits'][0].' (<span style="color:'.$color.'">'.$msort[$i]['data']['daily_report_baseshop_recruits'][1].'</span>)',
				(int)$msort[$i]['data']['daily_report_baseshop_products'][0].' (<span style="color:'.$color.'">'.$msort[$i]['data']['daily_report_baseshop_products'][1].'</span>)',
				(int)$msort[$i]['data']['daily_report_personal_recruits'][1] 
					+ $msort[$i]['data']['daily_report_personal_products'][1] 
					+ $msort[$i]['data']['daily_report_baseshop_recruits'][1]
					+ $msort[$i]['data']['daily_report_baseshop_products'][1],
			);
			array_push($result, $v);
		} 
		
		echo json_encode($result);
	}
	
	public function update(){
		$this->load->model('user_model');
		$data_id = $this->input->post('data_id');
		$data = $this->input->post('data');
		$all_blank = true;
		foreach($data as $i => $d){
			$dt = trim($d);
			if($dt !== ''){
				$all_blank = false;
				$data[$i] = "'$dt'";
			}
			else{
				$data[$i] = 'NULL';
			}
		}
		if($all_blank){
			$this->user_model->delete_daily_report($data_id);
			echo -1;
		}
		else if($data_id < 0){
			$today = date_create();
			date_sub($today, date_interval_create_from_date_string("1 days"));
			echo $this->user_model->insert_daily_report(date_format($today, 'Y-m-d'), $data);
		}
		else{
			$this->user_model->update_daily_report($data_id, $data);
			echo $data_id;
		}
	}
	
	public function delete(){
		$data_id = $this->input->post('data_id');
		$this->user_model->delete_daily_report($data_id);
	}
	
	private function _sort($ret){
		$key_list = array(
			'daily_report_personal_recruits',
			'daily_report_personal_products',
			'daily_report_baseshop_recruits',
			'daily_report_baseshop_products',
			'daily_report_base_elite'
		);
		$array = array();
		foreach($key_list as $key){
			usort($ret,function($a, $b) use ($key){
				return $b[$key] - $a[$key];
			});
			$array[$key] = array();
			foreach($ret as $i => $r){
				array_push($array[$key], array($r['daily_report_id'], $r['daily_report_name'], $r[$key], $i + 1));
			}
		}
		$new_array = array();
		foreach($array as $key => $d){
			foreach($d as $a){
				$data_id = $a[0];
				if(!array_key_exists($data_id, $new_array)){
					$new_array[$data_id] = array(
						'name' => $a[1], //name
						'rank' => 0,
						'data' => array()
					);
				}
				$new_array[$data_id]['rank'] += $a[3];
				$new_array[$data_id]['data'][$key] = array($a[2], $a[3]);
			}
		}
		usort($new_array, function($a, $b){
			return $a['rank'] - $b['rank'];
		});
		return $new_array;
	}
	
	public function summary(){
		$this->load->model('user_model');
		$today = date_create();
		$mret = $this->user_model->get_monthly_report($today);
		$msort = $this->_sort($mret);
		date_sub($today, date_interval_create_from_date_string("1 days"));
		$dret = $this->user_model->get_daily_report(date_format($today, 'Y-m-d'));
		$dsort = $this->_sort($dret);
		$result = array();
		$len = count($dsort);
		$color = 'red';
		for($i = 0; $i < $len; ++$i){
			$v = array(0, $dsort[$i]['name'],
				(int)$dsort[$i]['data']['daily_report_personal_recruits'][0].' (<span style="color:'.$color.'">'.$dsort[$i]['data']['daily_report_personal_recruits'][1].'</span>)',
				(int)$dsort[$i]['data']['daily_report_personal_products'][0].' (<span style="color:'.$color.'">'.$dsort[$i]['data']['daily_report_personal_products'][1].'</span>)',
				(int)$dsort[$i]['data']['daily_report_baseshop_recruits'][0].' (<span style="color:'.$color.'">'.$dsort[$i]['data']['daily_report_baseshop_recruits'][1].'</span>)',
				(int)$dsort[$i]['data']['daily_report_baseshop_products'][0].' (<span style="color:'.$color.'">'.$dsort[$i]['data']['daily_report_baseshop_products'][1].'</span>)',
				(int)$dsort[$i]['data']['daily_report_personal_recruits'][1] 
					+ $dsort[$i]['data']['daily_report_personal_products'][1] 
					+ $dsort[$i]['data']['daily_report_baseshop_recruits'][1]
					+ $dsort[$i]['data']['daily_report_baseshop_products'][1],
				$msort[$i]['name'],
				(int)$msort[$i]['data']['daily_report_personal_recruits'][0].' (<span style="color:'.$color.'">'.$msort[$i]['data']['daily_report_personal_recruits'][1].'</span>)',
				(int)$msort[$i]['data']['daily_report_personal_products'][0].' (<span style="color:'.$color.'">'.$msort[$i]['data']['daily_report_personal_products'][1].'</span>)',
				(int)$msort[$i]['data']['daily_report_baseshop_recruits'][0].' (<span style="color:'.$color.'">'.$msort[$i]['data']['daily_report_baseshop_recruits'][1].'</span>)',
				(int)$msort[$i]['data']['daily_report_baseshop_products'][0].' (<span style="color:'.$color.'">'.$msort[$i]['data']['daily_report_baseshop_products'][1].'</span>)',
				(int)$msort[$i]['data']['daily_report_personal_recruits'][1] 
					+ $msort[$i]['data']['daily_report_personal_products'][1] 
					+ $msort[$i]['data']['daily_report_baseshop_recruits'][1]
					+ $msort[$i]['data']['daily_report_baseshop_products'][1],
			);
			array_push($result, $v);
		} 
		echo json_encode($result);
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */