<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Resource_model extends Base_model{
	public function __construct(){
		parent::__construct();
	}
	
	public function get_items($where){
		$sql = "SELECT *, CONCAT(SHA1(resources_id), resources_id) AS url_id FROM resources WHERE 1=1 ".(empty($where) ? "" : " AND ($where)")." ORDER BY top ASC, resources_id DESC" ;
		return $this->db->query($sql);
	}
	
	public function get_list_total($where = ''){
		$sql = "SELECT COUNT(*) AS count FROM resources WHERE $where";
		$result = $this->db->query($sql);
		return $result[0]['count'];
	}
	
	public function get_list($where = '', $order_by = array(), $limit = ''){
		$sql = "SELECT *, CONCAT(SHA1(resources_id), resources_id) AS url_id FROM resources WHERE $where ".(empty($order_by) ? '' : " ORDER BY ".implode(",", $order_by)).(empty($limit) ? "" : " LIMIT $limit");
		return $this->db->query($sql);
	}
	
	public function insert($subject, $source, $content, $top, $language, $file_type){
		if(empty($source)){
			$sql= "INSERT INTO resources (subject, content, top, language, file_type) VALUES ('".addslashes($subject)."','".addslashes($content)."', '$top', '$language', ".(empty($file_type) ? "NULL" : "'$file_type'").")";
		}
		else{
			$sql= "INSERT INTO resources (subject, source, content, top, language, file_type) VALUES ('".addslashes($subject)."','".addslashes($source)."','".addslashes($content)."', '$top', '$language', ".(empty($file_type) ? "NULL" : "'$file_type'").")";
		}
		if(!$this->db->query($sql)){
			return false;
		}
		$insert_id = $this->db->insert_id();
		if($insert_id <= 0){
			return false;
		}
		return $insert_id;
	}

	public function update($where, $prop){
		$sql= "UPDATE resources SET ".implode(",", $prop).(empty($where) ? "" : " WHERE $where");
		return $this->db->query($sql);
	}
	
	public function delete($where = ""){
		$sql = "DELETE FROM resources ".(empty($where) ? "" : " WHERE $where");
		$this->db->query($sql);
	}
	
	public function get_prev($resource_id){
		$sql = "SELECT *, CONCAT(SHA1(resources_id), resources_id) AS url_id FROM resources WHERE resources_id > '$resource_id' ORDER BY resources_id ASC LIMIT 1";
		$result = $this->db->query($sql);
		if(count($result) == 1){
			return $result[0];
		}
	}
	
	public function get_next($resource_id){
		$sql = "SELECT *, CONCAT(SHA1(resources_id), resources_id) AS url_id FROM resources WHERE resources_id < '$resource_id' ORDER BY resources_id DESC LIMIT 1";
		$result = $this->db->query($sql);
		if(count($result) == 1){
			return $result[0];
		}
	}
	
}