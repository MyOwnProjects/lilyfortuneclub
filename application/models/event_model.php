<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Event_model extends Base_model{
	public function __construct(){
		parent::__construct();
	}
	
	public function get_events_by_date($start_date, $end_date, $user_id){
		//$sql = "SELECT e.user_id, e.events_id, e.subject, et.event_date, et.event_start_time, et.event_end_time FROM events e 
		//	INNER JOIN events_time et ON e.events_id=et.event_id AND et.event_date BETWEEN '$start_date' AND '$end_date 23:59:59'
		//	WHERE e.user_id IN ($user_id) ORDER BY e.events_id ASC, et.event_date ASC, et.event_start_time ASC";
		$sql = "
			SELECT e.*, et.event_date, et.event_start_time, et.event_end_time FROM 
			(
				SELECT e.events_id, e.subject, e.user_id FROM events e 
				INNER JOIN events_time et ON e.events_id=et.event_id AND et.event_date BETWEEN '$start_date' AND '$end_date 23:59:59'
				WHERE e.user_id IN ($user_id) GROUP BY e.events_id
			) e 
			INNER JOIN events_time et ON e.events_id=et.event_id 
			ORDER BY e.events_id ASC, et.event_date ASC, et.event_start_time ASC";
		return $this->db->query($sql);
		
	}
	
	public function get_event_by_id($user_id, $event_id){
		$sql = "SELECT e.user_id, e.events_id, e.subject, e.detail, et.event_date, et.event_start_time, et.event_end_time FROM events e 
			INNER JOIN events_time et ON e.events_id=et.event_id
			WHERE e.user_id IN ($user_id) AND e.events_id='$event_id'";
		return $this->db->query($sql);
	}
	
	public function update_event($user_id, $id, $subject, $detail, $time){
		if($id > 0){
			$sql = "SELECT * FROM events WHERE `events_id`='$id' AND `user_id`='$user_id'";
			$result = $this->db->query($sql);
			if(count($result) !== 1){
				return false;
			}
			
			$this->db->query("BEGIN");
			$sql = "UPDATE events SET `subject`='".addslashes($subject)."', `detail`='".addslashes($detail)."' WHERE `events_id`='$id'";
			if(!$this->db->query($sql)){
				$this->db->query("ROLLBACK");
				return false;
			}
			
			$sql = "DELETE FROM events_time WHERE event_id='$id'";
			if(!$this->db->query($sql)){
				$this->db->query("ROLLBACK");
				return false;
			}
			$values = array();
			foreach($time as $date_time){
				array_push($values, "('$id','".$date_time[0]."','".$date_time[1]."','".$date_time[2]."')");
			}
			$sql = "INSERT INTO `events_time` (`event_id`, `event_date`, `event_start_time`, `event_end_time`) VALUES ".implode(",", $values);
			if(!$this->db->query($sql) || $this->db->insert_id() <= 0){
				$this->db->query("ROLLBACK");
				return false;
			}
			$this->db->query("COMMIT");
			return true;
		}
		else{
			$this->db->query("BEGIN");
			$sql = "INSERT INTO `events` (`subject`,`detail`,`user_id`) VALUES ('".addslashes($subject)."','".addslashes($detail)."','$user_id')";
			if(!$this->db->query($sql)){
				$this->db->query("ROLLBACK");
				return false;
			}
			$event_id = $this->db->insert_id();
			if($event_id <= 0){
				$this->db->query("ROLLBACK");
				return false;
			}
			
			$values = array();
			foreach($time as $date_time){
				array_push($values, "('$event_id','".$date_time[0]."','".$date_time[1]."','".$date_time[2]."')");
			}
			$sql = "INSERT INTO `events_time` (`event_id`, `event_date`, `event_start_time`, `event_end_time`) VALUES ".implode(",", $values);
			if(!$this->db->query($sql) || $this->db->insert_id() <= 0){
				$this->db->query("ROLLBACK");
				return false;
			}
			$this->db->query("COMMIT");
			return $event_id;
		}
	}
	
	public function delete_event($user_id, $event_id){
			$sql = "SELECT * FROM events WHERE `events_id`='$event_id' AND `user_id`='$user_id'";
			$result = $this->db->query($sql);
			if(count($result) !== 1){
				return false;
			}
			
			$this->db->query("BEGIN");
			$sql = "DELETE FROM events_time WHERE event_id='$event_id'";
			if(!$this->db->query($sql)){
				$this->db->query("ROLLBACK");
				return false;
			}
			$sql = "DELETE FROM events WHERE events_id='$event_id'";
			if(!$this->db->query($sql)){
				$this->db->query("ROLLBACK");
				return false;
			}
			$this->db->query("COMMIT");
			return true;
	}
}