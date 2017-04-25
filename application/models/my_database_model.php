<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class My_database_model extends CI_Model{
	private static $db = null;
	public function __construct(){
		parent::__construct();
		if(!self::$db)
			self::$db = $this->load->database('', true);
	}
	
	public function query($sql){
		$result = self::$db->query($sql);
		if(is_object($result)){
			return $result->result_array();
		}
		else
			return $result;
	}
	
	public function escape_str($value, $add_quote = true, $like = false){
		$value = self::$db->escape_str($value, $like);
		if($add_quote){
			if(is_array($value)){
				foreach($value as $k => $v){
					$value[$k] = "'".$v."'";
				}
			}
			else {
				$value = "'".$value."'";
			}
		}
		return $value;
	}
	
	public function insert_id(){
		return self::$db->insert_id();
	}
	
	public function affected_rows(){
		return self::$db->affected_rows();
	}
}

