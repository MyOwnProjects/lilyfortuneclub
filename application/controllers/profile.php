<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller {

	public function __construct(){
		parent::__construct();
	}
	
	public function index()
	{
		$this->load->model('auth_model');
		$user = $this->auth_model->get_user();
		if(!$user || $user->authority != 'C' ){
			header('location: sign');
			exit;
		}
		$current_order = null;
		$products_count = 0;
		if(!empty($user)){
			$this->load->model('order_model');
			$current_order = $this->order_model->get_pending_orders($user->users_id);
			$products_count = $this->order_model->get_pending_orders_count($user->users_id);
		}
		
		$this->load->view('template', array('data'=>array('view'=>'current_order', 'user'=>$user, 'order'=>$current_order, 'products_count'=>$products_count)));
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */