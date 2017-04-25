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
		
		$sql = "SELECT *, CONCAT(users.first_name,' ',users.last_name) AS tasks_user FROM tasks LEFT JOIN users ON tasks.tasks_user_id=users.users_id "
			.(empty($where) ? "" : " WHERE $where ")
			.(empty($sort_array) ? "" : " ORDER BY ".implode(",", $sort_array))
			.(empty($limit) ? "" : " LIMIT $limit");
		return $this->db->query($sql);
	}
	
	public function get_list_total($where = ''){
		$sql = "SELECT COUNT(*) AS count FROM tasks LEFT JOIN users ON tasks.tasks_user_id=users.users_id "
			.(empty($where) ? "" : " WHERE $where ");
		$result = $this->db->query($sql);
		return $result[0]['count'];
	}
	
	public function insert($user_id, $subject, $detail, $priority, $due_date, $due_time){
		$now = date_format(date_create(), 'Y-m-d H:i:s');
		$sql = "INSERT INTO tasks (tasks_user_id, tasks_subject, tasks_detail, tasks_status, tasks_priority, tasks_create, tasks_due_date, tasks_due_time, tasks_update) 
			 VALUES ('$user_id', '".addslashes($subject)."', '".(isset($detail) ? addslashes($detail) : '')."', 'new', '$priority', '$now', ".($due_date ? "'$due_date'" : 'NULL').", ".($due_time ? "'$due_time'" : 'NULL').", '$now')";
		return $this->db->query($sql) && $this->db->insert_id() > 0;
	}
	
	public function update($prop, $where){
		$now = date_format(date_create(), 'Y-m-d H:i:s');
		$set = array();
		foreach($prop as $k => $v){
			array_push($set, "$k='".addslashes($v)."'");
		}
		array_push($set, "tasks_update='$now'");
		array_push($set, "tasks_status='pending'");
		$sql = "UPDATE tasks SET ".implode(",", $set).(!empty($where) ? " WHERE $where" : "");
		return $this->db->query($sql);
	}
	
	public function delete($where = ''){
		$sql = "DELETE FROM tasks ".(empty($where) ? "" : " WHERE $where");
		return $this->db->query($sql);
	}
}