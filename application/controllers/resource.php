<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('base.php');
class Resource extends Base_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('resource_model');
	}
	
	public function index()
	{
		//$this->load_view('resource/index');
		//return;
		$result = $this->resource_model->get_items("access = 0");
		$this->load_view('resource/index', array('resource_list' => $result));
	}
	
	public function get_list(){
		$result = $this->resource_model->get_items("access = 0");
		//header('Content-Type: application/json; charset=charset=ISO-8859-1');
		echo json_encode($result);
	}
	
	public function item($raw_id = null){
		if(!empty($raw_id)){
			$id = substr($raw_id, 40);
			if(sha1($id) == substr($raw_id, 0, 40)){
				$result = $this->resource_model->get_items("resources_id = '$id' AND access = 0");
				if(count($result) > 0){
					$this->load_view('resource/item', array('resource' => $result[0], 'web_title' => $result[0]['subject']));
					return;
				}
			}
		}
		header('location: '.base_url().'resource');
	}
}