<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Events extends CI_Controller {

	public function __construct(){
		parent::__construct();
	}
	
	public function index()
	{
		$this->load->view('template', array('data' => array('view'=>'events')));
	}
}

