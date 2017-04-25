<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Live_model extends Base_model{
	public function __construct(){
		parent::__construct();
	}
	
	public function get_list_total($where = '1=1'){
		$sql = "SELECT COUNT(*) AS count FROM LIVE WHERE $where";
		$result = $this->db->query($sql);
		return $result[0]['count'];
	}
	
	public function get_list($where = '1=1', $order_by = array(''), $limit = ''){
		$sql = "SELECT * FROM LIVE WHERE $where"
			. (empty($order_by) ? "" : " ORDER BY ".implode(",", $order_by)).
			(empty($limit) ? "" : " LIMIT $limit");
		return $this->db->query($sql);
	}

	public function insert($title, $desc, $youtube_code, $local_timezone, $start_time, $end_time, $uniqid){
		$sql = "INSERT INTO live (title, `desc`, youtube_code, local_timezone, start_time, end_time, uniqid) "
			. "VALUES ('".addslashes($title)."', '".addslashes($desc)."', '$youtube_code', '$local_timezone', "
			. " '$start_time', ".(empty($end_time) ? "NULL" : "'$end_time'").", '$uniqid')";
		return $this->db->query($sql) && $this->db->insert_id() > 0;
	}
	
}