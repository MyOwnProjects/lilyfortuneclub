<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Smd_controller extends CI_Controller {
	protected $user = null;
	protected $view_data = array();
	protected $nav_menus = array(
		'account' => array(
			'text' => 'Account',
			'sub_menus' =>array(
				'' => array(
					'text' => 'Dashboard'
				),
				'profile' => array(
					'text' => 'Profile'
				),
				'password' => array(
					'text' => 'Pasword'
				),
			),
		),
		'team' => array(
			'text' => 'Team',
			'sub_menus' => array(
				'' => array(
					'text' => 'List',
				),
				'hierarchy' => array(
					'text' => 'Hierarchy',
				),
				'email' => array(
					'text' => 'Email',
				)
			),
		),
		'schedule' => array(
			'text' => 'Schedule',
			'sub_menus' => array(
				'' => array(
					'text' => 'List'
				),
			),
		),
		'documents' => array(
			'text' => 'Documents',
			'sub_menus' => array(
				'' => array(
					'text' => 'List'
				),
				'list_by_grade' => array(
					'text' => 'By Grade'
				),
				'list_by_content' => array(
					'text' => 'By Content'
				),
				'list_by_type' => array(
					'text' => 'By Type'
				),
				'create' => array(
					'text' => 'Create'
				),
			),
		),
		/*'events' => array(
			'text' => 'Events',
			'sub_menus' => array(
				'' => array(
					'text' => 'List'
				),
				'create' => array(
					'text' => 'New Event'
				),
			),
		),*/
		'resources' => array(
			'text' => 'Resources',
			'sub_menus' => array(
				'' => array(
					'text' => 'List'
				),
				'create' => array(
					'text' => 'New Resource'
				),
			),
		),
		/*'live' => array(
			'text' => 'Live',
			'sub_menus' => array(
				'' => array(
					'text' => 'List'
				),
				'create_live_event' => array(
					'text' => 'New Live Event'
				),
			),
		),*/
		'tasks'=> array(
			'text' => 'Tasks',
			'sub_menus' => array(
				'' => array(
					'text' => 'List'
				),
				'create' => array(
					'text' => 'New Task'
				),
			),
		),
		'tools' => array(
			'text' => 'Tools',
			'sub_menus' => array(
				'' => array(
					'text' => 'Direct Query'
				),
				'elite_qualification' => array(
					'text' => 'Elite Qualification'
				),
				'javascript_code' => array(
					'text' => 'Javascript Code'
				),
			),
		),
	);
	public function __construct(){
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('cookie');
		$user_id = $this->session->userdata('session_user');
		if(empty($user_id)){
			$user_id = $this->input->cookie('session_user');
		}
		$this->load->model('user_model');
		if(!empty($user_id)){
			$this->user = $this->user_model->get_user_by_id($user_id);//array('grade' => 'SMD', 'first_name' => 'Kun', 'first_name' => 'Yang');
		}
	}
	
	public function set_session_user($username, $password, $save_password = false){
		$this->user = $this->user_model->get_user($username, $password);
		if($this->user){
			$this->session->set_userdata(array('session_user' => $this->user['users_id']));
			if($save_password){
				$this->input->set_cookie('session_user', $this->user['users_id'],  time() + 86400*30);
			}
		}
	}

	public function unset_session_user(){
		$this->session->unset_userdata('session_user');
		delete_cookie('session_user');
	}
	
	protected function load_view($view, $data = array()){
		$this->view_data = array('view' => $view, 'user' => $this->user, 'nav_menus' => $this->nav_menus);
		foreach($data as $k => $v){
			$this->view_data[$k] = $v;	
		}
		$this->load->view('smd/template', $this->view_data);
	}
	
	protected function re_signin(){
		if($this->input->is_ajax_request()){
			ajax_error(403, base_url().'smd/ac/sign_in?redirect='.$this->router->fetch_class());
		}
		else{
			redirect(base_url().'smd/ac/sign_in?redirect='.$this->router->fetch_class(), 'loation');
		}
		exit;
	}
}