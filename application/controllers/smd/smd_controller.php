<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Smd_controller extends CI_Controller {
	public $mailer;
	public $email_templates;
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
				'sync_members' => array(
					'text' => 'Members Update',
				),
			),
		),
		'faq' => array(
			'text' => 'FAQ',
			'sub_menus' => array(
				'' => array(
					'text' => 'List',
				),
			),
		),
		'sales' => array(
			'text' => 'Sales',
			'sub_menus' => array(
				'' => array(
					'text' => 'List',
				),
				'new_case' => array(
					'text' => 'New Case',
				),
				'import_sales' => array(
					'text' => 'Import',
				),
			),
		),
		'schedule' => array(
			'text' => 'Schedule',
			'sub_menus' => array(
				'' => array(
					'text' => 'List'
				),
				'import' => array(
					'text' => 'Import'
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
				'daily_report' => array(
					'text' => 'Daily Report'
				),
				'generate_plan' => array(
					'text' => 'Generate Plan'
				),
				'javascript_code' => array(
					'text' => 'Javascript Code'
				),
				'group_email' => array(
					'text' => 'Group Email'
				)
			),
		),
	);
	public function __construct(){
		parent::__construct();
		$this->load->library('session');
		$this->load->library('PHPMailer');
		$this->load->helper('cookie');
		date_default_timezone_set('America/Los_Angeles');
		$user_id = $this->session->userdata('session_user');
		if(empty($user_id)){
			$user_id = $this->input->cookie('session_user');
		}
		$this->load->model('user_model');
		if(!empty($user_id)){
			$this->user = $this->user_model->get_user_by_id($user_id);//array('grade' => 'SMD', 'first_name' => 'Kun', 'first_name' => 'Yang');
		}
		$this->mailer = new PHPMailer();
		$this->mailer->IsSMTP();
		$this->mailer->Mailer = 'smtp';
		$this->mailer->SMTPAuth = true;
		$this->mailer->Host = 'smtp.gmail.com'; // "ssl://smtp.gmail.com" didn't worked
		$this->mailer->Port = 587;
		$this->mailer->SMTPSecure = 'tls';//'ssl';
		$this->mailer->SMTPDebug = 3;

		$this->mailer->Username = "lilyfortuneclub@gmail.com";
		$this->mailer->Password = "Ceo2019$";
		$this->mailer->SingleTo = true; // if you want to send a same email to multiple users. multiple emails will be sent one-by-one.
		$this->mailer->IsHTML(true); // if you are going to send HTML formatted emails
		$this->mailer->addBCC('kunyangnew@gmail.com', 'Kun Yang');
	
		$this->email_templates = array(
			'welcome_email' => array(
				'subject' => "Welcome to Lily Zhu's Team of World Financial Group",
				'body' => $this->load->view('welcome_template', array(), true)
			),
		);
	}
	
	public function set_session_user($username, $password, $save_password = false){
		$result = $this->user_model->get_user($username, $password);
		if(is_string($result)){
			unset($this->user);
		}
		else{
			$this->user = $result;
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
		if(!empty($data)){
			foreach($data as $k => $v){
				$this->view_data[$k] = $v;	
			}
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