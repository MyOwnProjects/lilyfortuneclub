<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('smd_controller.php');
class Tools extends Smd_Controller {
	public function __construct(){
		parent::__construct();
		if(empty($this->user) || $this->user['grade'] !== 'SMD'){
			header('location: '.base_url().'smd/ac/sign_in');
		}		
		$this->nav_menus['tools']['active'] = true;
	}
	
	public function index()
	{
		$this->nav_menus['tools']['sub_menus']['']['active'] = true;
		$this->load_view('tools/direct_query');
	}
	
	public function direct_query(){
		$sql = $this->input->post('sql');
		$this->load->model('my_database_model');
		$this->my_database_model->trans_begin();
		try{
			$result = $this->my_database_model->query_obj($sql);
			$this->my_database_model->trans_rollback();
			echo json_encode(array('success' => true, 'result' => $result));
		}
		catch(Exception $e){
			$this->my_database_model->trans_rollback();
			echo json_encode(array('success' => false, 'message' => $e->getMessage()));
		}
		$this->my_database_model->trans_rollback();
	}
	
	public function elite_qualification(){
		$sql = "select users.membership_code, u.start_date from users INNER JOIN users u ON u.recruiter=users.membership_code where u.start_date BETWEEN '2017-04-01' AND '2017-10-01'";
		$recruiters = array();
		foreach($result as $r){
			$code = $r['recruiter_membership_code']; 
			if(!array_key_exists($code, $recruiters)){
				$recruiters[$code] = array();
				$start_date = strtotime($start_date) / 86400;
				for($date = $start_date; $date <= $start_date; $date++){
					$recruiters[$code][$date] = array('count' => 0);
				}
			}
			$recruit_date = strtotime($r['start_date']) /86400;
			array_push($recruiters[$code], array());
		}
		foreach($users as $code => $recruits){
			foreach($recruites as $r){
			}
		}
	}
	
	public function javascript_code(){
		$this->nav_menus['tools']['sub_menus']['javascript_code']['active'] = true;
		$this->load_view('tools/javascript_code');
	}
	
	/*public function update_children_count(){
		$this->load->model('user_model');
		$result = $this->user_model->get_list('', array('users_id' => 'asc'));
		$last_count = 0;
		$index = array();
		while(!empty($result)){
			if($last_count == count($result)){
				break;
			}
			$remain = array();
			foreach($result as $r){
				//echo $r['first_name'].' '.$r['last_name'].' - '.$r['recruiter'].'<br/>';
				$recruiter = $this->_find_recruiter(&$tree, $code);
				if($recruiter){
				}
				else{
					$e = array();
					foreach($r as $k => $v){
						$e[$k] =$v;
					}
					array_push($remain, $e);
				}
			}
		}
	}
	
	private function _construct_tree(&$tree){
	}
	
	private function _find_recruiter(&$tree, $code){
		
	}
	
	private function _children_count(&$node){
		$node['children_count'] = 0;
		foreach($node['children'] as $child){
			$this->_children_count($child);
			$node['children_count'] += $child['children_count'];
		}
		echo $node['name'].'('.$node['code'].') - '.$node['children_count'].'<br/>';
	}*/
	
