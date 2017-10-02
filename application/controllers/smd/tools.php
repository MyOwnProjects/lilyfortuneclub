<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('smd_controller.php');
class Tools extends Smd_Controller {
	private $email_templates;
	public function __construct(){
		parent::__construct();
		if(empty($this->user) || $this->user['grade'] !== 'SMD'){
			header('location: '.base_url().'smd/ac/sign_in');
		}		
		$this->nav_menus['tools']['active'] = true;
		
		$this->email_templates = array(
			'welcome_email' => array(
				'subject' => "Welcome to Lily Zhu's Team of World Financial Group",
				'body' => '<p>Welcome to Lily Zhu&#39;s team.</p><p>We have a website for our team members only, on which there are useful resources, information and tools.</p><p>To sign in the website, go to '.base_url().'ac/sign_in. The username is your WFG code, and the password is your WFG code plus your last name, all letters are capital. After you first time sign in, you are requested to change the password and email, if needed, and selected your preference.</p>'
			),
		);
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
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */