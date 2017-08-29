<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Prospect_model extends Base_model{
	public function __construct(){
		parent::__construct();
	}
	
	public function get_list($where = ''){
		$sql = "SELECT * FROM prospects ".(empty($where) ? "" : "WHERE ".$where);
		return $this->db->query($sql);
	}
	
	public function delete($id){
		$sql = "SELECT * FROM prospects WHERE prospects_id='$id'";
		$result = $this->db->query($sql);
		if(count($result) == 0){
			return false;
		}
		$sql = "DELETE FROM prospects WHERE prospects_id='$id'";
		$this->db->query($sql);
		return true;
	}
	
	public function update($id, $prop){
		$sql = "SELECT * FROM prospects WHERE prospects_id='$id'";
		$result = $this->db->query($sql);
		if(count($result) == 0){
			return false;
		}
		$str = array();
		foreach($prop as $n => $v){
			array_push($str, "$n=".(isset($v) ? "'".addslashes($v)."'" : "NULL"));
		}
		$sql = "UPDATE prospects SET ".implode(",", $str)." WHERE prospects_id='$id'";
		$this->db->query($sql);
		return true;
	}
	
	public function add($prop){
		$name = array();
		$value = array();
		foreach($prop as $n => $v){
			array_push($name, $n);
			array_push($value, (isset($v) ? "'".addslashes($v)."'" : "NULL"));
		}
		$sql = "INSERT INTO prospects (".implode(",", $name).") VALUES (".implode(",", $value).")";
		if(!$this->db->query($sql)){
			return false;
		}
		$id = $this->db->insert_id();
		if($id <= 0){
			return false;
		}
		return $id;
	}
}