	public function group_email(){
		$this->load->model('user_model');
		if($this->input->server('REQUEST_METHOD') == 'POST'){
			$from = $this->input->post('from');
			$to = $this->input->post('to');
			$template = $this->input->post('template');
			$subject = $this->input->post('body');
			$body = $this->input->post('body');
			$pos1 = strpos($from, '<');
			$pos2 = strpos($from, '>');
			$fromName= '';
			if($pos1 !== false && $pos2 !== false && $pos2 > $pos1){
				$fromName = substr ($from, 0, $pos1);
				$from = substr($from, $pos1 + 1, $pos2 - $pos1 - 1);
			}
			if($template != 'new'){
				$subject = $this->email_templates[$template]['subject'];
				$body = '<!DOCTYPE html><html><body>'.$this->email_templates[$template]['body'].'</body></html>';
			}
			if($to == 'all'){
				$users = $this->user_model->get_list('');
			}
			else{
				$users = $this->user_model->get_list("users_id IN ('".implode("','", $to)."')");
			}
			$to_array = array();
			foreach($users as $u){
				$email = trim($u['email']);
				if(!empty($email)){
					array_push($to_array, trim($email));
				}
			}
			//$to_array = array('kunyangnew@gmail.com', 'lilyofficemanager@gmail.com', 'lilyminzhu@gmail.com');
			$ret = send_mail($this->mailer, $from, $fromName, $to_array, $subject, $body);
			if($ret === true){
				echo json_encode(array('success' => true));
			}
			else{
				echo json_encode(array('success'=> false, 'message' => $ret));
			}
		}
		else{
			$this->nav_menus['tools']['sub_menus']['group_email']['active'] = true;
			$users = $this->user_model->get_list('', array('first_name' => 'asc', 'last_name' => 'asc', 'nick_name' => 'asc'));
			$this->load_view('tools/group_email', array('templates' => $this->email_templates, 'users' => $users));
		}
	}
	
	public function get_email_template(){
		$template = $this->input->get('template');
		if(array_key_exists($template, $this->email_templates)){
			echo json_encode($this->email_templates[$template]);
		}
		else{
			echo json_encode(array('subject' => '', 'body' => ''));
		}
	}
	
	public function debug($command){
		if($command == 'baseshop'){
		}
	}
	
