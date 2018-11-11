<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('base.php');
class Daily_report extends Base_controller {
	private $list_content;
	public function __construct(){
		parent::__construct();
		if($redirect = $this->not_signed_in()){
			header("location: $redirect");
			exit;
		}
		$this->load->model('user_model');
	}
	
	public function index(){
		$this->load_view('account/daily_report');
	}
	
	public function get(){
		$this->load->model('user_model');
		$timeZone = 'America/Los_Angeles';
		date_default_timezone_set($timeZone);			
		$today = date_create();
		date_sub($today, date_interval_create_from_date_string("1 days"));
		$ret = $this->user_model->get_daily_report(date_format($today, 'Y-m-d'));
		foreach($ret as $r){
			if(!isset($r['daily_report_user_id'])){
				$this->user_model->insert_daily_report(date_format($today, 'Y-m-d'), $r['users_id'], array(
					'NULL','NULL','NULL','NULL','NULL','NULL'
				));
			}
		}
		$mret = $this->user_model->get_monthly_report($today);
		$msort = $this->_sort($mret);
		$dret = $this->user_model->get_daily_report(date_format($today, 'Y-m-d'));
		$dsort = $this->_sort($dret);
		$result = array();
		$len = count($dsort);
		$color = 'red';
		$total_rank_d_last = 1;
		$total_rank_m_last = 1;
		for($i = 0; $i < $len; ++$i){
			if($i == 0){
				$total_rank_d = 1;
				$total_rank_m = 1;
			}
			else{
				if($dsort[$i]['rank'] == $dsort[$i - 1]['rank']){
					$total_rank_d = $total_rank_d_last;
				}
				else{
					$total_rank_d = $i + 1;
				}
				$total_rank_d_last = $total_rank_d;				
				if($msort[$i]['rank'] == $msort[$i - 1]['rank']){
					$total_rank_m = $total_rank_m_last;
				}
				else{
					$total_rank_m = $i + 1;
				}
				$total_rank_m_last = $total_rank_m;				
			}
			$v = array( 
				$dret[$i]['daily_report_id'],
				$dret[$i]['daily_report_name'],
				$dret[$i]['daily_report_appointment'],
				$dret[$i]['daily_report_personal_recruits'],
				$dret[$i]['daily_report_personal_products'],
				$dret[$i]['daily_report_baseshop_recruits'],
				$dret[$i]['daily_report_baseshop_products'],
				$dret[$i]['daily_report_base_elite'],
				
				'<span style="color:red">'.$total_rank_d.'</span>',
				$dsort[$i]['name'],
				(int)$dsort[$i]['data']['daily_report_personal_recruits'][0].' (<span style="color:'.$color.'">'.$dsort[$i]['data']['daily_report_personal_recruits'][1].'</span>)',
				(int)$dsort[$i]['data']['daily_report_personal_products'][0].' (<span style="color:'.$color.'">'.$dsort[$i]['data']['daily_report_personal_products'][1].'</span>)',
				(int)$dsort[$i]['data']['daily_report_baseshop_recruits'][0].' (<span style="color:'.$color.'">'.$dsort[$i]['data']['daily_report_baseshop_recruits'][1].'</span>)',
				(int)$dsort[$i]['data']['daily_report_baseshop_products'][0].' (<span style="color:'.$color.'">'.$dsort[$i]['data']['daily_report_baseshop_products'][1].'</span>)',
				$dsort[$i]['rank'],
				'<span style="color:red">'.$total_rank_m.'</span>',
				$msort[$i]['name'],
				(int)$msort[$i]['data']['daily_report_personal_recruits'][0].' (<span style="color:'.$color.'">'.$msort[$i]['data']['daily_report_personal_recruits'][1].'</span>)',
				(int)$msort[$i]['data']['daily_report_personal_products'][0].' (<span style="color:'.$color.'">'.$msort[$i]['data']['daily_report_personal_products'][1].'</span>)',
				(int)$msort[$i]['data']['daily_report_baseshop_recruits'][0].' (<span style="color:'.$color.'">'.$msort[$i]['data']['daily_report_baseshop_recruits'][1].'</span>)',
				(int)$msort[$i]['data']['daily_report_baseshop_products'][0].' (<span style="color:'.$color.'">'.$msort[$i]['data']['daily_report_baseshop_products'][1].'</span>)',
				$msort[$i]['rank'],
			);
			array_push($result, $v);
		} 

		echo json_encode($result);
	}
	
	public function update(){
		$this->load->model('user_model');
		$data_id = $this->input->post('data_id');
		$field = $this->input->post('field');
		$value = trim($this->input->post('value'));
		$value = $value == '' ? "NULL" : "'$value'";
		$this->user_model->update_daily_report($data_id, $field, $value);
		echo $data_id;
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
			'daily_report_baseshop_products'
		);
		$array = array();
		foreach($key_list as $key){
			usort($ret,function($a, $b) use ($key){
				return $b[$key] - $a[$key];
			});
			$array[$key] = array();
			foreach($ret as $i => $r){
				if(count($array[$key]) > 0){
					$count = count($array[$key]);
					$last_rank = $array[$key][$count - 1][3];
					if((int)$r[$key] == (int)$array[$key][$count - 1][2]){
						array_push($array[$key], array($r['daily_report_id'], $r['daily_report_name'], $r[$key], $last_rank));
					}
					else{
						array_push($array[$key], array($r['daily_report_id'], $r['daily_report_name'], $r[$key], count($array[$key]) + 1));
					}
				}
				else{
					array_push($array[$key], array($r['daily_report_id'], $r['daily_report_name'], $r[$key], 1));
				}
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
	
	/*public function summary(){
		$this->load->model('user_model');
		$timeZone = 'America/Los_Angeles';
		date_default_timezone_set($timeZone);			
		
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
				//((int)$msort[$i]['data']['daily_report_personal_recruits'][1] 
				//	+ $msort[$i]['data']['daily_report_personal_products'][1] 
				//	+ $msort[$i]['data']['daily_report_baseshop_recruits'][1]
				//	+ $msort[$i]['data']['daily_report_baseshop_products'][1]).' - '.$msort[$i]['rank'],
			);
			array_push($result, $v);
		} 
		echo json_encode($result);
	}*/
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */