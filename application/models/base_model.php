<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('my_database_model.php');
Class Base_model extends CI_Model{
	public $db = null;
	public function __construct(){
		parent::__construct();
		$this->db = new My_database_model();
	}
}