	public function log_on(){
		$url = 'https://www.mywfg.com/Users/Account/LogOn?ReturnUrl=%2F';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept: text/html, application/xhtml+xml, image/jxr, */* ",
					"Accept-Encoding: gzip, deflate, br ",
					"Accept-Language: en-US, en; q=0.8, zh-Hans-CN; q=0.5, zh-Hans; q=0.3 ",
					"Cache-Control: no-cache ",
					"Connection: Keep-Alive ",
					//"Content-Length: 247 ",
					"Content-Type: application/x-www-form-urlencoded ",
					"Cookie: liveagent_oref=https://www.mywfg.com/Users/Account/AccessDenied?ReturnUrl=%2f; liveagent_vc=3; liveagent_ptid=68a60e34-6c68-4f11-ae23-286e7873e62a; __RequestVerificationToken=YOeKQk5Sf3wce6JZfYgudse6MRARelJWDvQgoq1vkjEuV-tCdU54rYXtV7VUdO3S2lzPS7R8QHjp9ln1MSbHDN76EyG4WY3jbdWUSokWhn7X-3nSYvMAqOGd7Kw5dogJQ3wj5vTPaK80yuWbo9fkfw2; TS01f938d8=01a47a43037ad5fa89f85001d2b9c17299c95d132f789abba9faf94b2dbb4eff3270b7f5659423f9652c6d6a89522b7de184c9b7d1d9bdd7bcaf32885ab94a9ce073a9a2d92babd2665b3510bc85713296b25ca3cca172bd6d0ee4de00a857fb1c662a8e8e5319c79f0453092efb77b6e8a05ec9ffe5a22582e2bd0c088f40d35aab6f311e; ASP.NET_SessionId=at1kqlju0ec2kmpbohuiagib; liveagent_sid=80f7bfcb-d31f-412f-90a4-757326102ab1; www.mywfg.com-b1P=37da45e4f52f4fc15e7311cda6b1afdc_1508394991; _ga=GA1.2.712155456.1505204933; _gid=GA1.2.1189114318.1508394992; _gat=1 ",
					"Host: www.mywfg.com ",
					"Referer: https://www.mywfg.com/Users/Account/AccessDenied?ReturnUrl=%2f ",
					"User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36 Edge/15.15063 "
				)); 
				
      	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch, CURLOPT_HEADER, 1);

		$data = array(
			//'__RequestVerificationToken' => '_l_cm9zOfAeHVC9diRyFxBTOltsKTEFXdgpF-bE0FTK5QKR-wR2ieeXnpJsYD9xnC3tuG60fWB__LqA-rGTGC6YPad-LIsee4gHutK95JhIk-b573HrDFrm4kWBwwC2-OhKFYvPLWmnSKLjsjfEjZLtLwnXPhKf6N5MjRmpS9Vk1',
			'password' => 'Beijing@2007',
			'userNameOrEmail' => '27QUE'			
		);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
echo '<html><head><meta charset="UTF-8"></head><body>';
		$response = curl_exec($ch);
		var_dump(curl_error($ch));
		var_dump(curl_errno($ch));
		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$header = substr($response, 0, $header_size);
		$body = substr($response, $header_size);
		var_dump($header_size);
		var_dump($header);
		var_dump($body);
		curl_close($ch);
		echo '</body></html>';
	}
	
	private function get_value($data, $name){
		$head = array('Age','Year','Premium','Withdrawal','Loan','Net Premium','Policy Value','Cash Surrender Value','Death Benefit');
		
		return $data[array_search($name, $head)];
	}
	
	public function generate_plan($action = null){
		if($action == 'load'){
			if($this->input->server('REQUEST_METHOD') == 'GET'){
				header('location: '.base_url().'smd/tools/generate_plan');
				return;
			}
			if(!file_exists($_FILES['file']['tmp_name'])){
				echo 'File does not exist.';
				return;
			}
			$content = file_get_contents($_FILES['file']['tmp_name']);
			$this->load_view('tools/generate_plan', array('content' => (Array)json_decode($content)));
			return;
		}
		if($this->input->server('REQUEST_METHOD') == 'POST'){
			$action = $this->input->post('action');
			$plan_descs = $this->input->post('plan-desc');
			$plan_data = $this->input->post('plan-data');
			$plan_code = $this->input->post('plan-code');
			$case_name = $this->input->post('case-name'); 
			$case_age = $this->input->post('case-age');
			$case_gender = $this->input->post('case-gender'); 
			$case_desc = $this->input->post('case-desc');
			if($action == 'save'){
				$plan_descs_new = array();
				foreach($plan_descs as $pd){
					array_push($plan_descs_new, urlencode($pd));
				}
				$save_data = array(
					'plan_descs' => $plan_descs_new,
					'plan_code' => $plan_code,
					'plan_data' => $plan_data,
					'case_name' => urlencode($case_name), 
					'case_age' => $case_age,
					'case_gender' => $case_gender, 
					'case_desc' => urlencode($case_desc)
				);
				$file_name = $case_name.'.json';
				header('Content-Type: text/csv; charset=utf-8');
				header("Content-Disposition: attachment; filename=$file_name");
				//$save_data = mb_convert_encoding(json_encode($save_data), 'UTF-8', 'UTF-8');
				$output = fopen('php://output', 'w');
				//fputs($output, chr(0xEF).chr(0xBB).chr(0xBF));
				fputs($output, json_encode($save_data));
				return;
			}
			$case_data = array(
				'code' => $plan_code, 
				'name' => $case_name, 
				'age' => $case_age, 
				'gender' => $case_gender, 
				'desc' => $case_desc, 
				'plans' => array(),
				'plan_data' => array()
			);
			foreach($plan_data as $index => $raw_data){
				$raw_data_array = explode("\n", $raw_data);
				$data = array();
				foreach($raw_data_array as $row){
					$row = explode("\t", $row);
					if(is_numeric($row[0])){
						$rn = array();
						foreach($row as $d){
							$dn = str_replace(array('$',',', ')'), '', $d);
							$dn = intval(str_replace(array('('), '-', $dn));
							array_push($rn, $dn);
						}
						array_push($data, $rn);
					}
				}
				array_push($case_data['plan_data'], $data);
				
					$premium = array(
						'start_age' => -1,
						'years' => 0,
						'amount_per_year' => 0,
						'amount_last_year' => 0
					);
					$last_premium = 0;

					$withdraw = array(
						'start_age' => -1,
						'end_age' => 100,
						'amount_per_year' => 0,
						'total_amount' => 0,
					);
					$cash_value = array();
					$withdraw_value = array();
					$death_benifit = array();
					$rate = array();
					$withdraw_total = 0;
					foreach($data as $dyear){
						$age_v = $this->get_value($dyear, 'Age');
						$premium_v = $this->get_value($dyear, 'Premium');
						if($premium_v > 0){
							if($premium['start_age'] < 0){
								$premium['start_age'] = $age_v;
							}
							if($last_premium == 0 || $premium_v == $last_premium){
								$premium['years']++;
								$premium['amount_per_year'] = $premium_v;
							}
							else{
								$premium['amount_last_year'] = $premium_v;
							}
							$last_premium = $premium_v;
						}
						$withdraw_v = $this->get_value($dyear, 'Withdrawal') + $this->get_value($dyear, 'Loan');
						if($withdraw_v > 0 && $age_v <= 100){
							if($withdraw['start_age'] < 0){
								$withdraw['start_age'] = $age_v;
								$withdraw['amount_per_year'] = $withdraw_v;
							}
							$withdraw['end_age'] = $age_v;
						}
						$withdraw['total_amount'] += $withdraw_v;
						if(in_array($age_v, array(70, 80, 90, 100))){
							$cash_value[$age_v] = $this->get_value($dyear, 'Policy Value');
							$withdraw_value[$age_v] = $withdraw['total_amount'];
							$death_benifit[$age_v] = $this->get_value($dyear, 'Death Benefit');
							$rate[$age_v] = $death_benifit[$age_v] + $withdraw['total_amount'];
						}
					}

					$plan = array(
						'premium' => $premium,
						'withdraw' => $withdraw,
						'cash_value' => $cash_value,
						'death_benifit' => $death_benifit,
						'rate' => $rate,
						'desc' => $plan_descs[$index],
						'code' => $plan_code[$index],
						'withdraw_value' => $withdraw_value
					);

					array_push($case_data['plans'], $plan);				
			}
			
			
			$this->load->view('smd/pages/plan_form', $case_data);
			//print_r($_FILES['plan-files']);
			
			//print_r($this->input->post());
			return;
		}
		$this->nav_menus['tools']['sub_menus']['generate_plan']['active'] = true;
		$this->load_view('tools/generate_plan');
		
	}

	public function commission_report(){
		$data = array();
		foreach($_FILES['case-files-commission-report']['tmp_name'] as $i => $tmp_name){
			if(!file_exists($tmp_name)){
				echo 'File '.$_FILES['case-files-commission-report']['name'][$i].' does not exist.';
				return;
			}
			$content = (Array)json_decode(file_get_contents($tmp_name));
			foreach($content['plan_code'] as $i => $plan_code){
				$sub_code1 = substr($plan_code, 0, 5);
				$sub_code2 = substr($plan_code, 6);
				$key = $sub_code1.$sub_code2;
				if(!array_key_exists($key, $data)){
					$data[$key] = array(
						'case_name' => urldecode($content['case_name']),
						'case_desc' => urldecode($content['case_desc']),
						'case_plans' => array()
					);
				}
				$data[$key]['case_plans'][$plan_code] = array(
					'plan_desc' => urldecode($content['plan_descs'][$i]),
					'plan_data' => $content['plan_data'][$i],
				);
			}
		}
		ksort($data);
		foreach($data as $key => $case){
			ksort($data[$key]);
		}
		foreach($data as $key => $case){
			$commission_premium = 9999999;
			foreach($case['case_plans'] as $code => $plan){
				$premium_total = 0;
				$rows = explode("\n", $plan['plan_data']);
				foreach($rows as $i => $row){
					$cells = explode("\t", $row); 
					$v = intval(str_replace(array('('), '-', str_replace(array('$',',', ')'), '', $cells[2])));
					if($v > 0){
						$premium_total += $v;
						if($i == 0 && $v < $commission_premium){
							$commission_premium = $v;
						}
					}
				}
				unset($data[$key]['case_plans'][$code]['plan_data']);
				$data[$key]['case_plans'][$code]['premium_total'] = $premium_total;
			}
			$data[$key]['commission'] = $commission_premium * 1.2 * 0.65 * 0.5;
		}
		$this->load->view('smd/pages/commission_report', array('data' => $data));
		return;
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */