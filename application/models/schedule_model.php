<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Schedule_model extends Base_model{
	public function __construct(){
		parent::__construct();
	}
	
	public function get_list($where = ''){
		$sql = "SELECT * from schedule WHERE 1=1 ".(empty($where) ? '' : " AND $where");
		return $this->db->query($sql);
	}
	
	public function insert($params){
		$fields = array();
		$values = array();
		foreach($params as $n => $v){
			array_push($fields, $n);
			array_push($values, empty($v) ? "NULL" : "'".trim($v)."'");
		}
		$sql = "INSERT INTO schedule (".implode(',', $fields).") VALUES (".implode(",", $values).")";
		$this->db->query($sql);
		return $this->db->insert_id();
	}

	public function update_schedule($params, $where){
		$set= array();
		foreach($params as $f => $v){
			$v = trim($v);
			$v = empty($v) ? "NULL" : "'$v'";
			array_push($set, "$f=$v");
		}
		$sql = "UPDATE schedule SET ".implode(",", $set)." WHERE $where";
		return $this->db->query($sql);
	}

	public function bulk_insert($fields, $values){
		if(empty($values))
			return;
		$sql = "INSERT INTO schedule (".implode(",", $fields).") VALUES ".implode(",", $values);
		$this->db->query($sql);
	}
	/*public function get_list($where = '', $sort = array(), $limit = ''){
		$sql = "SELECT schedules.*, office_name, office_address FROM schedules LEFT JOIN offices ON location=offices.offices_id"
			.(empty($where) ? "" : " WHERE $where ")
			.(empty($sort) ? "" : " ORDER BY ".implode(",", $sort))
			.(empty($limit) ? "" : " LIMIT $limit");
		return $this->db->query($sql);
	}*/
	
	public function get_list_total($where = ''){
		$sql = "SELECT COUNT(DISTINCT schedules_id) AS count FROM schedules LEFT JOIN offices ON location=offices.offices_id "
			.(empty($where) ? "" : " WHERE $where ");
		$result = $this->db->query($sql);
		return $result[0]['count'];
	}
	
	public function get_all_locations(){
		$sql = "SELECT * FROM offices ORDER BY office_name ASC";
		return $this->db->query($sql);
	}
	
	public function get_all_years(){
		$sql = "SELECT DISTINCT schedule_year AS schedule_year FROM schedules";
		$result = $this->db->query($sql);
		$ret = array();
		foreach($result as $r){
			array_push($ret, $r['schedule_year']);
		}
		sort($ret);
		return $ret;
	}

	/*public function insert($files){
		$values = array();
		foreach($files as $file){
			array_push($values, "('".$file['file']."', '".$file['schedule_date_start']."', ".(empty($file['schedule_date_end']) ? "NULL" : "'".$file['schedule_date_end']."'")
				.", ".(empty($file['location']) ? "NULL" : "'".$file['location']."'").", '".$file['access']."')");
		}
		$sql = "INSERT INTO schedules (file, schedule_date_start, schedule_date_end, location, access) VALUES ".implode(",", $values);
		return $this->db->query($sql) && $this->db->insert_id() > 0;
	}*/
	
	public function update($prop, $where){
		$set = array();
		foreach($prop as $k => $v){
			if(isset($v)){
				array_push($set, "$k='$v'");
			}
			else{
				array_push($set, "$k=NULL");
			}
		}
		$sql = "UPDATE schedules SET ".implode(",", $set).(!empty($where) ? " WHERE $where" : "");
		$this->db->query($sql);
	}
	
	public function get_all_content_types(){
		$sql = "SHOW columns FROM documents";
		$result = $this->db->query($sql); 
		foreach($result as $r){
			if($r['Field'] == 'content_type'){
				preg_match("/^enum\(\'(.*)\'\)$/", $r['Type'], $matches);
				$ret = explode("','", $matches[1]);
				return $ret;
			}
		}
		return array();
	}
	
	public function get_all_mime_content_types(){
		$sql = "SELECT distinct(mime_content_type) as mime_type FROM documents";
		$result = $this->db->query($sql);
		$ret = array();
		foreach($result as $r){
			array_push($ret, $r['mime_type']);
		}
		return $ret;
	}

	public function delete_schedule($where = ''){
		$sql = "DELETE FROM schedule WHERE 1=1 AND $where";
		return $this->db->query($sql);
		
	}
	
	public function delete($where = ''){
		$sql = "DELETE FROM schedules WHERE 1=1 AND $where";
		return $this->db->query($sql);
		
	}
	
	public function get_course_list(){
		$sql = "select * from courses ORDER BY courses_id ASC";
		return $this->db->query($sql);
	}
}