<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class My_database_model extends CI_Model{
	private static $db = null;
	private $query_result;
	public function __construct(){
		parent::__construct();
		if(!self::$db)
			self::$db = $this->load->database('', true);
	}

	public function query($sql){
		$this->free_result();
		$this->query_result = self::$db->query($sql);
		if(is_object($this->query_result)){
			return $this->query_result->result_array();
		}
		else
			return $this->query_result;
	}
	
	public function list_fields(){
		return $this->query_result->list_fields();
	}
	
	public function free_result(){
		if($this->query_result){
			$this->query_result->free_result();
		}
	}
	
	public function query_obj($sql){
		$this->free_result();
		$this->query_result = self::$db->query($sql)->result_object();
		return $this->query_result;
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
		$this->query_result = $this->query('select row_count() AS count');
		return $this->query_result[0]['count'];
	}
	
	public function trans_start(){
		self::$db->trans_start();
	}
	
	public function trans_begin(){
		self::$db->trans_begin();
	}
	
	public function trans_rollback(){
		self::$db->trans_rollback();
	}
	
	public function trans_commit(){
		self::$db->trans_commit();
	}
	public function trans_complete(){
		self::$db->trans_complete();
	}
	
	public function trans_status(){
		return self::$db->trans_status();
	}
}

