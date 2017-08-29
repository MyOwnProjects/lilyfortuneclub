<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('account_base.php');
class Prospect extends Account_base_controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('prospect_model');
	}
	
	public function index(){
		$list = $this->prospect_model->get_list('prospects_user_id='.$this->user['users_id']);
		$this->load_view('account/prospect_list', array('list' => $list));
	}
	
	public function delete(){
		$id = $this->input->post('id');
		if($this->prospect_model->delete($id)){
			echo json_encode(array('success' => true));
		}
		else{
			echo json_encode(array('success' => false));
		}
	}
	
	public function update(){
		$id = $this->input->post('id');
		$name = trim($this->input->post('name'));
		$phone = trim($this->input->post('phone'));
		$background = trim($this->input->post('background'));
		$prop = array('prospects_name' => $name, 'prospects_phone' => $phone, 'prospects_background' => $background);
		$res = $this->prospect_model->update($id, $prop);
		echo json_encode(array('success' => $res));
	}
	
	public function add(){
		$name = trim($this->input->post('name'));
		$phone = trim($this->input->post('phone'));
		$background = trim($this->input->post('background'));
		$prop = array('prospects_user_id' => $this->user['users_id'], 'prospects_name' => $name, 'prospects_phone' => $phone, 'prospects_background' => $background);
		$id = $this->prospect_model->add($prop);
		if($id === false){
			echo json_encode(array('success' => $id));
		}
		else{
			echo json_encode(array('success' => true, 'id' => $id));
		}
	}
	
	public function pnt(){
		$list = $this->prospect_model->get_list('prospects_user_id='.$this->user['users_id']);
		$this->load_view('prospect_print', array('list' => $list));
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */