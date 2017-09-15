<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(getcwd().'/application/controllers/base.php');
class Account_base_controller extends Base_Controller {
	public function __construct(){
		parent::__construct();
		if(empty($this->user)){
			$params = $this->input->get();
			$param_str = array();
			if(!empty($params)){
				foreach($params as $n => $v){
					array_push($param_str, "$n=$v");  
				}
			}
			header('location: '.base_url().'ac/sign_in?redirect='.$this->uri->uri_string().(empty($param_str) ? "" : "?".implode("&", $param_str)));
			exit;
		}
		else{ 
			$class = strtolower($this->router->fetch_class());
			if($this->user['first_access'] == 'Y'){
				if($class != 'first_access'){
					header("location: ".base_url()."account/first_access");
					exit;
				}
			}
			else if(!isset($this->user['preference'])){
				if($class != 'preference'){
					header("location: ".base_url()."account/preference");
					exit;
				}
			}
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */