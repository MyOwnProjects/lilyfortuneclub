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
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */