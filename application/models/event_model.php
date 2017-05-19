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
	
	public function get_list_total($where = ''){
		$sql = "SELECT COUNT(*) AS count FROM events WHERE $where AND active='Y'";
		$result = $this->db->query($sql);
		return $result[0]['count'];
	}
	
	public function get_list($where = '1=1', $order_by = null, $limit= null){
		$sql = "SELECT * FROM events e 
			LEFT JOIN 
			(
				SELECT event_guests_event_id, COUNT(*) AS event_guests FROM event_guests GROUP BY event_guests_event_id
			) t ON t.event_guests_event_id=e.events_id
			WHERE $where  AND active='Y'".(empty($order_by) ? '' : " ORDER BY ".implode(",", $order_by)).(empty($limit) ? "" : " LIMIT $limit");;
		$result = $this->db->query($sql);
		return $result;
	}
	
	public function get_events($where = "1=1"){
		$sql = "SELECT * FROM events e 
			LEFT JOIN event_guests eg ON eg.event_guests_event_id=e.events_id
			WHERE $where";
		return $this->db->query($sql);
	}
	
	public function insert_event($subject, $street, $city, $state, $zipcode, $start_time, $end_time, $detail){
		$sql = "INSERT INTO events (events_subject, events_street, events_city, events_state, events_zipcode, events_start_time, events_end_time, events_detail) 
			VALUES ('".addslashes($subject)."', '".addslashes($street)."', '".addslashes($city)."', '".addslashes($state)."', '".addslashes($zipcode)."', '".addslashes($start_time)."', '".addslashes($end_time)."', '".addslashes($detail)."')";
		return $this->db->query($sql) && $this->db->insert_id() > 0;
	}
	
	public function update_event($where, $prop){
		$values = array();
		foreach($prop as $n => $v){
			array_push($values, "$n='".addslashes($v)."'");
		}
		$sql = "UPDATE events SET ".implode(", ", $values)." WHERE $where";
		return $this->db->query($sql);
	}
	
	public function delete_events($where){
		$sql = "UPDATE events SET active='N' WHERE $where";
		return $this->db->query($sql);
	}
}