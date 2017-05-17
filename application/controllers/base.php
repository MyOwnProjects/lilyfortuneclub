<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Base_controller extends CI_Controller {
	protected $user = null;
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
	
	
	public function is_ajax(){
		return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
	}
	
	public function load_view($view, $data = array()){
		$this->load->library('user_agent');
		if(true){
		//if($this->agent->is_mobile()){
			$this->load->view('mobile/template', array_merge(array('view' => 'mobile/'.$view, 'user' => $this->user), $data));
		}
		else{
			$this->load->view('template', array_merge(array('view' => $view, 'user' => $this->user), $data));
		}
	}
	
}