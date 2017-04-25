<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Event extends CI_Controller {

	public function __construct(){
		parent::__construct();
	}
	
	public function index()
	{
		$id = $this->input->get('id');
		$this->load->view('template', array('data' => array('view'=>'event', 'id' => $id)));
	}
}

