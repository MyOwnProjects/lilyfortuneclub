<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Base_controller extends CI_Controller {
	protected $user = null;
	protected $navigation = array();
	protected $is_mobile;
	public function __construct(){
		parent::__construct();
		$this->load->helper('cookie');
		$this->load->library('session');
		$user_id = $this->session->userdata('session_user');
		if(empty($user_id)){
			$user_id = $this->input->cookie('session_user');
		}
		$this->load->model('user_model');
		if(!empty($user_id)){
			$this->user = $this->user_model->get_user_by_id($user_id);//array('grade' => 'SMD', 'first_name' => 'Kun', 'first_name' => 'Yang');
		}
		$this->load->library('user_agent');
		$this->is_mobile = false;//$this->agent->is_mobile();
		
		array_push($this->navigation, array(
			'text' => 'Education',
			'sub_menu' => array(
				array(
					'text' => 'Course schedule',
					'url' => 'schedule',
					'icon' => 'calendar.svg',
					'desc' => 'The face to face course schedule.'
				),
				array(
					'text' => 'Course list',
					'url' => 'courses',
					'icon' => 'instructor-lecture-with-sceen-projection-tool.svg',
					'desc' => 'The 20 courses we provided width related materials. 10 for technical, and 10 for business.'
				),
				array(
					'text' => 'Course materials',
					'url' => 'documents',
					'icon' => 'books-stack-of-three.svg',
					'desc' => 'The technical and business video and text materials.'
				),
				array(
					'text' => 'FAQ',
					'url' => 'faq',
					'icon' => 'question-mark-on-a-circular-black-background.svg',
					'desc' => 'Frequently asked questions. You can submit new question if you have.'
				),
				array(
					'text' => 'Public Resource',
					'url' => 'resource',
					'icon' => 'folded-newspaper.svg',
					'desc' => 'The articles accessible to public.'
				),
			),
		));
		array_push($this->navigation, array(
			'text' => 'Business',
			'member_access' => true,
			'sub_menu' => array(
				array(
					'text' => 'Daily report',
					'url' => 'daily_report',
					'icon' => 'diagram.svg',
					'desc' => 'Daily report every morning for all team.'
				),
				array(
					'text' => 'My team',
					'url' => 'team',
					'icon' => 'team.svg',
					'desc' => 'You team management. Personal and team recruit, the team Hierarchy.'
				),
				array(
					'text' => 'My sales',
					'url' => 'sales',
					'icon' => 'sale.svg',
					'desc' => 'You sales management. Sales status tracking.'
				),
			),
		));
		array_push($this->navigation, array(
			'text' => 'Tools',
			'sub_menu' => array(
				array(
					'text' => 'How to',
					'url' => 'how_to',
					'icon' => 'info-green.svg',
					'desc' => 'Step by step on how to sign up new members, order medical exam, process 7 pay, change business address, etc.'
				),
				array(
					'text' => 'License',
					'url' => 'license',
					'icon' => 'certificate.svg',
					'desc' => 'The specific 5 steps of license application, and exam practice. Online courses, license exam, licen application, continuing education, and provider appointment.',
				),
				array(
					'text' => 'Exam Practice',
					'url' => 'documents?content_type=license',
					'member_access' => true,
					'icon' => 'practice.svg',
					'desc' => 'Exam questions helpful to your license exam.',
				),
			),
		));
		array_push($this->navigation, array(
			'text' => 'About',
			'sub_menu' => array(
				array(
					'text' => 'About us',
					'url' => 'about',
					'icon' => 'about-us.svg',
					'desc' => 'Introduction of our team.'
				),
				array(
					'text' => 'Contact',
					'url' => 'contact',
					'icon' => 'telephone.svg',
					'desc' => 'The contact information of our team manager, and other critical members.'
				),
			),
		));
		array_push($this->navigation, array(
			'text' => 'Account',
			'sub_menu' => array(
				array(
					'text' => 'Sign in',
					'member_access' => false,
					'icon' => 'sign-in.svg',
					'url' => 'ac/sign_in',
				),
				array(
					'text' => 'SMD',
					'member_access' => true,
					'icon' => 'hierarchical-structure.svg',
					'url' => 'smd',
				),
				array(
					'text' => 'Personal info',
					'member_access' => true,
					'url' => 'profile',
					'icon' => 'man-user.svg',
					'desc' => 'Your personal information, password change, and business referrence.'
				),
				array(
					'text' => 'Sign out',
					'member_access' => true,
					'url' => 'ac/sign_out',
					'icon' => 'sign-out-option.svg',
					'desc' => 'Sign out your account.'
				),
			),
		));
	}
	
	public function not_signed_in(){
		if(empty($this->user)){
			$params = $this->input->get();
			$param_str = array();
			if(!empty($params)){
				foreach($params as $n => $v){
					array_push($param_str, "$n=$v");  
				}
			}
			$redirect = $this->uri->uri_string().(empty($param_str) ? "" : "?".implode("&", $param_str));
			return base_url().'ac/sign_in'.(empty($redirect) ? '' : "?redirect=$redirect");
		}
		else{
			return;
			$class = strtolower($this->router->fetch_class());
			if($this->user['first_access'] == 'Y'){
				if($class != 'first_access'){
					header("location: ".base_url()."first_access");
					exit;
				}
			}
			else if(!isset($this->user['preference'])){
				if($class != 'preference'){
					header("location: ".base_url()."preference");
					exit;
				}
			}
		}
	}
	
	public function set_session_user($username, $password, $save_password = false){
		$result = $this->user_model->get_user($username, $password);
		if(is_string($result)){
			unset($this->user);
			return $result;
		}
		$this->user = $result;
		$this->session->set_userdata(array('session_user' => $this->user['users_id']));
		if($save_password){
			$this->input->set_cookie('session_user', $this->user['users_id'],  time() + 86400*30);
		}
		return true;
	}

	public function unset_session_user(){
		$this->session->unset_userdata('session_user');
		delete_cookie('session_user');
	}
	
	
	public function is_ajax(){
		return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
	}
	
	public function load_view($view, $data = array()){
		if($this->is_mobile){
			$this->load->view('mobile/template', array_merge(array('view' => 'mobile/'.$view, 'user' => $this->user), $data));
		}
		else{
			$this->load->view('template', array_merge(array('view' => $view, 'user' => isset($this->user) ? $this->user : null, 'navigation' => $this->navigation), $data));
		}
	}
	
}