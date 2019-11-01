<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Task_model extends Base_model{
	public function __construct(){
		parent::__construct();
	}
	
	public function get_list($where = '', $sort = array(), $limit = ''){
		$sort_array = array();
		if(is_array($sort)){
			foreach($sort as $n=> $v){
				if($n == 'tasks_due'){
					array_push($sort_array, "tasks_due_date $v");
					array_push($sort_array, "tasks_due_time $v");
				}
				else{
					array_push($sort_array, "$n $v");
				}
			}
		}
		
		$sql = "SELECT tasks.*, users.first_name, users.last_name, users.nick_name FROM tasks LEFT JOIN users ON tasks.tasks_name=users.membership_code "
			.(empty($where) ? "" : " WHERE $where ")
			.(empty($sort_array) ? "" : " ORDER BY ".implode(",", $sort_array))
			.(empty($limit) ? "" : " LIMIT $limit");
		return $this->db->query($sql);
	}
	
	public function get_list_total($where = ''){
		$sql = "SELECT COUNT(*) AS count FROM tasks "
			.(empty($where) ? "" : " WHERE $where ");
		$result = $this->db->query($sql);
		return $result[0]['count'];
	}
	
	public function insert($case_no, $name, $subject, $detail, $type, $source, $priority, $create, $due_date){
		$sql = "INSERT INTO tasks (tasks_case_no, tasks_name, tasks_subject, 
			tasks_detail, tasks_status, tasks_type, tasks_source, tasks_priority, tasks_create, tasks_due_date) 
			VALUES ('".addslashes($case_no)."', '".addslashes($name)."', '".addslashes($subject)."', 
			'".(isset($detail) ? addslashes($detail) : '')."', 'new', '$type', '$source', '$priority', 
			'$create', ".($due_date ? "'$due_date'" : 'NULL').")";
		return $this->db->query($sql) && $this->db->insert_id() > 0;
	}
	
	public function update($prop, $where){
		$set = array();
		foreach($prop as $k => $v){
			array_push($set, "$k='".addslashes($v)."'");
		}
		$sql = "UPDATE tasks SET ".implode(",", $set).(!empty($where) ? " WHERE $where" : "");
		return $this->db->query($sql);
	}
	
	public function delete($where = ''){
		$sql = "DELETE FROM tasks ".(empty($where) ? "" : " WHERE $where");
		return $this->db->query($sql);
	}
}