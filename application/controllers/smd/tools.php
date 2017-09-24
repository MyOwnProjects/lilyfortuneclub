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
		try{
			$this->my_database_model->trans_begin();
			$result = $this->my_database_model->query_obj($sql);
			$affected_rows = $this->my_database_model->affected_rows();
			if($affected_rows >= 0){
				throw new Exception('Query cannot change the content.');
			}
			$this->my_database_model->trans_commit();
			echo json_encode(array('success' => true, 'result' => $result));
		}
		catch(Exception $e){
			$this->my_database_model->trans_rollback();
			echo json_encode(array('success' => false, 'message' => $e->getMessage()));
		}
	}
	
	public function elite_qualification(){
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */